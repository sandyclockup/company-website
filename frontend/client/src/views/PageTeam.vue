<template>

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Team</h2>
        <ol>
          <li>
            <router-link :to="{ name: 'Home'}">Home</router-link>
          </li>
          <li>Team</li>
        </ol>
      </div>

    </div>
  </section><!-- End Breadcrumbs -->

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

</template>
<script>
  import Swal from 'sweetalert2'
  export default {
    data() {
      return {
        publicPath: process.env.VUE_APP_BASE_URL,
        backendPath: process.env.VUE_APP_BACKEND_URL,
        config: {},
        teams: [],
      }
    },
    mounted() {
      if (localStorage.getItem('config')) {
        let config = JSON.parse(localStorage.getItem('config'));
        this.config = config;
        document.title = "Team | " + config.config_site_title
      }

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

    }
  }
</script>