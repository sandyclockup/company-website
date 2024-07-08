<template>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Notification</h2>
                    <ol>
                        <li>
                            <router-link :to="{ name: 'Home'}">Home</router-link>
                        </li>
                        <li>Account</li>
                        <li>Notification</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->

        <section id="team" class="team section-bg">
            <div class="container">
                <div class="row" data-aos="fade-up">

                    <div class="col-sm-12">
                        <div class="card border-0 shadow rounded-3 my-5">
                            <div class="card-body p-4 p-sm-5">
                                <table class="table table-striped" :id="tableId">
                                    <thead>
                                        <tr class="bg-success text-white">
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>Date Send</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>


    </main>
</template>
<script>
    import authHeader from "../services/auth-header.js"
    import {  v4 as uuidv4 } from 'uuid'
    import Swal from 'sweetalert2';
    import $ from 'jquery';
    import moment from "moment"
    import DataTable from 'datatables.net-bs5';
    import 'datatables.net-select-bs5'

    export default {
        data() {
            return {
                tableId: uuidv4(),
                dataTableContent: undefined
            }
        },
        methods: {
            onRead(e) {
                e.preventDefault();
                let id = e.target.getAttribute('data-id');
                if(e.target.getAttribute('data-id')){
                    this.$router.push("/account/notification/" + id);
                }
                return false;
            },
            onDelete(e) {
                e.preventDefault();
                if(e.target.getAttribute('data-id')){
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
                                if(this.dataTableContent){
                                    this.dataTableContent.ajax.reload();
                                }
                            })

                        }
                    });
                }
                return false;
            }
        },
        mounted() {

            if(localStorage.getItem('config')){
                let config = JSON.parse(localStorage.getItem('config'));
                document.title = "Notification | " + config.config_site_title
            }

            let option = {
                "container": "#" + this.tableId,
                "fetch_url": process.env.VUE_APP_BACKEND_URL + "/account/notification/list",
            }

            let columns = [{
                    data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'created_at',
                    render: function (data) {
                        return moment(data).format("MMMM DD, Y HH:mm:ss");
                    }
                },
                {
                    data: 'subject',
                },
                {
                    data: 'readed_at',
                    render: function (data) {
                        return data !== null ? `<span class="badge bg-success">Read</span>` :
                            `<span class="badge bg-danger">Unread</span>`;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    className: "text-center",
                    render: function (data) {
                        return `
                            <button data-id="` + data + `" class="btn btn-primary btn-sm btn-read">
                                <i data-id="` + data + `" class="fas fa-search"></i>
                            </button>
                            <button data-id="` + data + `"  class="btn btn-danger btn-sm btn-delete">
                                <i data-id="` + data + `" class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ];

            let oTable = new DataTable('#' + this.tableId, {
                'processing': true,
                'serverSide': true,
                'ajax': {
                    'url': option.fetch_url,
                    'type': 'GET',
                    'headers': authHeader()
                },
                'columns': columns,
                "order": [option.sort_index || 0, option.sort_key || "DESC"],
                "autoWidth": false,
                "responsive": true,
                "destroy": true,
            });

            let app = this;
            oTable.on('draw', function () {
                let btnRead = document.getElementsByClassName("btn-read");
                let btnDelete = document.getElementsByClassName("btn-delete");
                for (var i = 0; i < btnRead.length; i++) {
                    if (btnRead[i]) {
                        btnRead[i].addEventListener('click', app.onRead, false);
                    }
                    if (btnDelete[i]) {
                        btnDelete[i].addEventListener('click', app.onDelete, false);
                    }
                }
            });

           $(document).on('focus', '.dataTables_filter input', function() {
                $(this).unbind().bind('keyup', function(e) {
                    if(e.keyCode === 13) {
                        oTable.search( this.value ).draw();
                    }
                });
            });

            this.dataTableContent = oTable;
        },

        unmounted() {
            let app = this;
            let btnRead = document.getElementsByClassName("btn-read");
            let btnDelete = document.getElementsByClassName("btn-delete");
            for (var i = 0; i < btnRead.length; i++) {
                if (btnRead[i]) {
                    btnRead[i].removeEventListener('click', app.onRead, false);
                }
                if (btnDelete[i]) {
                    btnDelete[i].removeEventListener('click', app.onDelete, false);
                }
            }
            if(this.dataTableContent){
                this.dataTableContent.destroy();
            }
        }
    }
</script>