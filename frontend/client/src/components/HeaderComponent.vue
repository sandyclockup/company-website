<template>
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto">
        <router-link to="/">
          <span>{{ config.config_site_title }}</span>
        </router-link>
      </h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li>
              <router-link to="/" @click="active = 'home'" :class="{active:active === 'home'}">Home</router-link>
          </li>

          <li class="dropdown"><a href="#" :class="{active:active === 'about' || active === 'team' || active === 'testimonial' }"><span>About</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><router-link to="/about" @click="active = 'about'" >About Us</router-link></li>
              <li><router-link to="/team" @click="active = 'team'">Team</router-link></li>
              <li><router-link to="/testimonial" @click="active = 'testimonial'">Testimonial</router-link></li>
            </ul>
          </li>

          <li><router-link to="/service" @click="active = 'service'" :class="{active:active === 'service'}">Service</router-link></li>
          <li><router-link to="/portfolio" @click="active = 'portfolio'" :class="{active:active === 'portfolio'}">Portfolio</router-link></li>
          <li><router-link to="/pricing" @click="active = 'pricing'" :class="{active:active === 'pricing'}">Pricing</router-link></li>
          <li><router-link to="/blog" @click="active = 'blog'" :class="{active:active === 'blog'}">Blog</router-link></li>
          <li><router-link to="/contact" @click="active = 'contact'" :class="{active:active === 'contact'}">Contact</router-link></li>

          <template v-if="Auth">
             <li class="dropdown"><a href="#" :class="{active:active === 'profile' || active === 'password' || active === 'notification' }"><span>Account</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                    <li><router-link to="/account/profile" @click="active = 'profile'">My Profile</router-link></li>
                    <li><router-link to="/account/password" @click="active = 'password'">Change Password</router-link></li>
                    <li><router-link to="/account/notification" @click="active = 'notification'">Notification</router-link></li>
                    <li><a v-on:click.prevent="logout()" href="/">Log Out</a></li>
                </ul>
            </li>
          </template>
          <template v-else>
             <li class="dropdown"><a href="#" :class="{active:active === 'login' || active === 'register' }"><span>Account</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                    <li><router-link to="/auth/login" @click="active = 'login'">Sign In</router-link></li>
                    <li><router-link to="/auth/register" @click="active = 'register'">Create Account</router-link></li>
                </ul>
            </li>
          </template>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <div class="header-social-links d-flex">
          <a :href="config.config_company_twitter" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a :href="config.config_company_facebook" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a :href="config.config_company_linked_in" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a :href="config.config_company_skype" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a :href="config.config_company_linked_in" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>

    </div>
</template>
<script>
    export default{

        methods: {

          select: function(el, all = false){
              el = el.trim()
              if (all) {
                  return [...document.querySelectorAll(el)]
              } else {
                  return document.querySelector(el)
              }
          },

          on: function (type, el, listener, all = false){
              let selectEl = this.select(el, all)
              if (selectEl) {
                if (all) {
                  selectEl.forEach(e => e.addEventListener(type, listener))
                } else {
                  selectEl.addEventListener(type, listener)
                }
              }
          },


          logout: function logout(){
              this.$store.dispatch('auth/logout');
              setTimeout(()=>{
                window.location.href = '/'
              },1500);
          }

        },

        data () {
            return {
                siteTitle: process.env.VUE_APP_TITLE,
                Auth: false,
                active: 'home',
                config: {}
            }
        },

        mounted(){

          /**
          * Mobile nav toggle
          */
          this.on('click', '.mobile-nav-toggle', function() {
            document.querySelector("#navbar").classList.toggle('navbar-mobile')
            this.classList.toggle('bi-list')
            this.classList.toggle('bi-x')
          })

          /**
          * Mobile nav dropdowns activate
          */
          this.on('click', '.navbar .dropdown > a', function(e) {
            if (document.querySelector('#navbar').classList.contains('navbar-mobile')) {
              e.preventDefault()
              this.nextElementSibling.classList.toggle('dropdown-active')
            }
          }, true)

          let user = JSON.parse(localStorage.getItem('user'));
          if(user){ this.Auth = true; }

          if(localStorage.getItem('config')){
              let configData = JSON.parse(localStorage.getItem('config'));
              this.config = configData;
          }

        }

    }
</script>