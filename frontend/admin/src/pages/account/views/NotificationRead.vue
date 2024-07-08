<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notification</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/">Home</router-link>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Account</a></li>
                        <li class="breadcrumb-item">
                            <router-link to="/account/notification/list">Notification</router-link>
                        </li>
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
                    <i class="fas fa-search"></i>&nbsp;Notification Details
                </h3>
            </div>
            <div class="card-body">
               <div class="clearfix">
                   <table class="table table-striped">
                        <tbody>
                             <tr>
                                <td width="100">Date Send</td>
                                <td width="20">:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{notification.created_at}}
                                </td>
                            </tr>
                            <tr>
                                <td>Readed At</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{notification.readed_at}}
                                </td>
                            </tr>
                            <tr>
                                <td>Subject</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{notification.subject}}
                                </td>
                            </tr>
                            <tr>
                                <td>Content</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{notification.content}}
                                </td>
                            </tr>
                        </tbody>
                   </table>
               </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="clearfix">
                    <div class="float-left">
                        <router-link to="/account/notification/list" data-toggle="tooltip" title="Back To List" class="btn  btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back To List
                        </router-link>
                    </div>
                     <div class="float-right">
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
        data(){
            return {
                message: "",
                loading: true,
                notification: {}
            }
        },
        mounted() {
            document.title = "Notification | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("notification/read", this.$route.params.id).then((result) => {
                this.loading = false;
                this.notification = result.data;
                this.notification.created_at =  moment(this.notification.created_at).format("MMMM DD, Y HH:mm:ss");
                this.notification.readed_at =  moment(this.notification.readed_at).format("MMMM DD, Y HH:mm:ss");
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
                        this.$store.dispatch("notification/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                            this.$router.push("/account/notification/list");
                        })
                    }
                });
            }
        },
    }
</script>