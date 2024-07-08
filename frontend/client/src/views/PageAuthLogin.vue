<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Sign In</h2>
          <ol>
            <li>
              <router-link :to="{ name: 'Home'}">Home</router-link>
            </li>
            <li>Sign In</li>
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
                <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>

                <div v-if="message" class="alert alert-danger" role="alert">
                    {{ message }}
                </div>

                <Form  @submit="handleLogin" :validation-schema="schema">

                  <div class="form-floating mb-3">
                    <Field name="username" v-slot="{ field, errors }">
                      <input v-bind="field" placeholder="Username Or Email" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="floatingInput">Email Or Username</label>
                    <ErrorMessage name="username" class="error invalid-feedback" />
                  </div>
                  <div class="form-floating mb-3">
                    <Field name="password" v-slot="{ field, errors }">
                        <input v-bind="field" placeholder="Password" type="password" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="floatingPassword">Password</label>
                    <ErrorMessage name="password" class="error invalid-feedback" />
                  </div>

                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberPasswordCheck">
                    <label class="form-check-label" for="rememberPasswordCheck">
                      Remember password
                    </label>
                  </div>
                  <div class="d-grid">
                     <button type="submit" id="btn-form-submit" class="btn btn-success btn-login text-uppercase fw-bold" :disabled="loading">
                        <span v-if="loading">
                            <i class="spinner-border spinner-border-sm me-2"></i>Sign In
                        </span>
                        <span v-else>
                            <i class="fas fa-sign-in-alt me-2"></i> Sign in
                        </span>
                    </button>
                  </div>

                  <div class="mt-3">
                    <div class="clearfix">
                      <div class="float-start">
                        <small>
                          <router-link class="text-primary" :to="{ name: 'AuthForgotPassword'}"> Forgot Password ?</router-link>
                        </small>
                      </div>
                      <div class="float-end">
                        <small>
                          Not a member ?
                          <router-link class="text-primary" :to="{ name: 'AuthRegister'}"> Sign up now</router-link>
                        </small>
                      </div>
                    </div>
                  </div>

                  <hr class="my-4">
                  <div class="d-grid mb-2">
                    <button class="btn btn-danger btn-login text-uppercase fw-bold" type="submit">
                      <i class="fab fa-google me-2"></i> Sign in with Google
                    </button>
                  </div>
                  <div class="d-grid">
                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                      <i class="fab fa-facebook-f me-2"></i> Sign in with Facebook
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
    export default {
        components: {
            Form,
            Field,
            ErrorMessage,
        },
        mounted() {
            if(localStorage.getItem('config')){
              let config = JSON.parse(localStorage.getItem('config'));
              document.title = "Sign In | " + config.config_site_title
            }
        },
        data(){
            const schema = yup.object().shape({
                username: yup.string().required("Username/Email is required!"),
                password: yup.string().required("Password is required!"),
            });
            return {
                loading: false,
                message: "",
                publicPath: process.env.VUE_APP_BASE_URL,
                schema,
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
            handleLogin(user) {
            this.loading = true;
            this.$store.dispatch("auth/login", user).then(() => {
                  setTimeout(()=>{
                      window.location.reload();
                  },3000);
                },
                (error) => {
                    this.loading = false;
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