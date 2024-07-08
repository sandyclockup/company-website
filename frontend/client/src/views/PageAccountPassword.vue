<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Reset Password</h2>
          <ol>
            <li>
              <router-link :to="{ name: 'Home'}">Home</router-link>
            </li>
            <li>Account</li>
            <li>Reset Password</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Our Team Section ======= -->
    <section id="team" class="team section-bg">
      <div class="container">

        <div class="row" data-aos="fade-up">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card border-0 shadow rounded-3 my-5">
              <div class="card-body p-4 p-sm-5">
                <h5 class="card-title text-center mb-5 fw-light fs-5">Reset Password</h5>

          

                <Form  @submit="handleResetPassword" :validation-schema="schema" class="form-horizontal">
                  
                  <div class="form-floating mb-3">
                    <Field name="current_password" v-slot="{ field, errors }">
                      <input v-bind="field" placeholder="Current Password" type="password" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="current_password">Current Password</label>
                    <ErrorMessage name="current_password" class="error invalid-feedback" />
                  </div>
                  
                 <div class="form-floating mb-3">
                    <Field name="password" v-slot="{ field, errors }">
                      <input v-bind="field" placeholder="New Password" type="password" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="password">New Password</label>
                    <ErrorMessage name="password" class="error invalid-feedback" />
                  </div>

                  <div class="form-floating mb-3">
                    <Field name="password_confirm" v-slot="{ field, errors }">
                      <input v-bind="field" placeholder="New Password Confirmation" type="password" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="password_confirm">New Password Confirmation</label>
                    <ErrorMessage name="password_confirm" class="error invalid-feedback" />
                  </div>

                  <div class="d-grid">
                    <button type="submit" id="btn-form-submit" class="btn btn-success btn-login text-uppercase fw-bold" :disabled="loading">
                        <span v-if="loading">
                            <i class="spinner-border spinner-border-sm me-2"></i>Reset Password
                        </span>
                        <span v-else>
                            <i class="fas fa-refresh"></i> Reset Password
                        </span>
                    </button>
                  </div>

                </Form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Our Team Section -->

  </main>
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
                current_password: yup.string().min(8).required("Current Password is required!"),
                password: yup.string().min(8).required("Password is required!"),
                password_confirm: yup.string().min(8).required("Password Confirmation is required!").oneOf([yup.ref('password'), null], 'Passwords must match'),
            });
            return {
                loading: false,
                schema,
                publicPath: process.env.VUE_APP_BASE_URL,
            };
        },
        mounted() {
           if(localStorage.getItem('config')){
            let config = JSON.parse(localStorage.getItem('config'));
            document.title = "Change Password | " + config.config_site_title
          }
        },
        methods: {
            handleResetPassword(data) {
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
                    }
                });    
            },
            formSubmit(data){
                this.loading = true;
                this.$store.dispatch("account/changePassword", data).then((result) => {
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