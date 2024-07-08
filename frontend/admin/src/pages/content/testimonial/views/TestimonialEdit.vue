<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Testimonial</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><a href="#">Content</a></li>
                        <li class="breadcrumb-item"><router-link to="/content/testimonial/list">Testimonial</router-link></li>
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
                    <i class="fas fa-edit"></i>&nbsp;Form Testimonial
                </h3>
            </div>
            <Form  @submit="handSubmit" :validation-schema="schema" class="form-horizontal">
                <div class="card-body">
                    
                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Image <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                           <span v-if="imageLoading">
                                <i class="spinner-border spinner-border-sm mr-2 mt-3"></i>Generating...
                            </span>
                            <span v-else>
                                <a href="#" @click.prevent="chooseFile">
                                    <span v-if="imagePreview">
                                        <img v-bind:src="imagePreview" class="img-thumbnail" width="200" />
                                    </span>
                                    <span v-else>
                                        <img :src="`${publicPath}/img/no-image.png`" class="img-thumbnail" width="200" />
                                    </span>
                                </a>
                                <span v-if="imageMessage">
                                    <div class="clearfix"></div>
                                    <strong class="text-danger mt-2">
                                        <small>{{ imageMessage }}</small>
                                    </strong>
                                </span>
                                <Field name="file_image" v-model="fileImage" v-slot="{ field, errors }">
                                    <input v-bind="field" type="hidden" :readonly="loading" :class="errors.length == 0 ? '' : 'is-invalid'">
                                </Field>
                                <ErrorMessage name="file_image" class="error invalid-feedback" />
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Customer <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <select :readonly="loading" :id="customer_select2_id" class="form-control">
                                <option value="" selected disabled>Select a Customer</option>
                                <option v-for="row in customers" :key="row.value" :value="row.value">{{ row.text }}</option>
                            </select>
                            <Field name="customer_id" v-model="customerValue" v-slot="{ field, errors }">
                                <input v-bind="field" type="hidden" :readonly="loading" :class="errors.length == 0 ? '' : 'is-invalid'">
                            </Field>
                            <ErrorMessage name="customer_id" class="error invalid-feedback" />
                        </div> 
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">PIC Name<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <Field name="name" v-model="testimonial.name"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="name" class="error invalid-feedback" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">PIC Position<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                           <Field name="position" v-model="testimonial.position"   v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="position" class="error invalid-feedback" />
                        </div>
                    </div>

                   <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Quote <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <Field name="quote" v-model="testimonial.quote"  v-slot="{ field, errors }">
                                <textarea v-bind="field" rows="4" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                            </Field>
                            <ErrorMessage name="quote" class="error invalid-feedback" />
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sort<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <Field name="sort"  v-model="testimonial.sort"  v-slot="{ field, errors }">
                                <input v-bind="field" type="number" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="sort" class="error invalid-feedback" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <select :readonly="loading" :id="select2_id" class="form-control">
                                <option value="" selected disabled>Select a Status</option>
                                <option v-for="row in options" :key="row.value" :value="row.value">{{ row.text }}</option>
                            </select>
                            <Field name="status" v-model="optionValue" v-slot="{ field, errors }">
                                <input v-bind="field" type="hidden" :readonly="loading" :class="errors.length == 0 ? '' : 'is-invalid'">
                            </Field>
                            <ErrorMessage name="status" class="error invalid-feedback" />
                        </div> 
                    </div>
                    

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                     <div class="clearfix">
                        <div class="float-left">
                           <router-link to="/content/testimonial/list" data-toggle="tooltip" title="Back To List" class="btn  btn-secondary">
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
    import { v4 as uuidv4 } from 'uuid';
    import $ from 'jquery';
    export default {
         components: {
            Form,
            Field,
            ErrorMessage,
        },
        data () {
            const schema = yup.object().shape({
                name: yup.string().min(5, "Must be minumum 5 characters!").required("Title is required!"),
                position: yup.string().min(5, "Must be minumum 5 characters!").required("Description is required!"),
                quote: yup.string().min(5, "Must be minumum 5 characters!").required("Quote is required!"),
                customer_id: yup.string().required("Customer is required!"),
                sort: yup.string().required("Sort is required!"),
                status: yup.string().required("Status is required!"),
            });
            return {
                testimonial: {},
                select2_id: uuidv4(),
                customer_select2_id: uuidv4(),
                publicPath: process.env.VUE_APP_BASE_URL,
                imageLoading: false,
                imagePreview: "",
                imageMessage: "",
                fileImage: "",
                loading: false,
                customers: [],
                customerValue: "",
                optionValue: "",
                options: [
                    {
                        "value": 1,
                        "text": "Published"
                    },
                    {
                        "value": 0,
                        "text": "Draft"
                    }
                ],
                schema
            }
        },
       methods: {
            chooseFile(event){
                event.preventDefault();
                var app = this;
                var file_input = document.createElement('input');
                file_input.onchange = e => {
                    var fileSelected = e.target.files[0]; 
                    var fileName = fileSelected.name;
                    var fileSize = fileSelected.size;
                    var idxDot = fileName.lastIndexOf(".") + 1;
                    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                        if(parseInt(fileSize) > 2097152){
                            this.imageMessage = "File size is greater than 2MB!";
                            this.fileImage = "";
                        }else{
                            this.imageMessage = "";
                            this.imageLoading = true;
                            let files = e.target.files;
                            if (FileReader && files && files.length) {
                                var fr = new FileReader();
                                fr.onload = function () {
                                    app.imagePreview = fr.result;
                                    app.fileImage = app.imagePreview;
                                }
                                fr.readAsDataURL(files[0]);
                                this.imageLoading = false;
                            }
                        }
                    }else{
                        this.imageMessage = "Invalid file type, File type must be image !";
                        this.fileImage = "";
                    }  
                }
                file_input.type = 'file';
                file_input.accept = 'image/png, image/gif, image/jpeg';
                file_input.click();
                return false;
            },
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
                data["is_published"] = data.status;
                let id = this.$route.params.id;
                this.loading = true;
                this.$store.dispatch("testimonial/update", { id, data}).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    Swal.fire('Success', this.message, 'success');
                    this.$router.push("/content/testimonial/read/"+result.data.id);
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
            document.title = "Testimonial | " + process.env.VUE_APP_TITLE
            let app = this;
            $("#"+this.select2_id).select2().on("select2:select", function (e) {
                var selected_element = $(e.currentTarget);
                var select_val = selected_element.val();
                app.optionValue = select_val;
            });

            this.$store.dispatch("customer/dropdown").then((result) => {
                 this.customers = result;
                 $("#"+this.customer_select2_id).select2().on("select2:select", function (e) {
                    var selected_element = $(e.currentTarget);
                    var select_val = selected_element.val();
                    app.customerValue = select_val;
                });
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

            this.$store.dispatch("testimonial/read", this.$route.params.id).then((result) => {
                    this.loading = false;
                    this.testimonial = result.data;
                    this.optionValue = this.testimonial.is_published;
                    this.customerValue = this.testimonial.customer_id;
                    if(this.testimonial.image){
                        this.imagePreview = process.env.VUE_APP_BACKEND_URL+"/files/"+this.testimonial.image;
                        this.fileImage = "";
                    }
                    $("#"+this.select2_id).val(this.optionValue).trigger('change');
                    $("#"+this.customer_select2_id).val(this.customerValue).trigger('change');
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
            )

        },
        unmounted() {
            $("#"+this.select2_id).select2('destroy');
            $("#"+this.customer_select2_id).select2('destroy');
        }
    }
</script>