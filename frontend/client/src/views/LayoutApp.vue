<template>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
      <HeaderComponent/>
  </header><!-- End Header -->

  <router-view />

  <!-- ======= Footer ======= -->
  <footer id="footer">
      <FooterComponent />
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>
</template>

<script>

  import HeaderComponent from '../components/HeaderComponent.vue'
  import FooterComponent from '../components/FooterComponent'
  import AOS from 'aos'
 
  export default {

    components: {
      HeaderComponent,
      FooterComponent
    },

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

        onscroll: function(el, listener){
            el.addEventListener('scroll', listener)
        },

    },

    mounted(){

        /**
        * Back to top button
        */
        let backtotop = this.select('.back-to-top')
        if (backtotop) {
          let toggleBacktotop = () => {
            if (window.scrollY > 100) {
              backtotop.classList.add('active')
            } else {
              backtotop.classList.remove('active')
            }
          }
          window.addEventListener('load', toggleBacktotop)
          this.onscroll(document, toggleBacktotop)
        }

        /**
        * Animation on scroll
        */
        AOS.init({
          duration: 1000,
          easing: 'ease-in-out',
          once: true,
          mirror: false
        })

        

    }

  }
</script>