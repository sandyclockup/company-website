<template>

  <SliderComponent />

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us">
      <div class="container" data-aos="fade-up" v-html="config.config_about_description"></div>
    </section><!-- End About Us Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">
        <div class="row">
            <div :class="serviceClasses(index)" data-aos="zoom-in" data-aos-delay="100" v-for="(service, index) in services" :key="service.id">
               <div :class="`icon-box ${randomIcon()}`">
                  <div class="icon">
                    <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                      <path stroke="none" stroke-width="0" :fill="randomColor()"
                        d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174">
                      </path>
                    </svg>
                    <i :class="service.icon"></i>
                  </div>
                  <h4><a href="#">{{ service.title }}</a></h4>
                  <p>{{ service.description }}</p>
                </div>
            </div>  
        </div>
      </div>
    </section><!-- End Services Section -->

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

    <!-- ======= Our Clients Section ======= -->
    <section id="clients" class="clients">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Clients</h2>
        </div>

        <div class="row no-gutters clients-wrap clearfix" data-aos="fade-up">
           <div class="col-lg-3 col-md-4 col-6" v-for="customer in customers" :key="customer.id">
            <div class="client-logo" v-if="customer.image">
              <img :src="`${backendPath}/files/${customer.image}`" alt="" class="img-fluid">
            </div>
            <div class="client-logo" v-else>
              <img src="http://via.placeholder.com/1024x768" alt="" class="img-fluid">
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Our Clients Section -->

  </main><!-- End #main -->

  
</template>

<script>
  
  import SliderComponent from "../components/SliderComponent.vue"
  import Swal from 'sweetalert2'
  import AOS from 'aos'
  import Isotope from 'isotope-layout'
  import GLightbox from 'glightbox'

  export default {

      components: {
         SliderComponent,
      },

      methods:{

        randomIcon: function(){
           let icons = ["iconbox-blue", "iconbox-orange", "iconbox-pink", "iconbox-yellow", "iconbox-red", "iconbox-teal"];
           let rand = icons[(Math.random() * icons.length) | 0]
           return rand;
        },

        randomColor: function(){
          return "#"+Math.floor(Math.random()*16777215).toString(16);
        },

        serviceClasses: function(index){
          if(index === 2){
            return "col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0";
          }else if(index > 2){
            return "col-lg-4 col-md-6 d-flex align-items-stretch mt-4";
          }else{
            return "col-lg-4 col-md-6 d-flex align-items-stretch";
          }
        },
        
        
         select: function (el, all = false) {
          el = el.trim()
          if (all) {
            return [...document.querySelectorAll(el)]
          } else {
            return document.querySelector(el)
          }
        },
        

      },

      mounted(){

       if(localStorage.getItem('config')){
          let config = JSON.parse(localStorage.getItem('config'));
          this.config = config;
          document.title = "Home | " + config.config_site_title
        }
        
        this.$store.dispatch("page/service").then((result) => {
              this.services = result.data;
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

        this.$store.dispatch("page/customer").then((result) => {
              this.customers = result.data;
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
         
          

        // end mounted
      },

     
      data () {
        return {
          publicPath: process.env.VUE_APP_BASE_URL,
          backendPath: process.env.VUE_APP_BACKEND_URL,
          config: {},
          services: [],
          customers: [],
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



          }, 3000);

      }

  })
</script>