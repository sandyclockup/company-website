<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Forgot Password</h2>
          <ol>
            <li>
              <router-link :to="{ name: 'Home'}">Home</router-link>
            </li>
            <li>Forgot Password</li>
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
                <h5 class="card-title text-center mb-5 fw-light fs-5">Forgot Password</h5>


                <div class="alert alert-info">
                  <small>
                    <p>Enter the email address you used when you joined and we’ll send you instructions to reset your
                      password.</p>
                    <p>
                      For security reasons, we do NOT store your password. So rest assured that we will never send your
                      password via email.
                    </p>
                  </small>
                </div>

                <div v-if="message" :class="classMessage" role="alert">
                    {{ message }}
                </div>

                <Form  @submit="handleForgotPassword" :validation-schema="schema">

                  <div class="form-floating mb-3">
                    <Field name="email" v-slot="{ field, errors }">
                        <input v-bind="field" placeholder="name@example.com" type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                    </Field>
                    <label for="floatingInput">Email Address</label>
                    <ErrorMessage name="email" class="error invalid-feedback" />
                  </div>

                  <div class="d-grid">
                    <button type="submit" id="btn-form-submit" class="btn btn-success btn-login text-uppercase fw-bold" :disabled="loading">
                        <span v-if="loading">
                            <i class="spinner-border spinner-border-sm me-2"></i>Send Reset Instructions
                        </span>
                        <span v-else>
                            <i class="fas fa-envelope me-2"></i> Send Reset Instructions
                        </span>
                    </button>
                  </div>

                  <div class="mt-3 text-center">
                    <small>
                      Not a member?
                      <router-link class="text-primary" :to="{ name: 'AuthRegister'}">Sign up now</router-link>
                    </small>
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
        data(){
            const schema = yup.object().shape({
                email: yup.string().email('Must be a valid email').max(255).required('Email is required'),
            });
            return {
                loading: false,
                message: "",
                classMessage: "",
                schema,
                publicPath: process.env.VUE_APP_BASE_URL,
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
        mounted() {
            document.title = "Forgot Password | " + process.env.VUE_APP_TITLE
        },
        methods: {
            handleForgotPassword(user,  { resetForm }) {
                this.loading = true;
                this.$store.dispatch("auth/forgotPassword", user).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    this.classMessage = "alert alert-success";
                    resetForm();
                },
                (error) => {
                    this.classMessage = "alert alert-danger";
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