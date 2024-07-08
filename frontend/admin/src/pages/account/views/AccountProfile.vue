<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blank Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
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
                    <i class="fas fa-edit"></i>&nbsp;Change Profile
                </h3>
            </div>
             <Form  @submit="handSubmit" :validation-schema="schema" class="form-horizontal">
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Profile Image</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <span v-if="loadingUpload">
                                <i class="spinner-border spinner-border-sm mr-2 mt-3"></i>Uploading...
                            </span>
                            <span v-else>
                                <a href="#" @click.prevent="chooseFile">
                                    <img :src="imageUser" class="img-thumbnail" width="200" />
                                </a>
                                <span v-if="messageUpload">
                                    <div class="clearfix"></div>
                                    <strong class="text-danger mt-2">
                                        <small>{{ messageUpload }}</small>
                                    </strong>
                                </span>
                            </span>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Username<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="username" v-model="user.username" v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="username" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email Address<span class="text-danger">*</span></label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="email" v-model="user.email" v-slot="{ field, errors }">
                                <input v-bind="field" type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="email" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                             <Field name="phone" v-model="user.phone" v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="phone" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nick Name</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="nick_name" v-model="person.nick_name" v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="nick_name" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                             <Field name="full_name" v-model="person.full_name" v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="full_name" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field v-model="person.gender"  name="gender" :readonly="loading" class="form-control" as="select">
                                <option value="0" disabled>Select a Gender</option>
                                <option v-for="gender in genders" :key="gender.value" :value="gender.value">{{ gender.text }}</option>
                            </Field>
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Birth Date</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="birth_date" v-model="person.birth_date" v-slot="{ field, errors }">
                                <input v-bind="field" type="date" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="birth_date" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Twitter</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="twitter" v-model="person.twitter" v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="twitter" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Facebook</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                             <Field name="facebook" v-model="person.facebook" v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="facebook" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Instagram</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="instagram" v-model="person.instagram" v-slot="{ field, errors }">
                                <input v-bind="field" type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                            </Field>
                            <ErrorMessage name="instagram" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="address" v-model="person.address" v-slot="{ field, errors }">
                                <textarea v-bind="field" rows="4" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                            </Field>
                            <ErrorMessage name="address" class="error invalid-feedback" />
                        </div> 
                        <div class="col-sm-10 input-form" v-else>
                            <span class="form-control-static">
                                <i class="spinner-border spinner-border-sm"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">About Me</label>
                        <div class="col-sm-10 input-form" v-if="!loadingElement">
                            <Field name="about_me" v-model="person.about_me" v-slot="{ field, errors }">
                                <textarea v-bind="field" rows="4" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'"></textarea>
                            </Field>
                            <ErrorMessage name="about_me" class="error invalid-feedback" />
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
        data () {
            const schema = yup.object().shape({
                username: yup.string().min(5, "Must be minumum 5 characters!").required("Username is required!"),
                email: yup
                    .string()
                    .required("Email is required!")
                    .email("Email is invalid!")
                    .max(50, "Must be maximum 50 characters!"),
            });
            return {
                publicPath: process.env.VUE_APP_BASE_URL,
                loading: false,
                loadingUpload: false,
                loadingElement: false,
                imageUser: process.env.VUE_APP_BASE_URL+"/img/user.png",
                user: {},
                person: {},
                genders: [
                    {
                        "value": 1,
                        "text": "Male"
                    },
                    {
                        "value": 2,
                        "text": "Female"
                    }
                ],
                message: "",
                messageUpload: "",
                schema,
            }
        },
        mounted() {
            document.title = "Change Profile | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("account/profile").then((result) => {
                this.loadingElement = false;
                this.user = result.data.user;
                this.person = result.data.person;
                if(!this.isEmptyOrSpaces(result.data.person.image)){
                    this.imageUser = process.env.VUE_APP_BACKEND_URL+"/files/"+result.data.person.image;
                }
            })
        },
        methods: {
            chooseFile(event){
                event.preventDefault();
                var file_input = document.createElement('input');
                file_input.onchange = e => {
                    var fileSelected = e.target.files[0]; 
                    var fileName = fileSelected.name;
                    var fileSize = fileSelected.size;
                    var idxDot = fileName.lastIndexOf(".") + 1;
                    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                        //TO DO
                        if(parseInt(fileSize) > 2097152){
                            this.messageUpload = "File size is greater than 2MB!";
                        }else{
                            // DO UPLOAD
                            this.loadingUpload = true;
                            let dataArray = new FormData();
                            dataArray.append('file', fileSelected);
                            this.$store.dispatch("account/upload", dataArray).then((result) => {
                                let file_uuid = result.file_uuid;
                                this.messageUpload = "";
                                this.imageUser = process.env.VUE_APP_BACKEND_URL+"/files/"+file_uuid;
                                this.loadingUpload = false;
                                document.getElementById("img-user").src = this.imageUser;
                            });
                        }
                    }else{
                        this.messageUpload = "Invalid file type, File type must be image !";
                    }  
                }
                file_input.type = 'file';
                file_input.accept = 'image/png, image/gif, image/jpeg';
                file_input.click();
                return false;
            },
            isEmptyOrSpaces(str){
                return str === null || str.match(/^ *$/) !== null;
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
                this.loading = true;
                this.$store.dispatch("account/changeProfile", data).then((result) => {
                    this.loading = false;
                    this.message = result.message;
                    document.getElementById("text-username").text = data.full_name;
                    Swal.fire('Success', this.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
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