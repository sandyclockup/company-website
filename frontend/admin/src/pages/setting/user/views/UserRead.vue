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
                        <li class="breadcrumb-item active">Details</li>
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
                    <i class="fas fa-search"></i>&nbsp;User Details
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 text-center">
                         <img :src="imageUser" class="img-thumbnail" width="250" />
                    </div>
                    <div class="col-md-5">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="150">Username</td>
                                    <td width="10">:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{user.username}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email Address</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{user.email}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{user.phone}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{ user.is_admin === 1 ? 'Admin' : 'Guest' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Confirmed</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        <span :class="user.verified === 1 ? 'badge bg-success' : 'badge bg-danger'">
                                            {{ user.verified === 1 ? 'Confirmed' : 'Wating Confirmed' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Banned</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        <span :class="user.is_banned === 0 ? 'badge bg-success' : 'badge bg-danger'">
                                            {{ user.is_banned === 0 ? 'No' : 'Yes' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Joined At</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{user.created_at}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Login</td>
                                    <td>:</td>
                                     <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{user.updated_at}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="150">Nick Name</td>
                                    <td width="10">:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{person.nick_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Full Name</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{person.full_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        <span v-if="!person.gender"></span>
                                        <span v-else>
                                            {{person.gender == 1 ? 'Male' : 'Female'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Birth Date</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{person.birth_date}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Twitter</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{person.twitter}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Facebook</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{person.facebook}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Instagram</td>
                                    <td>:</td>
                                     <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{person.instagram}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td v-if="loading">
                                        <i class="spinner-border spinner-border-sm mr-2"></i>
                                    </td>
                                    <td v-else>
                                        {{person.address}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                    <div :class="!loading ? 'float-right' : 'float-right d-none'">
                        <router-link to="/setting/user/create" data-toggle="tooltip" title="Back To List" class="btn  btn-success">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </router-link>
                        &nbsp;
                        <router-link :to="'/setting/user/edit/'+user.id" data-toggle="tooltip" title="Edit Data" class="btn  btn-info">
                            <i class="fas fa-edit mr-2"></i>Edit Data
                        </router-link>
                         &nbsp;
                        <a href="#" class="btn btn-danger" @click.prevent="deleteData" data-toggle="tooltip" title="Delete Item">
                            <i class="fas fa-trash mr-2"></i>Delete Item
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</template>
<script>
    import Swal from "admin-lte/plugins/sweetalert2/sweetalert2.min.js"
    import moment from "moment"
    export default {
         data () {
            return {
                publicPath: process.env.VUE_APP_BASE_URL,
                imageUser: process.env.VUE_APP_BASE_URL+"/img/user.png",
                loading: true,
                person: {},
                user: {},
                message: ""
            }
        },
        mounted() {
            document.title = "User | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("user/read", this.$route.params.id).then((result) => {
                this.loading = false;   
                this.user = result.data.user;
                this.person = result.data.person;
                this.user.created_at =  moment(this.user.created_at).format("MMMM DD, Y HH:mm:ss");
                this.user.updated_at =  moment(this.user.updated_at).format("MMMM DD, Y HH:mm:ss");
                if(!this.isEmptyOrSpaces(result.data.person.image)){
                    this.imageUser = process.env.VUE_APP_BACKEND_URL+"/files/"+result.data.person.image;
                }
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
        methods: {
            isEmptyOrSpaces(str){
                return str === null || str.match(/^ *$/) !== null;
            },
            deleteData(){
               let id = this.$route.params.id;
               Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure you want to delete this item  ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch("user/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                            this.$router.push("/setting/user/list");
                        })
                    }
                });
            }
        },
    }
</script>