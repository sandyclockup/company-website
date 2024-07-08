<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>About</h2>
          <ol>
            <li><router-link :to="{ name: 'Home'}">Home</router-link></li>
            <li>About</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us">
      <div class="container" data-aos="fade-up" v-html="config.config_about_description"></div>
    </section><!-- End About Us Section -->

    <!-- ======= Our Team Section ======= -->
    <section id="team" class="team section-bg">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Our <strong>Team</strong></h2>
          <p>{{ config.config_team_description }}</p>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" v-for="team in teams" :key="team.id">
                <div class="member" data-aos="fade-up" data-aos-delay="100">
                    <div class="member-img">
                        <div v-if="team.image">
                          <img :src="`${backendPath}/files/${team.image}`" alt="" class="img-fluid">
                        </div>
                        <div v-else>
                          <img :src="`${publicPath}/img/user.png`" alt="" class="img-fluid">
                        </div>
                        <div class="social">
                            <a :href="team.twitter"><i class="bi bi-twitter"></i></a>
                            <a :href="team.facebook"><i class="bi bi-facebook"></i></a>
                            <a :href="team.instagram"><i class="bi bi-instagram"></i></a>
                            <a :href="team.linked_in"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>{{ team.name }}</h4>
                        <span>{{ team.position_name }}</span>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </section><!-- End Our Team Section -->

    <!-- ======= Our Skills Section ======= -->
    <section id="skills" class="skills">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Our <strong>Skills</strong></h2>
          <p>{{ config.config_skill_description }}</p>
        </div>

        <div class="row skills-content">
            <div class="col-lg-6" data-aos="fade-up">
                <template v-for="(skill, index) in skills" :key="skill.id">
                    <div class="progress" v-if="index < 3">
                        <span class="skill">{{ skill.name }} <i class="val">{{ parseFloat(skill.index_ratio).toFixed(2) }}%</i></span>
                        <div class="progress-bar-wrap">
                          <div class="progress-bar" role="progressbar" :aria-valuenow="parseFloat(skill.index_ratio).toFixed(2)" aria-valuemin="0" :aria-valuemax="parseFloat(skill.index_ratio).toFixed(2)" />
                        </div>
                    </div>
                </template>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <template v-for="(skill, index) in skills" :key="skill.id">
                    <div class="progress" v-if="index >= 3">
                        <span class="skill">{{ skill.name }} <i class="val">{{ parseFloat(skill.index_ratio).toFixed(2) }}%</i></span>
                        <div class="progress-bar-wrap">
                          <div class="progress-bar" role="progressbar" :aria-valuenow="parseFloat(skill.index_ratio).toFixed(2)" aria-valuemin="0" :aria-valuemax="parseFloat(skill.index_ratio).toFixed(2)" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

      </div>
    </section><!-- End Our Skills Section -->

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

  </main>
</template>
<script>

  import Swal from 'sweetalert2'
  require('waypoints/lib/noframework.waypoints.min.js')

  export default {

    data () {
      return {
        publicPath: process.env.VUE_APP_BASE_URL,
        backendPath: process.env.VUE_APP_BACKEND_URL,
        config: {},
        customers: [],
        teams: [],
        skills: []
      }
    },

    mounted() {

      if(localStorage.getItem('config')){
        let config = JSON.parse(localStorage.getItem('config'));
        this.config = config;
        document.title = "About Us | " + config.config_site_title
      }

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

      this.$store.dispatch("page/team").then((result) => {
          this.teams = result.data;
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

      this.$store.dispatch("page/skill").then((result) => {
          this.skills = result.data;
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
<script setup>
    import { onUpdated } from 'vue'
    onUpdated(() => {
       let skilsContent = document.querySelector('.skills-content')
       if (skilsContent) {
           // eslint-disable-next-line no-undef
           new Waypoint({
            element: skilsContent,
            offset: '80%',
            handler: function() {
              let progress = [...document.querySelectorAll('.progress .progress-bar')]
              progress.forEach((el) => {
                el.style.width = el.getAttribute('aria-valuenow') + '%'
              });
            }
          })
        }
    })
</script>