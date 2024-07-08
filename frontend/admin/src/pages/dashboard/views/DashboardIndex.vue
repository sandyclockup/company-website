<template>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/">Home</router-link>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 v-if="!loading_total">{{ result_total.total_contact }}</h3>
                            <h3 v-else><i class="fa fa-sync fa-spin"></i></h3>
                            <p>Contact</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope-open"></i>
                        </div>
                        <router-link to="/reference/contact/list" class="small-box-footer">Read More <i
                                class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3 v-if="!loading_total">{{ result_total.total_customer }}</h3>
                            <h3 v-else><i class="fa fa-sync fa-spin"></i></h3>
                            <p>Customer</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <router-link to="/refrence/customer/list" class="small-box-footer">Read More <i
                                class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 v-if="!loading_total">{{ result_total.total_portfolio }}</h3>
                            <h3 v-else><i class="fa fa-sync fa-spin"></i></h3>
                            <p>Portfolio</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <router-link to="/content/portfolio/list" class="small-box-footer">Read More <i
                                class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3 v-if="!loading_total">{{ result_total.total_user }}</h3>
                            <h3 v-else><i class="fa fa-sync fa-spin"></i></h3>
                            <p>User</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <router-link to="/setting/user/list" class="small-box-footer">Read More <i
                                class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 v-if="!loading_total">{{ result_total.total_article }}</h3>
                            <h3 v-else><i class="fa fa-sync fa-spin"></i></h3>
                            <p>Article</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <router-link to="/content/article/list" class="small-box-footer">Read More <i
                                class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3 v-if="!loading_total">{{ result_total.total_testimonial }}</h3>
                            <h3 v-else><i class="fa fa-sync fa-spin"></i></h3>
                            <p>Testimonial</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <router-link to="/content/testimonial/list" class="small-box-footer">Read More <i
                                class="fas fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="clearfix">
                                <div class="float-left">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-2"></i>&nbsp; Article By Tag
                                    </h3>
                                </div>
                                <div class="float-right">
                                    <div :class="loading_article_tag ? '': 'd-none'">
                                        <i class="fa fa-sync fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas :id="content_article_tag"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="clearfix">
                                <div class="float-left">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-2"></i>&nbsp; Article By Category
                                    </h3>
                                </div>
                                <div class="float-right">
                                    <div class="loader">
                                        <div :class="loading_article_category ? '': 'd-none'">
                                            <i class="fa fa-sync fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                             <canvas :id="content_article_category"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="clearfix">
                                <div class="float-left">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-2"></i>&nbsp; Portfolio By Customer
                                    </h3>
                                </div>
                                <div class="float-right">
                                    <div :class="loading_portfolio_customer ? '': 'd-none'">
                                        <i class="fa fa-sync fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas :id="content_portfolio_customer"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="clearfix">
                                <div class="float-left">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-2"></i>&nbsp; Portfolio By Category
                                    </h3>
                                </div>
                                <div class="float-right">
                                    <div :class="loading_portfolio_category ? '': 'd-none'">
                                        <i class="fa fa-sync fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas :id="content_portfolio_category"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="clearfix">
                                <div class="float-left">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-bar mr-2"></i>&nbsp; Visitor Of Site at {{yearNow}}
                                    </h3>
                                </div>
                                <div class="float-right">
                                    <div :class="loading_vistor ? '': 'd-none'">
                                        <i class="fa fa-sync fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas :id="content_vistor" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="clearfix">
                                <div class="float-left">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-bar mr-2"></i>&nbsp; Reader Of Articles at {{yearNow}}
                                    </h3>
                                </div>
                                <div class="float-right">
                                    <div :class="loading_reader ? '': 'd-none'">
                                        <i class="fa fa-sync fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas :id="content_reader" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</template>
<script>
    import Swal from "admin-lte/plugins/sweetalert2/sweetalert2.min.js"
    import Chart from "admin-lte/plugins/chart.js/Chart.min.js"
    import { v4 as uuidv4 } from 'uuid'
    export default {
        data() {
            return {
                yearNow: new Date().getFullYear(),
                loading_total: true,
                loading_article_tag: true,
                loading_article_category: true,
                loading_portfolio_customer: true,
                loading_portfolio_category: true,
                loading_vistor: true,
                loading_reader: true,
                content_article_tag: uuidv4(),
                content_article_category: uuidv4(),
                content_portfolio_customer: uuidv4(),
                content_portfolio_category: uuidv4(),
                content_vistor: uuidv4(),
                content_reader: uuidv4(),
                result_total: {}
            }
        },
        mounted() {
            document.title = "Dashboard | " + process.env.VUE_APP_TITLE

            this.$store.dispatch("dashboard/total").then((result) => {
                    this.loading_total = false;
                    this.result_total = result.data;
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

            this.$store.dispatch("dashboard/articleTag").then((result) => {
                    this.loading_article_tag = false;
                    this.pieChart(this.content_article_tag, result.data, result.data.title);
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

            
            this.$store.dispatch("dashboard/articleCategory").then((result) => {
                    this.loading_article_category = false;
                    this.pieChart(this.content_article_category, result.data, result.data.title);
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

            this.$store.dispatch("dashboard/portfolioCustomer").then((result) => {
                    this.loading_portfolio_customer = false;
                    this.pieChart(this.content_portfolio_customer, result.data, result.data.title);
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

            this.$store.dispatch("dashboard/portfolioCategory").then((result) => {
                    this.loading_portfolio_category = false;
                    this.pieChart(this.content_portfolio_category, result.data, result.data.title);
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

             this.$store.dispatch("dashboard/visitor").then((result) => {
                    this.loading_vistor = false;
                    this.loadBarchart(this.content_vistor, result.data, result.data.title);
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

            this.$store.dispatch("dashboard/reader").then((result) => {
                    this.loading_reader = false;
                    this.loadBarchart(this.content_reader, result.data, result.data.title);
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
            pieChart(elem, data, title){
                const ctx = document.getElementById(elem).getContext('2d');
                const config = {
                    type: 'pie',
                    data: data,
                    options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: title
                        }
                    }
                    },
                };
                new Chart(ctx, config)
            },
            loadBarchart(elem, data, title){
                new Chart(document.getElementById(elem), {
                    type: 'bar',
                    data: data,
                    options: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: title
                        },
                        maintainAspectRatio: false
                    }
                });
            }
        }
    }
</script>