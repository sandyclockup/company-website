<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Feature</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><a href="#">Content</a></li>
                        <li class="breadcrumb-item"><router-link to="/content/feature/list">Feature</router-link></li>
                        <li class="breadcrumb-item active">Create New</li>
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
                    <i class="fas fa-edit"></i>&nbsp;Form Feature
                </h3>
            </div>
            <Form  @submit="handSubmit" :validation-schema="schema" class="form-horizontal">
                <div class="card-body">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Icon<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <Field name="icon"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="icon" class="error invalid-feedback" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
                            <div class="col-sm-10 input-form">
                              <Field name="title"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="title" class="error invalid-feedback" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10 input-form">
                            <Field name="description" v-slot="{ field, errors }">
                                <textarea v-bind="field" rows="4" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                            </Field>
                            <ErrorMessage name="description" class="error invalid-feedback" />
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sort<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                             <Field name="sort"  v-slot="{ field, errors }">
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
                           <router-link to="/content/feature/list" data-toggle="tooltip" title="Back To List" class="btn  btn-secondary">
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
                                    <i class="spinner-border spinner-border-sm mr-2"></i>Save Data
                                </span>
                                <span v-else>
                                     <i class="fa fa-save"></i>&nbsp;Save Data
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
                icon: yup.string().min(5, "Must be minumum 5 characters!").required("Icon is required!"),
                sort: yup.string().required("Sort is required!"),
                status: yup.string().required("Status is required!"),
            });
            return {
                select2_id: uuidv4(),
                publicPath: process.env.VUE_APP_BASE_URL,
                loading: false,
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
                this.loading = true;
                this.$store.dispatch("feature/create", data).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    Swal.fire('Success', this.message, 'success');
                    this.$router.push("/content/feature/read/"+result.data.id);
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
            document.title = "Feature | " + process.env.VUE_APP_TITLE
            let app = this;
            $("#"+this.select2_id).select2().on("select2:select", function (e) {
                var selected_element = $(e.currentTarget);
                var select_val = selected_element.val();
                app.optionValue = select_val;
            });
        },
        unmounted() {
            $("#"+this.select2_id).select2('destroy');
        }
    }
</script>