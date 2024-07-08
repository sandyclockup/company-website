<template>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Profile</h2>
          <ol>
            <li>
              <router-link :to="{ name: 'Home'}">Home</router-link>
            </li>
            <li>Account</li>
            <li>Profile</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section id="team" class="team section-bg">
      <div class="container">
        <div class="row" data-aos="fade-up">

          <div class="col-sm-3">
            <div class="card border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5 text-center">
                    <h5 class="card-title text-center mb-5 fw-light fs-5">Profile Picture</h5>
                    <span v-if="loadingUpload">
                        <i class="spinner-border spinner-border-sm mr-2 mt-3"></i>&nbsp;Uploading...
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
            </div>
          </div>

          <div class="col-sm-9">
            <div class="card border-0 shadow rounded-3 my-5">
              <div class="card-body p-4 p-sm-5">
                <h5 class="card-title text-center mb-5 fw-light fs-5">My Profile</h5>
                <Form  @submit="handSubmit" :validation-schema="schema" class="form-horizontal">
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="username" v-model="user.username" v-slot="{ field, errors }">
                          <input v-bind="field"  type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                        </Field>
                        <label for="username">Username</label>
                        <ErrorMessage name="username" class="error invalid-feedback" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="email" v-model="user.email" v-slot="{ field, errors }">
                          <input v-bind="field"  type="email" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                        </Field>
                        <label for="email">Email Address</label>
                        <ErrorMessage name="email" class="error invalid-feedback" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="phone" v-model="user.phone" v-slot="{ field, errors }">
                          <input v-bind="field"  type="text" :readonly="loading" :class="errors.length == 0 ? 'form-control' : 'form-control is-invalid'">
                        </Field>
                        <label for="phone">Phone Number</label>
                        <ErrorMessage name="phone" class="error invalid-feedback" />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="twitter" v-model="person.twitter" v-slot="{ field }">
                          <input v-bind="field"  type="text" :readonly="loading" class="form-control">
                        </Field>
                        <label for="twitter">Twitter</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="facebook" v-model="person.facebook" v-slot="{ field }">
                          <input v-bind="field"  type="text" :readonly="loading" class="form-control">
                        </Field>
                        <label for="facebook">Facebook</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="instagram" v-model="person.instagram" v-slot="{ field }">
                          <input v-bind="field"  type="text" :readonly="loading" class="form-control">
                        </Field>
                        <label for="instagram">Instagram</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="nick_name" v-model="person.nick_name" v-slot="{ field }">
                          <input v-bind="field"  type="text" :readonly="loading" class="form-control">
                        </Field>
                        <label for="nick_name">Nick Name</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="full_name" v-model="person.full_name" v-slot="{ field }">
                          <input v-bind="field"  type="text" :readonly="loading" class="form-control">
                        </Field>
                        <label for="full_name">Full Name</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field v-model="person.gender"  name="gender" :readonly="loading" class="form-control" as="select">
                            <option value="0" disabled>Select a Gender</option>
                            <option v-for="gender in genders" :key="gender.value" :value="gender.value">{{ gender.text }}</option>
                        </Field>
                        <label for="gender">Gender</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-floating mb-3 input-form">
                        <Field name="birth_date" v-model="person.birth_date" v-slot="{ field }">
                          <input v-bind="field"  type="date" :readonly="loading" class="form-control">
                        </Field>
                        <label for="birth_date">Birth Date</label>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-floating mb-3 input-form">
                        <Field name="address" v-model="person.address" v-slot="{ field}">
                          <textarea v-bind="field" rows="4" :readonly="loading" class="form-control"></textarea>
                        </Field>
                        <label for="address">Address</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-floating mb-3 input-form">
                        <Field name="about_me" v-model="person.about_me" v-slot="{ field}">
                          <textarea v-bind="field" rows="4" :readonly="loading" class="form-control"></textarea>
                        </Field>
                        <label for="about_me">Abou Me</label>
                      </div>
                    </div>
                  </div>

                  <button class="btn btn-success btn-login text-uppercase fw-bold" type="submit" data-toggle="tooltip"  data-bs-original-title="Save Profile" :disabled="loading">
                    <span v-if="loading">
                        <i class="spinner-border spinner-border-sm me-2"></i>Save Profile
                    </span>
                    <span v-else>
                        <i class="fas fa-save"></i> Save Profile
                    </span>
                  </button>

                  <button class="btn btn-warning btn-login text-uppercase fw-bold text-white  m-2" type="reset">
                    <i class="fas fa-sync-alt"></i> Reset Form
                  </button>


                </Form>
              </div>
            </div>

          </div>

        </div>
      </div>
    </section>


  </main>
</template>
<script>
    import { Form, Field, ErrorMessage } from "vee-validate";
    import * as yup from "yup";
    import Swal from 'sweetalert2';
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
           if(localStorage.getItem('config')){
              let config = JSON.parse(localStorage.getItem('config'));
              document.title = "Change Profile | " + config.config_site_title
            }
            this.$store.dispatch("account/profile").then((result) => {
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