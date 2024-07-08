<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category Tag</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><a href="#">Categories</a></li>
                        <li class="breadcrumb-item"><router-link to="/category/tag/list">Tag</router-link></li>
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
                    <i class="fas fa-edit"></i>&nbsp;Form Category Tag
                </h3>
            </div>
            <Form  @submit="handSubmit" :validation-schema="schema" class="form-horizontal">
                <div class="card-body">
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form">
                            <Field name="name" v-model="category.name" v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :disabled="!category" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="name" class="error invalid-feedback" />
                        </div> 
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10 input-form">
                            <Field name="description" v-model="category.description" v-slot="{ field }">
                                <textarea v-bind="field" rows="4" :disabled="!category" :readonly="loading" class="form-control"></textarea>
                            </Field>
                        </div> 
                    </div>
                    

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                     <div class="clearfix">
                        <div class="float-left">
                           <router-link to="/category/tag/list" data-toggle="tooltip" title="Back To List" class="btn  btn-secondary">
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
    export default {
        components: {
            Form,
            Field,
            ErrorMessage,
        },
        data(){
            const schema = yup.object().shape({
                name: yup.string().min(5, "Must be minumum 5 characters!").required("Name is required!")
            });
            return {
                category: {},
                loading: false,
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
                let id = this.$route.params.id
                this.loading = true;
                this.$store.dispatch("categoryTag/update", { id, data }).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    Swal.fire('Success', this.message, 'success');
                    this.$router.push("/category/tag/read/"+result.data.id);
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
            document.title = "Category Tag | " + process.env.VUE_APP_TITLE

            this.$store.dispatch("categoryTag/read", this.$route.params.id).then((result) => {
                this.loading = false;
                this.category = result.data;
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

        }
    }
</script>