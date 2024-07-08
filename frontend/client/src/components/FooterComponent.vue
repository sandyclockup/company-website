<template>
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>{{ config.config_company_name }}</h3>
            <p>
              {{ config.config_company_street }} <br>
              {{ config.config_company_regency }}<br>
              {{ config.config_company_country }} <br><br>
              <strong>Phone:</strong> {{ config.config_company_phone }}<br>
              <strong>Email:</strong> {{ config.config_company_email }}<br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/">Home</router-link> </li>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/about">About us</router-link>  </li>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/service">Services</router-link> </li>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/term-and-support">Terms of service</router-link></li>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/privacy-policy">Privacy policy</router-link></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/service">Web Design</router-link> </li>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/service">Web Development</router-link> </li>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/service">Product Management</router-link> </li>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/service">Marketing</router-link> </li>
              <li><i class="bx bx-chevron-right"></i> <router-link to="/service">Graphic Design</router-link> </li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Join Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <Form  @submit="handleSubmit" :validation-schema="schema">
              <Field name="email" v-slot="{ field, errors }">
                <input v-bind="field" placeholder="Your Email Address" type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
              </Field>
              <ErrorMessage name="email" class="error invalid-feedback" />
              <input type="submit" value="Subscribe">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>{{ config.config_company_name }}</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          Designed by <a href="https://github.com/sandyclockup">{{ config.config_site_author }}</a>
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a :href="config.config_company_twitter" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a :href="config.config_company_facebook" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a :href="config.config_company_linked_in" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a :href="config.config_company_skype" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a :href="config.config_company_linked_in" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
</template>
<script>
  import { Form, Field, ErrorMessage } from "vee-validate";
  import * as yup from "yup";
  import Swal from 'sweetalert2'
  export default {
     components: {
        Form,
        Field,
        ErrorMessage,
    },
    data(){
        const schema = yup.object().shape({
            email: yup.string().email('Must be a valid email').max(50).required('Email is required'),
        });
        return {
            loading: false,
            schema,
            publicPath: process.env.VUE_APP_BASE_URL,
            config: {}
        };
    },
    mounted(){
      if(localStorage.getItem('config')){
          let configData = JSON.parse(localStorage.getItem('config'));
          this.config = configData;
      }
    },
    methods: {
        handleSubmit(data, { resetForm }) {
            this.loading = true;
            this.$store.dispatch("page/newsLetterSend", data).then((result) => {
                this.loading = false;
                this.message = result.message;
                Swal.fire('Success', 'Your email has been subcsribe. Thank you!', 'success');
                resetForm();
            },
            (error) => {
                this.loading = false;
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
    }
  }
</script>