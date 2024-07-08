<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Article</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/">Home</router-link>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Content</a></li>
                        <li class="breadcrumb-item">
                            <router-link to="/content/article/list">Article</router-link>
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
                    <i class="fas fa-search"></i>&nbsp;Article
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
                                    <span v-if="article.image">
                                        <img :src="article.image" class="img-thumbnail" width="200" />
                                    </span>
                                    <span v-else>
                                        <img :src="`${publicPath}/img/no-image.png`" class="img-thumbnail"
                                            width="200" />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{article.title}}
                                </td>
                            </tr>
                            <tr>
                                <td>Author</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{article.username}}
                                </td>
                            </tr>
                            <tr>
                                <td>Categories</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span class="badge bg-primary mr-2" v-for="category in categories"
                                        :key="category.id">
                                        {{category.name}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tags</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span class="badge bg-primary mr-2" v-for="tag in tags" :key="tag.id">
                                        {{tag.name}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    {{article.created_at}}
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td v-if="loading">
                                    <i class="spinner-border spinner-border-sm mr-2"></i>
                                </td>
                                <td v-else>
                                    <span :class="article.is_published === 1 ? 'badge bg-success' : 'badge bg-danger'">
                                        {{ article.is_published === 1 ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <span v-if="!loading">
                       <ckeditor :disabled="true" :editor="editor" v-model="article.content" :config="editorConfig"> </ckeditor>
                    </span>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="clearfix">
                    <div class="float-left">
                        <router-link to="/content/article/list" data-toggle="tooltip" title="Back To List"
                            class="btn  btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back To List
                        </router-link>
                    </div>
                    <div :class="!loading ? 'float-right' : 'float-right d-none'">
                        <router-link to="/content/article/create" data-toggle="tooltip" title="Back To List"
                            class="btn  btn-success">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </router-link>
                        &nbsp;
                        <router-link :to="'/content/article/edit/'+article.id" data-toggle="tooltip" title="Edit Data"
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
    import moment from "moment"
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
    export default {
        data() {
            return {
                loading: true,
                article: {},
                categories: [],
                tags: [],
                publicPath: process.env.VUE_APP_BASE_URL,
                message: "",
                editor: ClassicEditor,
                editorConfig: {}
            }
        },
        mounted() {
            document.title = "Article | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("article/read", this.$route.params.id).then((result) => {
                    this.loading = false;
                    this.article = result.data;
                    this.categories = result.categories;
                    this.tags = result.tags;
                    this.article.created_at = moment(this.article.created_at).format("MMMM DD, Y HH:mm:ss");
                    if (this.article.image) {
                        this.article.image = process.env.VUE_APP_BACKEND_URL + "/files/" + this.article.image;
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
                        this.$store.dispatch("article/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                            this.$router.push("/content/article/list");
                        })
                    }
                });
            }
        },
    }
</script>