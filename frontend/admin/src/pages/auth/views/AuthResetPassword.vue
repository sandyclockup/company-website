<template>

    <img :src="`${publicPath}/img/logo.png`"  width="125" class="img img-responsive mx-auto d-block"/>
    
    <p class="login-box-msg mt-3">Please fill in the form below</p>

    <div v-if="message" :class="classMessage" role="alert">
        {{ message }}
    </div>

    <Form  @submit="handleResetPassword" :validation-schema="schema">
        <div class="input-group mb-3">
            <Field name="email" v-slot="{ field, errors }">
                <input v-bind="field" placeholder="Email Address" type="email" :readonly="loading"  :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
            </Field>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            <ErrorMessage name="email" class="error invalid-feedback" />
        </div>
        <div class="input-group mb-3">
            <Field name="password" v-slot="{ field, errors }">
                <input v-bind="field" placeholder="Password" type="password" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
            </Field>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            <ErrorMessage name="password" class="error invalid-feedback" />
        </div>
            <div class="input-group mb-3">
                <Field name="password_confirm" v-slot="{ field, errors }">
                <input v-bind="field" placeholder="Password Confirmation" type="password" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
            </Field>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            <ErrorMessage name="password_confirm" class="error invalid-feedback" />
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block" :disabled="loading">
                    <span v-if="loading">
                        <i class="spinner-border spinner-border-sm mr-2"></i>Reset Password
                    </span>
                    <span v-else>
                        <i class="fas fa-sync mr-2"></i>Reset Password
                    </span>
                </button>
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
                password: yup.string().min(8).required("Password is required!"),
                password_confirm: yup.string().min(8).required("Password Confirmation is required!").oneOf([yup.ref('password'), null], 'Passwords must match'),
            });
            return {
                loading: false,
                message: "",
                schema,
                token: this.$route.params.token,
                classMessage: "",
                publicPath: process.env.VUE_APP_BASE_URL,
            };
        },
        mounted() {
            document.title = "Reset Password | " + process.env.VUE_APP_TITLE
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
            handleResetPassword(user) {
                let token = this.token;
                this.loading = true;
                this.$store.dispatch("auth/resetPassword", { user, token }).then((result) => {
                    this.classMessage = "alert alert-success";
                    this.loading = false;
                    this.message = result.message;
                    setTimeout(() => this.$router.push("/") , 2000);
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