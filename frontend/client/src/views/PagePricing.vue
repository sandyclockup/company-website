<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Pricing</h2>
          <ol>
            <li>
              <router-link :to="{ name: 'Home'}">Home</router-link>
            </li>
            <li>Pricing</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-3 col-md-6" v-for="price in pricings" :key="price.id">
            <div :class="price.is_recomended === 1 ? `box featured` :  `box`">
              <span :class="price.is_advanced === 1 ? `advanced` :  `d-none`">Advanced</span>
              <h3>{{ price.name }}</h3>
              <h4><sup>$</sup>{{ parseFloat(price.price).toFixed(2) }}<span> / month</span></h4>
              <ul v-html="price.description"></ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Pricing Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
        </div>

        <div class="faq-list">
          <ul>
            <template v-for="(faq, index) in faqs" :key="faq.id">
              <li data-aos="fade-up">
                <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
                  :data-bs-target="`#faq-list-${faq.id}`">{{faq.question}} <i
                    class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div :id="`faq-list-${faq.id}`" :class="index === 0 ? `collapse show` : `collapse`"
                  data-bs-parent=".faq-list">
                  <p>
                    {{faq.answer}}
                  </p>
                </div>
              </li>
            </template>
          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

  </main><!-- End #main -->
</template>
<script>
  import Swal from 'sweetalert2'
  export default {
    mounted() {
      if (localStorage.getItem('config')) {
        let config = JSON.parse(localStorage.getItem('config'));
        document.title = "Pricing | " + config.config_site_title
      }

      this.$store.dispatch("page/pricing").then((result) => {
          this.pricings = result.data;
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

      this.$store.dispatch("page/faq").then((result) => {
          this.faqs = result.data;
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
    data() {
      return {
        faqs: [],
        pricings: []
      }
    }
  }
</script>