<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Portfolio Details</h2>
          <ol>
            <li><router-link :to="{ name: 'Home'}">Home</router-link></li>
            <li><router-link :to="{ name: 'Portfolio'}">Portfolio</router-link></li>
            <li>Portfolio Details</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

          <div class="col-lg-8">
              <div class="portfolio-details-slider swiper">
                  <div class="swiper-wrapper align-items-center">
                      <div class="swiper-slide" v-for="image in images" :key="image.id">
                        <img v-if="image.image" :src="`${backendPath}/files${image.image.replace('uploads', '')}`" alt="">
                        <img v-else src="http://via.placeholder.com/1024x768" alt="" class="img-fluid">
                      </div>
                  </div>
                  <div class="swiper-pagination"></div>
              </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Project information</h3>
              <ul>
                <li><strong>Category</strong>: {{ portfolio.category_name }}</li>
                <li><strong>Client</strong>: {{ portfolio.customer_name }}</li>
                <li v-if="portfolio.project_date"><strong>Project date</strong>: {{ portfolio.project_date }}</li>
                <li v-if="portfolio.project_url"><strong>Project URL</strong>: <a :href="portfolio.project_url">{{ portfolio.project_url }}</a></li>
              </ul>
            </div>
            <div class="portfolio-description">
              <h2>{{ portfolio.title }}</h2>
              <p>
                {{ portfolio.description }}
              </p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->
</template>
<script>
  import moment from "moment"
  import 'swiper/swiper-bundle.min.css'
  import Swiper from 'swiper/bundle'
  export default {
     data() {
      return {
        publicPath: process.env.VUE_APP_BASE_URL,
        backendPath: process.env.VUE_APP_BACKEND_URL,
        portfolio: {},
        images: []
      }
    },
    mounted() {

        if(localStorage.getItem('config')){
          let config = JSON.parse(localStorage.getItem('config'));
          document.title = "Portfolio Details | " + config.config_site_title
        }

        let id = this.$route.params.id;
        this.$store.dispatch("page/portfolioDetail", id).then((result) => {
             this.portfolio = result.data.portfolio;
             this.images = result.data.images;
             this.portfolio.project_date =  moment(this.portfolio.project_date).format("MMMM DD, Y");
          },
          (error) => {
              this.loading = false;
              this.messageType = "alert alert-danger";
              this.message =
                  (error.response &&
                  error.response.data &&
                  error.response.data.message) ||
                  error.message ||
                  error.toString();
              }
          );

    }
  }
</script>
<script setup>
   import { onUpdated } from 'vue'
   onUpdated(() => {
       new Swiper('.portfolio-details-slider', {
            speed: 400,
            loop: true,
            autoplay: {
              delay: 5000,
              disableOnInteraction: false
            },
            pagination: {
              el: '.swiper-pagination',
              type: 'bullets',
              clickable: true
            }
          });
   })
</script>