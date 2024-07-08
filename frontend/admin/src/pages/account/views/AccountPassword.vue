<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Account</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>&nbsp;Change Password
                </h3>
            </div>
            <Form  @submit="handleResetPassword" :validation-schema="schema" class="form-horizontal">
                <div class="card-body">
                   
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Current Password<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <div class="input-group mb-3">
                                <Field name="current_password" v-slot="{ field, errors }">
                                    <input v-bind="field" type="password" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                                </Field>
                                <div class="input-group-append btn-show-password">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye-slash"></span>
                                    </div>
                                </div>
                                 <ErrorMessage name="current_password" class="error invalid-feedback" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">New Password<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <div class="input-group mb-3">
                                <Field name="password" v-slot="{ field, errors }">
                                    <input v-bind="field"  type="password" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                                </Field>
                                <div class="input-group-append btn-show-password">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye-slash"></span>
                                    </div>
                                </div>
                                <ErrorMessage name="password" class="error invalid-feedback" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">New Password Confirmation<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <div class="input-group mb-3 ">
                                 <Field name="password_confirm" v-slot="{ field, errors }">
                                    <input v-bind="field" type="password" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                                </Field>
                                <div class="input-group-append btn-show-password">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye-slash"></span>
                                    </div>
                                </div>
                                 <ErrorMessage name="password_confirm" class="error invalid-feedback" />
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="clearfix">
                        <div class="float-left">
                            <button type="reset" class="btn btn-warning text-white">
                                <i class="fa fa-sync"></i>&nbsp;Reset Form
                            </button>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-success" :disabled="loading">
                                <span v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>Save Data
                                </span>
                                <span v-else>
                                     <i class="fa fa-save"></i>&nbsp;Save Data
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.card-footer-->
            </Form>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</template>
<script>
    import { Form, Field, ErrorMessage } from "vee-validate";
    import * as yup from "yup";
    import Swal from "admin-lte/plugins/sweetalert2/sweetalert2.min.js";
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
                message: "",
                schema,
                publicPath: process.env.VUE_APP_BASE_URL,
            };
        },
        mounted() {
            document.title = "Change Password | " + process.env.VUE_APP_TITLE
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