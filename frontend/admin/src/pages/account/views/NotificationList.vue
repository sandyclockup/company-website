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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Account</a></li>
                        <li class="breadcrumb-item active">Notification</li>
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
                    <i class="fas fa-table"></i>&nbsp;List Notification
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" :id="tableId">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>#</th>
                                <th>Send Date</th>
                                <th>Subject</th>
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
    import authHeader from "../../../services/auth-header.js"
    import { v4 as uuidv4 } from 'uuid'
    import $ from 'jquery'
    import Swal from "admin-lte/plugins/sweetalert2/sweetalert2.min.js"
    import moment from "moment"
    export default {
        data(){
            return {
                tableId: uuidv4()
            }
        },
        methods:{
            onRead(e){
                e.preventDefault();
                let id = e.target.getAttribute('data-id');
                this.$router.push("/account/notification/read/"+id);
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
                        this.$store.dispatch("notification/delete", id).then(() => {
                            Swal.fire(
                                'Delete Success',
                                'Your item has been deleted!',
                                'success'
                            )
                        })
                        $("#"+this.tableId).DataTable().ajax.reload();
                    }
                });
              return false;
            }
        },
        mounted() {

            document.title = "Notification | " + process.env.VUE_APP_TITLE

            let option = {
                "container": "#"+this.tableId,
                "fetch_url": process.env.VUE_APP_BACKEND_URL+"/account/notification/list",
            }

            let columns = [
                {
                    data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'created_at',
                    render: function(data){
                        return moment(data).format("MMMM DD, Y HH:mm:ss");
                    }
                },
                {
                    data: 'subject',
                },
                {
                    data: 'readed_at',
                    render: function (data) {
                        return data !== null ? `<span class="badge bg-success">Read</span>` : `<span class="badge bg-danger">Unread</span>`;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    className: "text-center",
                    render: function (data) {
                        return `
                            <button data-id="`+data+`" class="btn btn-primary btn-sm btn-read">
                                <i data-id="`+data+`" class="fas fa-search"></i>
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
                for(var i = 0 ; i < btnRead.length; i++){
                    if(btnRead[i]){
                        btnRead[i].addEventListener('click', app.onRead, false);
                    }
                    if(btnDelete[i]){
                        btnDelete[i].addEventListener('click', app.onDelete, false);
                    }
                }
            });
        },

        unmounted() {
            let app = this;
            let btnRead = document.getElementsByClassName("btn-read");
            let btnDelete = document.getElementsByClassName("btn-delete");
            for(var i = 0 ; i < btnRead.length; i++){
                if(btnRead[i]){
                    btnRead[i].removeEventListener('click', app.onRead, false);
                }
                if(btnDelete[i]){
                    btnDelete[i].removeEventListener('click', app.onDelete, false);
                }
            }
            $("#"+this.table_id).DataTable().destroy();
        }
    }
</script>