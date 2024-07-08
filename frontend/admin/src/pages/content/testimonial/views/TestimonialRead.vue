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
                        <li class="breadcrumb-item">
                            <router-link to="/">Home</router-link>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Content</a></li>
                        <li class="breadcrumb-item">
                            <router-link to="/content/testimonial/list">Testimonial</router-link>
                        </li>
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
                    <i class="fas fa-search"></i>&nbsp;Testimonial
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
                                    <span v-if="testimonial.image">
                                        <img :src="testimonial.image" class="img-thumbnail" width="200" />
                                    </span>
                                    <span v-else>
                                        <img :src="`${publicPath}/img/no-image.png`" class="img-thumbnail"
                                            width="200" />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{testimonial.customer_name}}
                                </td>
                            </tr>
                            <tr>
                                <td>PIC Name</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{testimonial.name}}
                                </td>
                            </tr>
                            <tr>
                                <td>PIC Position</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{testimonial.position}}
                                </td>
                            </tr>
                            <tr>
                                <td>Quote</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{testimonial.quote}}
                                </td>
                            </tr>
                            <tr>
                                <td>Sort</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{testimonial.sort}}
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span
                                        :class="testimonial.is_published === 1 ? 'badge bg-success' : 'badge bg-danger'">
                                        {{ testimonial.is_published === 1 ? 'Published' : 'Draft' }}
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
                        <router-link to="/content/testimonial/list" data-toggle="tooltip" title="Back To List"
                            class="btn  btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back To List
                        </router-link>
                    </div>
                    <div :class="!loading ? 'float-right' : 'float-right d-none'">
                        <router-link to="/content/testimonial/create" data-toggle="tooltip" title="Back To List"
                            class="btn  btn-success">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </router-link>
                        &nbsp;
                        <router-link :to="'/content/testimonial/edit/'+testimonial.id" data-toggle="tooltip"
                            title="Edit Data" class="btn  btn-info">
                            <i class="fas fa-edit mr-2"></i>Edit Data
                        </router-link>
                        &nbsp;
                        <a href="#" class="btn btn-danger" @click.prevent="deleteData" data-toggle="tooltip"
                            title="Delete Item">
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
        data() {
            return {
                loading: true,
                testimonial: {},
                publicPath: process.env.VUE_APP_BASE_URL,
                message: ""
            }
        },
        mounted() {
            document.title = "Testimonial | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("testimonial/read", this.$route.params.id).then((result) => {
                    this.loading = false;
                    this.testimonial = result.data;
                    if (this.testimonial.image) {
                        this.testimonial.image = process.env.VUE_APP_BACKEND_URL + "/files/" + this.testimonial
                            .image;
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
            deleteData() {
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
                        this.$store.dispatch("testimonial/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                            this.$router.push("/reference/testimonial/list");
                        })
                    }
                });
            }
        },
    }
</script>