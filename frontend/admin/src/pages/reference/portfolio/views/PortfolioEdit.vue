<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Portfolio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><a href="#">Reference</a></li>
                        <li class="breadcrumb-item"><router-link to="/reference/portfolio/list">Portfolio</router-link></li>
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
                    <i class="fas fa-edit"></i>&nbsp;Form Portfolio
                </h3>
            </div>
            <Form  @submit="handSubmit" :validation-schema="schema" class="form-horizontal">
                <div class="card-body">
                    
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
                        <label class="col-sm-2 col-form-label">Category <span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <select :readonly="loading" :id="category_select2_id" class="form-control">
                                <option value="" selected disabled>Select a Category</option>
                                <option v-for="row in categories" :key="row.value" :value="row.value">{{ row.text }}</option>
                            </select>
                            <Field name="category_id" v-model="categoryValue" v-slot="{ field, errors }">
                                <input v-bind="field" type="hidden" :readonly="loading" :class="errors.length == 0 ? '' : 'is-invalid'">
                            </Field>
                            <ErrorMessage name="category_id" class="error invalid-feedback" />
                        </div> 
                    </div>

                   <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
                            <div class="col-sm-10 input-form">
                              <Field name="title" v-model="portfolio.title"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                              </Field>
                            <ErrorMessage name="title" class="error invalid-feedback" />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Project Date<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                             <Field name="project_date" v-model="portfolio.project_date" v-slot="{ field, errors }">
                                <input v-bind="field" type="date" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                              </Field>
                            <ErrorMessage name="project_date" class="error invalid-feedback" />
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Project URL</label>
                        <div class="col-sm-10 input-form">
                            <Field name="project_url" v-model="portfolio.project_url" v-slot="{ field }">
                                <input v-bind="field" type="text" :readonly="loading" class="form-control">
                            </Field>
                            <ErrorMessage name="project_url" class="error invalid-feedback" />
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sort<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                             <Field name="sort" v-model="portfolio.sort"  v-slot="{ field, errors }">
                                <input v-bind="field" type="number" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="sort" class="error invalid-feedback" />
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10 input-form">
                            <Field name="description" v-model="portfolio.description" v-slot="{ field, errors }">
                                <textarea v-bind="field" rows="4" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                            </Field>
                            <ErrorMessage name="description" class="error invalid-feedback" />
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
                           <router-link to="/reference/portfolio/list" data-toggle="tooltip" title="Back To List" class="btn  btn-secondary">
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
        data () {
            const schema = yup.object().shape({
                title: yup.string().min(5, "Must be minumum 5 characters!").required("Title is required!"),
                project_date: yup.string().min(8, "Must be minumum 5 characters!").required("Project Date is required!"),
                category_id: yup.string().required("Category is required!"),
                customer_id: yup.string().required("Customer is required!"),
                sort: yup.string().required("Sort is required!"),
                status: yup.string().required("Status is required!"),
            });
            return {
                select2_id: uuidv4(),
                customer_select2_id: uuidv4(),
                category_select2_id: uuidv4(),
                publicPath: process.env.VUE_APP_BASE_URL,
                loading: false,
                portfolio: {},
                categories: [],
                categoryValue: "",
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
                this.$store.dispatch("portfolio/update", { id, data }).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    Swal.fire('Success', this.message, 'success');
                    this.$router.push("/reference/portfolio/read/"+result.data.id);
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

            document.title = "Portfolio | " + process.env.VUE_APP_TITLE

            let app = this;
            $("#"+this.select2_id).select2().on("select2:select", function (e) {
                var selected_element = $(e.currentTarget);
                var select_val = selected_element.val();
                app.optionValue = select_val;
            });
        

            this.$store.dispatch("categoryPortfolio/dropdown").then((result) => {
                this.categories = result;
                 $("#"+this.category_select2_id).select2().on("select2:select", function (e) {
                    var selected_element = $(e.currentTarget);
                    var select_val = selected_element.val();
                    app.categoryValue = select_val;
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

            this.$store.dispatch("portfolio/read", this.$route.params.id).then((result) => {
                this.portfolio = result.data;
                this.optionValue = this.portfolio.is_published;
                this.customerValue = this.portfolio.customer_id;
                this.categoryValue = this.portfolio.category_id;
                $("#"+this.select2_id).val(this.optionValue).trigger('change');
                $("#"+this.customer_select2_id).val(this.customerValue).trigger('change');
                $("#"+this.category_select2_id).val(this.categoryValue).trigger('change');
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

        },
        unmounted() {
            $("#"+this.select2_id).select2('destroy');
            $("#"+this.customer_select2_id).select2('destroy');
            $("#"+this.category_select2_id).select2('destroy');
        }
    }
</script>