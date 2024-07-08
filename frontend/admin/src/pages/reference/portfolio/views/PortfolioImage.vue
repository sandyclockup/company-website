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
                        <li class="breadcrumb-item">
                            <router-link to="/">Home</router-link>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Reference</a></li>
                        <li class="breadcrumb-item">
                            <router-link to="/reference/portfolio/list">Portfolio</router-link>
                        </li>
                        <li class="breadcrumb-item active">Images</li>
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
                    <i class="fas fa-search"></i>&nbsp;Portfolio
                </h3>
            </div>
            <div class="card-body">
               

                <div class="row mt-3 text-center" id="image-content">

                    <div class="col-md-2 mb-2">

                        <span v-if="imageLoading">
                            <i class="spinner-border spinner-border-sm mr-2 mt-3"></i>Generating...
                        </span>
                        <span v-else>
                            <a href="#" @click.prevent="chooseFile">
                                <span v-if="imagePreview">
                                    <img v-bind:src="imagePreview" class="img-thumbnail" width="200" />
                                </span>
                                <span v-else>
                                    <img :src="`${publicPath}/img/upload.png`" class="img-thumbnail" width="200" />
                                </span>
                            </a>
                            <span v-if="imageMessage">
                                <div class="clearfix"></div>
                                <strong class="text-danger mt-2">
                                    <small>{{ imageMessage }}</small>
                                </strong>
                            </span>
                        </span>

                    </div>

                    <div class="col-md-2 mb-2" v-for="image in images" :key="image.id">
                         <img :src="`${backendURL}/${(image.image).replace('uploads', 'files')}`" alt="Image" class="img img-responsive img-thumbnail" width="250" />  
                         <span v-if="image.is_primary === 1">
                            <button class="btn btn-xs mt-2 btn-success disabled btn-block">
                                <i class="fas fa-thumbs-up"></i>&nbsp;Feature Image
                            </button>
                         </span>
                         <span v-else>
                            <button class="btn btn-xs mt-2 btn-primary btn-block" @click.prevent="setPrimary(image.id)">
                                <i class="fas fa-check"></i>&nbsp;Set As Feature Image
                            </button>
                         </span>
                         <button class="btn btn-xs mt-2 btn-danger btn-delete-image btn-block" @click.prevent="deleteData(image.id)" >
                             <i class="fas fa-trash"></i>&nbsp;Delete Image
                         </button>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="clearfix">
                    <div class="float-left">
                        <router-link to="/reference/portfolio/list" data-toggle="tooltip" title="Back To List"
                            class="btn  btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back To List
                        </router-link>
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
    import Swal from "admin-lte/plugins/sweetalert2/sweetalert2.min.js";
    export default {
        data() {
            return {
                publicPath: process.env.VUE_APP_BASE_URL,
                backendURL: process.env.VUE_APP_BACKEND_URL,
                imageLoading: false,
                imagePreview: "",
                imageMessage: "",
                fileImage: "",
                images:[]
            }
        },
        mounted() {
            document.title = "Portfolio | " + process.env.VUE_APP_TITLE
            this.loadImages();
        },
        methods: {
            setPrimary(id) {
                Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch("portfolioImage/primary", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your image has been primary!',
                                'success'
                            )
                            this.loadImages();
                        })
                    }
                });
            },
            deleteData(id) {
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
                        this.$store.dispatch("portfolioImage/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                            this.loadImages();
                        })
                    }
                });
            },
            loadImages() {
                this.imageMessage = "";
                this.imageLoading = true;
                this.$store.dispatch("portfolioImage/list", this.$route.params.id).then((result) => {
                    this.images = result.data;
                    this.imageMessage = "";
                    this.imageLoading = false;
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
            chooseFile(event) {
                event.preventDefault();
                var app = this;
                var file_input = document.createElement('input');
                var id = this.$route.params.id;
                file_input.onchange = e => {
                    app.imageMessage = "";
                    app.imageLoading = true;
                    var files = e.target.files;
                    var data = new FormData();
                    for (let i = 0; i < files.length; i++) {
                        data.append('files[]', files[i]);
                    }
                    app.$store.dispatch("portfolioImage/create", {id, data}).then(() => {
                        Swal.fire(
                            'Upload Success',
                            'Your item has been uploaded!',
                            'success'
                        )
                        app.loadImages();
                    })
                }
                file_input.multiple = true;
                file_input.type = 'file';
                file_input.accept = 'image/png, image/gif, image/jpeg';
                file_input.click();
                return false;
            },
        }
    }
</script>