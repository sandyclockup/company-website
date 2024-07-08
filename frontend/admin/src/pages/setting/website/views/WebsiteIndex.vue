<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Website</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item active">Website</li>
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
                    <i class="fas fa-edit"></i>&nbsp;Setting Website
                </h3>
            </div>
            <Form  @submit="handSubmit" :validation-schema="schema" class="form-horizontal">
                <div class="card-body">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Site Title<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_site_title" v-model="config.config_site_title"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="config_site_title" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Site Author<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_site_author" v-model="config.config_site_author"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="config_site_author" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Name<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_name" v-model="config.config_company_name"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="config_company_name" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Phone<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_phone" v-model="config.config_company_phone"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="config_company_phone" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Skype</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_skype" v-model="config.config_company_skype"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading" class="form-control">
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Facebook</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_facebook" v-model="config.config_company_facebook"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading" class="form-control">
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Twitter</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_twitter" v-model="config.config_company_twitter"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading" class="form-control">
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Instagram</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_instagram" v-model="config.config_company_instagram"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading" class="form-control">
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Linked In</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_linked_in" v-model="config.config_company_linked_in"  v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading" class="form-control">
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Email<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_email" v-model="config.config_company_email"  v-slot="{ field, errors }">
                                <input v-bind="field" type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="config_company_email" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Street Address <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_street" v-model="config.config_company_street" v-slot="{ field, errors }">
                                <textarea v-bind="field" rows="4" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                            </Field>
                            <ErrorMessage name="config_company_street" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Map <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_map" v-model="config.config_company_map" v-slot="{ field, errors }">
                                <textarea v-bind="field" rows="4" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                            </Field>
                            <ErrorMessage name="config_company_map" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Regency<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_regency" v-model="config.config_company_regency"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="config_company_regency" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Company Country<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_company_country" v-model="config.config_company_country"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="config_company_country" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Meta Tag </label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_meta_tag" v-model="config.config_meta_tag" v-slot="{ field }">
                                <textarea v-bind="field" rows="4" :readonly="loading" class="form-control"></textarea>
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Feature Description </label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_feature_description" v-model="config.config_feature_description" v-slot="{ field }">
                                <textarea v-bind="field" rows="4" :readonly="loading" class="form-control"></textarea>
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    
                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Skill Description </label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_skill_description" v-model="config.config_skill_description" v-slot="{ field }">
                                <textarea v-bind="field" rows="4" :readonly="loading" class="form-control"></textarea>
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Team Description </label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="config_team_description" v-model="config.config_team_description" v-slot="{ field }">
                                <textarea v-bind="field" rows="4" :readonly="loading" class="form-control"></textarea>
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>
                    
                    
                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">About Description </label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <ckeditor :editor="editor" v-model="config.config_about_description" :config="editorConfig"></ckeditor>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>


                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Term and Service </label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <ckeditor :editor="editor" v-model="config.config_term_of_service" :config="editorConfig"></ckeditor>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Privacy and Policy </label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <ckeditor :editor="editor" v-model="config.config_privacy_policy" :config="editorConfig"></ckeditor>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
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
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
    export default {
        components: {
            Form,
            Field,
            ErrorMessage,
        },
        data () {
            const schema = yup.object().shape({
                config_site_title: yup.string().min(5, "Must be minumum 5 characters!").required("Field is required!"),
                config_site_author: yup.string().min(5, "Must be minumum 5 characters!").required("Field is required!"),
                config_company_name: yup.string().min(5, "Must be minumum 5 characters!").required("Field is required!"),
                config_company_phone: yup.string().min(5, "Must be minumum 5 characters!").required("Field is required!"),
                config_company_email:  yup.string()
                    .required("Email is required!")
                    .email("Email is invalid!")
                    .max(50, "Must be maximum 50 characters!"),
                config_company_street: yup.string().min(5, "Must be minumum 5 characters!").required("Field is required!"),
                config_company_regency: yup.string().min(5, "Must be minumum 5 characters!").required("Field is required!"),
                config_company_country: yup.string().min(5, "Must be minumum 5 characters!").required("Field is required!"),
                config_company_map: yup.string().min(5, "Must be minumum 5 characters!").required("Field is required!"),
            });
            return {
                schema,
                loading: false,
                loadingElement: true,
                config: {},
                editor: ClassicEditor,
                editorConfig: {}
            }
        },
        mounted() {
            document.title = "Website | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("website/index", this.$route.params.id).then((result) => {
                this.loadingElement = false;
                this.config = result.data;
            },
            (error) => {
                this.loadingElement = false;
                this.message =
                    (error.response &&
                    error.response.data &&
                    error.response.data.message) ||
                    error.message ||
                    error.toString();
                    Swal.fire('Sorry, something went wrong', this.message, 'error');
                }
            )
        },
        methods: {
             handSubmit(data){
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
                this.$store.dispatch("website/update", data).then((result) => {
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