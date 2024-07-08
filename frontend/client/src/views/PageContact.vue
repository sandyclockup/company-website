<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Contact</h2>
          <ol>
            <li><router-link :to="{ name: 'Home'}">Home</router-link></li>
            <li>Contact</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <div class="map-section">
      <iframe style="border:0; width: 100%; height: 350px;" :src="config.config_company_map" frameborder="0" allowfullscreen></iframe>
    </div>

    <section id="contact" class="contact">
      <div class="container">

        <div class="row justify-content-center" data-aos="fade-up">

          <div class="col-lg-10">

            <div class="info-wrap">
              <div class="row">
                <div class="col-lg-4 info">
                  <i class="bi bi-geo-alt"></i>
                  <h4>Location:</h4>
                  <p>{{ config.config_company_street }}<br>{{ config.config_company_regency }}</p>
                </div>

                <div class="col-lg-4 info mt-4 mt-lg-0">
                  <i class="bi bi-envelope"></i>
                  <h4>Email:</h4>
                  <p>{{ config.config_company_email }}</p>
                </div>

                <div class="col-lg-4 info mt-4 mt-lg-0">
                  <i class="bi bi-phone"></i>
                  <h4>Call:</h4>
                  <p>{{ config.config_company_phone }}</p>
                </div>
              </div>
            </div>

          </div>

        </div>

        <div class="row mt-5 justify-content-center" data-aos="fade-up">
          <div class="col-lg-10">
             <Form  @submit="handleSubmit" :validation-schema="schema" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <Field name="name" v-slot="{ field, errors }">
                    <input v-bind="field" placeholder="Your Name" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                  </Field>
                   <ErrorMessage name="name" class="error invalid-feedback" />
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                   <Field name="email" v-slot="{ field, errors }">
                    <input v-bind="field" placeholder="Your Email" type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                  </Field>
                   <ErrorMessage name="email" class="error invalid-feedback" />
                </div>
              </div>
              <div class="form-group mt-3">
                  <Field name="subject" v-slot="{ field, errors }"> 
                    <input v-bind="field" placeholder="Your Subject" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                  </Field>
                   <ErrorMessage name="subject" class="error invalid-feedback" />
              </div>
              <div class="form-group mt-3">
                 <Field name="message" v-slot="{ field, errors}">
                    <textarea v-bind="field" rows="4" placeholder="Your Message" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                  </Field>
                  <ErrorMessage name="message" class="error invalid-feedback" />
              </div>
              <div class="text-center">
                <button type="submit" :disabled="loading">
                    <span v-if="loading">
                        <i class="spinner-border spinner-border-sm me-2"></i>Send Message
                    </span>
                    <span v-else>
                       Send Message
                    </span>
                </button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
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
    mounted() {
     if(localStorage.getItem('config')){
        let config = JSON.parse(localStorage.getItem('config'));
        this.config = config;
        document.title = "Contact | " + config.config_site_title
      }
    },
    data(){
        const schema = yup.object().shape({
            name: yup.string().min(8).required("Name is required!"),
            email: yup.string().email('Must be a valid email').max(50).required('Email is required'),
            subject: yup.string().min(8).required("Subject is required!"),
            message: yup.string().min(8).required("Message is required!"),
        });
        return {
            loading: false,
            schema,
            publicPath: process.env.VUE_APP_BASE_URL,
            config: {}
        };
    },
    methods: {
        handleSubmit(data, { resetForm }) {
              Swal.fire({
                title: 'Confirmation',
                text: 'Do you really want to submit the form ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.formSubmit(data)
                    resetForm();
                }
            });    
        },
        formSubmit(data){
            this.loading = true;
            this.$store.dispatch("page/contactSend", data).then((result) => {
                this.loading = false;
                this.message = result.message;
                Swal.fire('Success', this.message, 'success');
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
        }
    }
  }
</script>