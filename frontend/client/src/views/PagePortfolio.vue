<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Portfolio</h2>
          <ol>
            <li><router-link :to="{ name: 'Home'}">Home</router-link></li>
            <li>Portfolio</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">
          
          <div class="row" data-aos="fade-up">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <template v-for="category in categories" :key="category.id">
                  <li :data-filter="`.portfolio${category.id}`">{{category.name}}</li>
              </template>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container">
            <div :class="`col-lg-4 col-md-6 portfolio-item portfolio${portfolio.category_id}`" v-for="portfolio in portfolios" :key="portfolio.id">
                <img :src="`${backendPath}/files${portfolio.image.replace('uploads', '')}`" alt="" class="img-fluid">
                <div class="portfolio-info">
                    <h4>{{ portfolio.title }}</h4>
                    <p>{{ portfolio.category_name }}</p>
                    <a :href="`${backendPath}/files${portfolio.image.replace('uploads', '')}`" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title=""><i class="bx bx-plus"></i></a>
                    <router-link :to="{ name: 'PortfolioRead', params: { id: portfolio.id }}" class="details-link" title="More Details">
                        <i class="bx bx-link"></i>
                    </router-link>
                </div>
            </div>
        </div>

          
      </div>
    </section><!-- End Portfolio Section -->

  </main><!-- End #main -->
</template>
<script>

  import Swal from 'sweetalert2'
  import AOS from 'aos'
  import Isotope from 'isotope-layout'
  import GLightbox from 'glightbox'

  export default {

    mounted(){

        if(localStorage.getItem('config')){
          let config = JSON.parse(localStorage.getItem('config'));
          document.title = "Portfolio | " + config.config_site_title
        }

        this.$store.dispatch("page/portfolio").then((result) => {
              this.portfolios = result.data;
              this.categories = result.categories;
          },
          (error) => {
              this.message =
                  (error.response &&
                  error.response.data &&
                  error.response.data.message) ||
                  error.message ||
                  error.toString();
                  Swal.fire('Sorry, something went wrong', this.message, 'error');
              }
          );

    },

    data () {
        return {
          publicPath: process.env.VUE_APP_BASE_URL,
          backendPath: process.env.VUE_APP_BACKEND_URL,
          config: {},
          portfolios: [],
          categories: []
        }
      },

  }

</script>
<script setup>
  import { onUpdated } from 'vue'

  function select(el, all = false){
     el = el.trim()
      if (all) {
        return [...document.querySelectorAll(el)]
      } else {
        return document.querySelector(el)
      }
  }
  
  function on(type, el, listener, all = false){
      let selectEl = select(el, all)
      if (selectEl) {
        if (all) {
          selectEl.forEach(e => e.addEventListener(type, listener))
        } else {
          selectEl.addEventListener(type, listener)
        }
      }
  }

  onUpdated(() => {
      if(document.querySelector('.portfolio-container') && document.querySelector('.portfolio-item')){

          setTimeout(function() {

              let portfolioContainer = document.querySelector('.portfolio-container')
              let portfolioIsotope = new Isotope(portfolioContainer, {
                itemSelector: '.portfolio-item'
              });


              let portfolioFilters = [...document.querySelectorAll("#portfolio-flters li")];

              on('click', '#portfolio-flters li', function(e) {
                  e.preventDefault();
                  portfolioFilters.forEach(function(el) {
                    el.classList.remove('filter-active');
                  });
                  this.classList.add('filter-active');

                  portfolioIsotope.arrange({
                    filter: this.getAttribute('data-filter')
                  });
                  portfolioIsotope.on('arrangeComplete', function() {
                    AOS.refresh()
                  });
              }, true);

              
              GLightbox({ 
                  selector: ".portfolio-lightbox"
              });



          }, 1500);

      }

  })
</script>