<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item"><router-link to="/setting/user/list">User</router-link></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                    <i class="fas fa-edit"></i>&nbsp;Form User
                </h3>
            </div>
            <Form  @submit="handleOnSubmit" :validation-schema="schema" class="form-horizontal">
                <div class="card-body">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Username<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <Field name="username" v-model="user.username"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="username" class="error invalid-feedback" />
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email Address<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <Field name="email" v-model="user.email"   v-slot="{ field, errors }">
                                <input v-bind="field" type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="email" class="error invalid-feedback" />
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Phone Number<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <Field name="phone" v-model="user.phone"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="phone" class="error invalid-feedback" />
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10 input-form">
                            <Field name="password"  v-slot="{ field }">
                                <input v-bind="field" type="password" :readonly="loading" class="form-control">
                            </Field>
                            <ErrorMessage name="password" class="error invalid-feedback" />
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Role <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <select :readonly="loading" :id="role_id" class="form-control">
                                <option value="" selected disabled>Select a Role</option>
                                <option v-for="row in roles" :key="row.value" :value="row.value">{{ row.text }}</option>
                            </select>
                            <Field name="is_admin" v-model="roleValue" v-slot="{ field, errors }">
                                <input v-bind="field" type="hidden" :readonly="loading" :class="errors.length == 0 ? '' : 'is-invalid'">
                            </Field>
                            <ErrorMessage name="is_admin" class="error invalid-feedback" />
                        </div> 
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Banned <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <select :readonly="loading" :id="banned_id" class="form-control">
                                <option value="" selected disabled>Select a Banned</option>
                                <option v-for="row in banneds" :key="row.value" :value="row.value">{{ row.text }}</option>
                            </select>
                            <Field name="is_banned" v-model="bannedValue" v-slot="{ field, errors }">
                                <input v-bind="field" type="hidden" :readonly="loading" :class="errors.length == 0 ? '' : 'is-invalid'">
                            </Field>
                            <ErrorMessage name="is_banned" class="error invalid-feedback" />
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nick Name</label>
                        <div class="col-sm-10 input-form">
                            <Field name="nick_name" v-model="person.nick_name"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading"  class="form-control">
                            </Field>
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10 input-form">
                            <Field name="full_name" v-model="person.full_name" v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading"  class="form-control">
                            </Field>
                        </div> 
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gender</label>
                         <div class="col-sm-10 input-form">
                            <select :readonly="loading" :id="gender_id" class="form-control">
                                <option value="" selected disabled>Select a Gender</option>
                                <option v-for="row in genders" :key="row.value" :value="row.value">{{ row.text }}</option>
                            </select>
                            <Field name="gender" v-model="genderValue" v-slot="{ field, errors }">
                                <input v-bind="field" type="hidden" :readonly="loading" :class="errors.length == 0 ? '' : 'is-invalid'">
                            </Field>
                            <ErrorMessage name="gender" class="error invalid-feedback" />
                        </div> 
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Birth Date</label>
                        <div class="col-sm-10 input-form">
                            <Field name="birth_date" v-model="person.birth_date" v-slot="{ field }">
                                <input v-bind="field" type="date" :readonly="loading"  class="form-control">
                            </Field>
                        </div>  
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Twitter</label>
                        <div class="col-sm-10 input-form">
                            <Field name="twitter" v-model="person.twitter"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading"  class="form-control">
                            </Field>
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Facebook</label>
                        <div class="col-sm-10 input-form">
                            <Field name="facebook" v-model="person.facebook"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading"  class="form-control">
                            </Field>
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Instagram</label>
                        <div class="col-sm-10 input-form">
                            <Field name="instagram" v-model="person.instagram"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading"  class="form-control">
                            </Field>
                        </div>  
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10 input-form">
                            <Field name="address" v-model="person.address" v-slot="{ field }">
                                <textarea v-bind="field" rows="4" :readonly="loading" class="form-control"></textarea>
                            </Field>
                        </div> 
                    </div>
                    

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                     <div class="clearfix">
                        <div class="float-left">
                           <router-link to="/setting/user/list" data-toggle="tooltip" title="Back To List" class="btn  btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Back To List
                            </router-link>
                        </div>
                        <div class="float-right">
                            <button type="reset" class="btn btn-warning text-white">
                                <i class="fa fa-sync"></i>&nbsp;Reset Form
                            </button>
                            &nbsp;
                            <button type="submit" class="btn btn-success" :disabled="loading">
                                <span v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>Update Data
                                </span>
                                <span v-else>
                                    <i class="fa fa-save"></i>&nbsp;Update Data
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</template>
<script>
    import { Form, Field, ErrorMessage } from "vee-validate";
    import * as yup from "yup";
    import Swal from "admin-lte/plugins/sweetalert2/sweetalert2.min.js";
    import { v4 as uuidv4 } from 'uuid';
    import $ from 'jquery';
    export default {
        components: {
            Form,
            Field,
            ErrorMessage,
        },
        data(){
             const schema = yup.object().shape({
                username: yup.string().min(5, "Must be minumum 5 characters!").required("Username is required!"),
                phone: yup.string().min(5, "Must be minumum 7 characters!").required("Phone Number is required!"),
                is_admin: yup.string().required("Role is required!"),
                is_banned: yup.string().required("Banned is required!"),
                email: yup
                    .string()
                    .required("Email is required!")
                    .email("Email is invalid!")
                    .max(50, "Must be maximum 50 characters!"),
            });
            return {
                loading: false,
                schema,
                gender_id: uuidv4(),
                role_id: uuidv4(),
                banned_id: uuidv4(),
                user: {},
                person: {},
                genderValue: "",
                genders: [
                    {
                        "value": 1,
                        "text": "Female"
                    },
                    {
                        "value": 2,
                        "text": "Male"
                    }
                ],
                roleValue: "",
                roles: [
                    {
                        "value": 1,
                        "text": "Admin"
                    },
                    {
                        "value": 2,
                        "text": "Guest"
                    }
                ],
                bannedValue: "",
                banneds: [
                    {
                        "value": 1,
                        "text": "Yes"
                    },
                    {
                        "value": 0,
                        "text": "No"
                    }
                ],
            }
        },
        methods: {
            
            handleOnSubmit(data){
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
                let id = this.$route.params.id;
                this.loading = true;
                this.$store.dispatch("user/update", { id, data }).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    Swal.fire('Success', this.message, 'success');
                    this.$router.push("/setting/user/read/"+id);
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

        },
        mounted() {
            document.title = "User | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("user/read", this.$route.params.id).then((result) => {  
                this.user = result.data.user;
                this.person = result.data.person;
                this.roleValue = this.user.is_admin;
                this.bannedValue = this.user.is_banned;
                this.genderValue = this.person.gender;
                $("#"+this.gender_id).val(this.genderValue).trigger('change');
                $("#"+this.role_id).val(this.roleValue).trigger('change');
                $("#"+this.banned_id).val(this.bannedValue).trigger('change');
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
            )

            let app = this;

            $("#"+this.gender_id).select2().on("select2:select", function (e) {
                var selected_element = $(e.currentTarget);
                var select_val = selected_element.val();
                app.genderValue = select_val;
            });

            $("#"+this.role_id).select2().on("select2:select", function (e) {
                var selected_element = $(e.currentTarget);
                var select_val = selected_element.val();
                app.roleValue = select_val;
            });

             $("#"+this.banned_id).select2().on("select2:select", function (e) {
                var selected_element = $(e.currentTarget);
                var select_val = selected_element.val();
                app.bannedValue = select_val;
            });

        },
        unmounted() {
            $("#"+this.gender_id).select2('destroy');
            $("#"+this.role_id).select2('destroy');
            $("#"+this.banned_id).select2('destroy');
        }
    }
</script>