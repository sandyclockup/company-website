<template>
    
    <img :src="`${publicPath}/img/logo.png`"  width="125" class="img img-responsive mx-auto d-block"/>
    
    <p class="login-box-msg mt-3">Please fill in the form below</p>

    <div v-if="message" :class="classMessage" role="alert">
        {{ message }}
    </div>

    <Form  @submit="handleForgotPassword" :validation-schema="schema">
        <div class="input-group mb-3">
            <Field name="email" v-slot="{ field, errors }">
                <input v-bind="field" placeholder="Email Address" type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
            </Field>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            <ErrorMessage name="email" class="error invalid-feedback" />
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block"  :disabled="loading">
                    <span v-if="loading">
                        <i class="spinner-border spinner-border-sm mr-2"></i>Send Password Reset Link
                    </span>
                    <span v-else>
                        <i class="fas fa-paper-plane mr-2"></i>Send Password Reset Link
                    </span>
                </button>
                <router-link to="/auth/login" class="btn-block btn bg-primary">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In to Application
                </router-link>
            </div>
            <!-- /.col -->
        </div>
    </Form>

  

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
            handleForgotPassword(user) {
                this.loading = true;
                this.$store.dispatch("auth/forgotPassword", user).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    this.classMessage = "alert alert-success";
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