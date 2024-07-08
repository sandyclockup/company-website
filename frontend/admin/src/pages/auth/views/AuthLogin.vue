<template>
    
    <img :src="`${publicPath}/img/logo.png`"  width="125" class="img img-responsive mx-auto d-block"/>
    
    <p class="login-box-msg mt-3">Please fill in the form below</p>

    <div v-if="message" class="alert alert-danger" role="alert">
        {{ message }}
    </div>

    <Form  @submit="handleLogin" :validation-schema="schema">
        <div class="input-group mb-3">
            <Field name="username" v-slot="{ field, errors }">
                <input v-bind="field" placeholder="Username Or Email" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
            </Field>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
            <ErrorMessage name="username" class="error invalid-feedback" />
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
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block" :disabled="loading">
                    <span v-if="loading">
                        <i class="spinner-border spinner-border-sm mr-2"></i>Sign In
                    </span>
                    <span v-else>
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </span>
                </button>
            </div>
            <!-- /.col -->
        </div>
    </Form>

    <div class="social-auth-links text-center mt-2 mb-3">
        <router-link to="/auth/email/forgot" class="btn-block btn bg-primary">
            <i class="fas fa-key mr-2"></i>Forgot Your Password ?
        </router-link>
    </div>

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
            document.title = "Login | " + process.env.VUE_APP_TITLE
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
                 this.$router.push("/");
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