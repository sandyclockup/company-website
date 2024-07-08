<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><a href="#">Reference</a></li>
                        <li class="breadcrumb-item"><router-link to="/reference/customer/list">Customer</router-link></li>
                        <li class="breadcrumb-item active">Detail</li>
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
                    <i class="fas fa-search"></i>&nbsp;Customer
                </h3>
            </div>
            <div class="card-body">
               <div class="clearfix">
                   <table class="table table-striped">
                       <tbody>
                            <tr>
                                <td width="150">Image</td>
                                <td width="20">:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span v-if="customer.image">
                                        <img :src="customer.image" class="img-thumbnail" width="200" />
                                    </span>
                                    <span v-else>
                                        <img :src="`${publicPath}/img/no-image.png`" class="img-thumbnail" width="200" />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{customer.name}}
                                </td>
                            </tr>
                            <tr>
                                <td>Email Address</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{customer.email}}
                                </td>
                            </tr>
                                <tr>
                                <td>Phone Number</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{customer.phone}}
                                </td>
                            </tr>
                                <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{customer.address}}
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span :class="customer.is_published === 1 ? 'badge bg-success' : 'badge bg-danger'">
                                        {{ customer.is_published === 1 ? 'Published' : 'Draft' }}
                                    </span>
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
                        <router-link to="/reference/customer/list" data-toggle="tooltip" title="Back To List" class="btn  btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back To List
                        </router-link>
                    </div>
                    <div :class="!loading ? 'float-right' : 'float-right d-none'">
                        <router-link to="/reference/customer/create" data-toggle="tooltip" title="Back To List" class="btn  btn-success">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </router-link>
                        &nbsp;
                        <router-link :to="'/reference/customer/edit/'+customer.id" data-toggle="tooltip" title="Edit Data" class="btn  btn-info">
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
    export default {
         data(){
            return {
                loading: true,
                customer: {},
                publicPath: process.env.VUE_APP_BASE_URL,
                message: ""
            }
        },
        mounted() {
            document.title = "Customer | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("customer/read", this.$route.params.id).then((result) => {
                this.loading = false;
                this.customer = result.data;
                if(this.customer.image){
                    this.customer.image = process.env.VUE_APP_BACKEND_URL+"/files/"+this.customer.image;
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
                        this.$store.dispatch("customer/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                            this.$router.push("/reference/customer/list");
                        })
                    }
                });
            }
        },
    }
</script>