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
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><a href="#">Reference</a></li>
                        <li class="breadcrumb-item active">Portfolio</li>
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
               <div class="clearfix">
                    <div class="float-left">
                        <h3 class="card-title">
                            <i class="fas fa-table"></i>&nbsp;List Portfolio
                        </h3>
                    </div>
                    <div class="float-right">
                        <router-link to="/reference/portfolio/create" class="btn btn-success">
                            <i class="fas fa-plus"></i>&nbsp;Create New
                        </router-link>
                    </div>
               </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" :id="table_id">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>#</th>
                                <th>Customer</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Sort</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer"></div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</template>
<script>
    import authHeader from "../../../../services/auth-header.js"
    import { v4 as uuidv4 } from 'uuid'
    import $ from 'jquery'
    import Swal from "admin-lte/plugins/sweetalert2/sweetalert2.min.js"
    export default {
        data(){
            return {
                table_id: uuidv4()
            }
        },
        methods:{
            onImage(e){
                e.preventDefault();
                let id = e.target.getAttribute('data-id');
                this.$router.push("/reference/portfolio/image/"+id);
                return false;
            },
            onEdit(e){
                e.preventDefault();
                let id = e.target.getAttribute('data-id');
                this.$router.push("/reference/portfolio/edit/"+id);
                return false;
            },
            onRead(e){
                e.preventDefault();
                let id = e.target.getAttribute('data-id');
                this.$router.push("/reference/portfolio/read/"+id);
                return false;
            },
            onDelete(e){
              e.preventDefault();
              let id = e.target.getAttribute('data-id');
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
                        this.$store.dispatch("portfolio/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                        })
                        $("#"+this.table_id).DataTable().ajax.reload();
                    }
                });
              return false;
            }
        },
        mounted() {
            document.title = "Portfolio | " + process.env.VUE_APP_TITLE

            
            let option = {
                "container": "#"+this.table_id,
                "fetch_url": process.env.VUE_APP_BACKEND_URL+"/cms/content/portfolio",
            }
            

            let columns = [
                {
                    data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'customer_name',
                },
                {
                    data: 'category_name',
                },
                {
                    data: 'title',
                },
                {
                    data: 'sort',
                },
                {
                    data: 'is_published',
                    className: "text-center",
                    render: function (data) {
                        return parseInt(data) === 1 ? `<span class="badge bg-success">Published</span>` : `<span class="badge bg-danger">Draft</span>`;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    className: "text-center",
                    render: function (data) {
                        return `
                            <button data-id="`+data+`" class="btn btn-success text-white btn-sm btn-image">
                                <i data-id="`+data+`" class="fas fa-image"></i>
                            </button>
                            <button data-id="`+data+`" class="btn btn-primary btn-sm btn-read">
                                <i data-id="`+data+`" class="fas fa-search"></i>
                            </button>
                            <button data-id="`+data+`" class="btn btn-warning text-white btn-sm btn-edit">
                                <i data-id="`+data+`" class="fas fa-edit"></i>
                            </button>
                            <button data-id="`+data+`"  class="btn btn-danger btn-sm btn-delete">
                                <i data-id="`+data+`" class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ];

            let oTable = $(option.container).DataTable({
                'processing': true,
                'serverSide': true,
                'ajax': {
                    'url': option.fetch_url,
                    'type': 'GET',
                    'headers': authHeader()
                },
                'columns': columns,
                "order": [option.sort_index || 0, option.sort_key || "DESC"],
                "initComplete": function () {
                    $(option.container + '_filter input').attr("placeholder", "Please Press Enter").addClass("form-control");
                    $(option.container + '_filter input').unbind();
                    $(option.container + '_filter input').bind('keyup', function (e) {
                        if (e.keyCode == 13) {
                            oTable.search(this.value).draw();
                        }
                    });
                },
                "autoWidth": false,
                "responsive": false,
                "destroy": true,
            });

            let app = this;
            oTable.on('draw', function () {
                let btnRead = document.getElementsByClassName("btn-read");
                let btnDelete = document.getElementsByClassName("btn-delete");
                let btnEdit = document.getElementsByClassName("btn-edit");
                let btnImage = document.getElementsByClassName("btn-image");
                for(var i = 0 ; i < btnRead.length; i++){
                    if(btnRead[i]){
                        btnRead[i].addEventListener('click', app.onRead, false);
                    }
                    if(btnEdit[i]){
                        btnEdit[i].addEventListener('click', app.onEdit, false);
                    }
                    if(btnDelete[i]){
                        btnDelete[i].addEventListener('click', app.onDelete, false);
                    }
                    if(btnImage[i]){
                        btnImage[i].addEventListener('click', app.onImage, false);
                    }
                }
            });
        },

        unmounted() {
            let app = this;
            let btnRead = document.getElementsByClassName("btn-read");
            let btnDelete = document.getElementsByClassName("btn-delete");
            let btnEdit = document.getElementsByClassName("btn-edit");
            let btnImage = document.getElementsByClassName("btn-image");
            for(var i = 0 ; i < btnRead.length; i++){
                if(btnRead[i]){
                    btnRead[i].removeEventListener('click', app.onRead, false);
                }
                if(btnEdit[i]){
                    btnEdit[i].removeEventListener('click', app.onEdit, false);
                }
                if(btnDelete[i]){
                    btnDelete[i].removeEventListener('click', app.onDelete, false);
                }
                if(btnImage[i]){
                    btnImage[i].removeEventListener('click', app.onImage, false);
                }
            }
            $("#"+this.table_id).DataTable().destroy();
        }
    }
</script>