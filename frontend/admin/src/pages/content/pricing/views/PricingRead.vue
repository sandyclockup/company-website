<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pricing</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/">Home</router-link>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Content</a></li>
                        <li class="breadcrumb-item">
                            <router-link to="/content/pricing/list">Pricing</router-link>
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
                    <i class="fas fa-search"></i>&nbsp;Pricing
                </h3>
            </div>
            <div class="card-body">
                <div class="clearfix">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td width="150">Name</td>
                                <td width="20">:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{pricing.name}}
                                </td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{Number(pricing.price).toFixed(2)}}
                                </td>
                            </tr>
                            <tr>
                                <td>Unit</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{pricing.unit}}
                                </td>
                            </tr>
                            <tr>
                                <td>Link</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{pricing.link}}
                                </td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span v-html="pricing.description"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Recomended</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span :class="pricing.is_recomended === 1 ? 'badge bg-success' : 'badge bg-danger'">
                                        {{ pricing.is_recomended === 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Advanced</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span :class="pricing.is_advanced === 1 ? 'badge bg-success' : 'badge bg-danger'">
                                        {{ pricing.is_advanced === 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Sort</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{pricing.sort}}
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span :class="pricing.is_published === 1 ? 'badge bg-success' : 'badge bg-danger'">
                                        {{ pricing.is_published === 1 ? 'Published' : 'Draft' }}
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
                        <router-link to="/content/pricing/list" data-toggle="tooltip" title="Back To List"
                            class="btn  btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back To List
                        </router-link>
                    </div>
                    <div :class="!loading ? 'float-right' : 'float-right d-none'">
                        <router-link to="/content/pricing/create" data-toggle="tooltip" title="Back To List"
                            class="btn  btn-success">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </router-link>
                        &nbsp;
                        <router-link :to="'/content/pricing/edit/'+pricing.id" data-toggle="tooltip" title="Edit Data"
                            class="btn  btn-info">
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
                pricing: {},
                publicPath: process.env.VUE_APP_BASE_URL,
                message: ""
            }
        },
        mounted() {
            document.title = "Pricing | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("pricing/read", this.$route.params.id).then((result) => {
                    this.loading = false;
                    this.pricing = result.data;
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
                        this.$store.dispatch("pricing/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                            this.$router.push("/content/pricing/list");
                        })
                    }
                });
            }
        },
    }
</script>