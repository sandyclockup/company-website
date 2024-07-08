<template>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Email Confirmation</h2>
                    <ol>
                        <li>
                            <router-link :to="{ name: 'Home'}">Home</router-link>
                        </li>
                        <li>Email Confirmation</li>
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
                            <div class="card-body p-4 text-center" v-if="loading">
                                <i class="spinner-border spinner-border-xl"></i>
                            </div>
                            <div class="card-body p-4 p-sm-5" v-else>
                                <h5 class="card-title text-center mb-5 fw-light fs-5">Email Confirmation</h5>
                                <div class="alert alert-success text-center">
                                    <h3 class="text-center">Congratulation !</h3>
                                    <p>Your email has already been confirmed. You can now login to the application</p>
                                    <i class="fas fa-check-circle fa-7x"></i>
                                </div>
                                <router-link class="btn btn-success w-100" :to="{ name: 'AuthLogin'}">Sign In Now
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End Our Team Section -->


    </main>
</template>
<script>
    import Swal from 'sweetalert2'
    export default {
        mounted() {
            if(localStorage.getItem('config')){
                let config = JSON.parse(localStorage.getItem('config'));
                document.title = "Email Confirmation | " + config.config_site_title
            }
            this.$store.dispatch("auth/confirm", this.$route.params.token).then(() => {
                    this.loading = false;
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
        data() {
            return {
                loading: true,
                message: ""
            }
        }
    }
</script>