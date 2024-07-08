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
            <li>Reset Password</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section id="team" class="team section-bg">
      <div class="container">

        <div class="row" data-aos="fade-up">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card border-0 shadow rounded-3 my-5">
              <div class="card-body p-4 p-sm-5">
                <h5 class="card-title text-center mb-5 fw-light fs-5">Reset Password</h5>

                <div v-if="message" :class="messageType" role="alert">
                    {{ message }}
                </div>

                <Form ref="form" @submit="handleResetPassword" :validation-schema="schema">


                 

                  <div class="form-floating mb-3 input-form">
                    <Field name="email" v-slot="{ field, errors }">
                      <input v-bind="field" placeholder="Email Address" type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="floatingInput">Email Address</label>
                    <ErrorMessage name="email" class="error invalid-feedback" />
                  </div>

                  <div class="form-floating mb-3 input-form">
                     <Field name="password" v-slot="{ field, errors }">
                      <input v-bind="field" placeholder="Password" type="password" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="floatingInput">Password</label>
                    <ErrorMessage name="password" class="error invalid-feedback" />
                  </div>

                  <div class="form-floating mb-3 input-form">
                    <Field name="password_confirm" v-slot="{ field, errors }">
                      <input v-bind="field" placeholder="Password Confirmation" type="password" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="floatingInput">Password Confirmation</label>
                    <ErrorMessage name="password_confirm" class="error invalid-feedback" />
                  </div>

                 

                  <div class="d-grid">
                    <button type="submit" id="btn-form-submit" class="btn btn-success btn-login text-uppercase fw-bold" :disabled="loading">
                        <span v-if="loading">
                            <i class="spinner-border spinner-border-sm me-2"></i>Reset Password Now
                        </span>
                        <span v-else>
                            <i class="fas fa-sync me-2"></i> Reset Password Now
                        </span>
                    </button>
                  </div>

                  

                </form>
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
    export default {
        components: {
            Form,
            Field,
            ErrorMessage,
        },
        mounted() {
           if(localStorage.getItem('config')){
              let config = JSON.parse(localStorage.getItem('config'));
              document.title = "Reset Password | " + config.config_site_title
            }
        },
        data(){
            const schema = yup.object().shape({
                email: yup.string().email('Must be a valid email').max(255).required('Email is required'),
                password: yup.string().min(8).required("Password is required!"),
                password_confirm: yup.string().min(8).required("Password Confirmation is required!").oneOf([yup.ref('password'), null], 'Passwords must match')
            });
            return {
                loading: false,
                message: "",
                token: this.$route.params.token,
                messageType: "",
                publicPath: process.env.VUE_APP_BASE_URL,
                schema
            };
        },
        computed: {
            loggedIn() {
                return this.$store.state.auth.status.loggedIn;
            },
        },
        created() {
            if (this.loggedIn) {
                this.$router.push("/");
            }
        },
        methods: {
             handleResetPassword(user){
               let token = this.token;
               this.loading = true;
               this.$store.dispatch("auth/resetPassword", { user, token }).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    this.messageType = "alert alert-success";
                    setTimeout(() => this.$router.push("/auth/login") , 2000);
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
               
            },
        },
    }
</script>