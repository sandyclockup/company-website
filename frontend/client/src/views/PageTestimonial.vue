<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Testimonials</h2>
          <ol>
              <li><router-link :to="{ name: 'Home'}">Home</router-link></li>
            <li>Testimonials</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container">
        <div class="row">
            <template v-for="(testimonial, index) in testimonials" :key="testimonial.id">
                <div class="col-lg-6" data-aos="fade-up" :data-aos-delay="index*100">
                    <div :class="generateClasses(index)">
                        <div v-if="testimonial.image">
                          <img :src="`${backendPath}/files/${testimonial.image}`" alt="" class="testimonial-img">
                        </div>
                        <div v-else>
                          <img :src="`${publicPath}/img/user.png`" alt="" class="testimonial-img">
                        </div>
                        <h3>{{ testimonial.name }}</h3>
                        <h4>{{ testimonial.position }}</h4>
                        <p>
                          <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                            {{ testimonial.quote }}
                          <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                        </p>
                    </div>
                </div>
            </template>
        </div>
      </div>
    </section><!-- End Testimonials Section -->

  </main><!-- End #main -->

</template>
<script>
  import Swal from 'sweetalert2'
  export default {
     data () {
      return {
        publicPath: process.env.VUE_APP_BASE_URL,
        backendPath: process.env.VUE_APP_BACKEND_URL,
        testimonials: []
      }
    },
    methods: {
      generateClasses: function(index){
         if(index === 0){
            return "testimonial-item";
         }else if(index === 1){
            return "testimonial-item mt-4 mt-lg-0";
         }else{
            return "testimonial-item mt-4";
         } 
      }
    },
    mounted() {
      if(localStorage.getItem('config')){
          let config = JSON.parse(localStorage.getItem('config'));
          document.title = "Testimonial | " + config.config_site_title
      }
      
      this.$store.dispatch("page/testimonial").then((result) => {
          this.testimonials = result.data;
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

    }
  }
</script>