<template>
    <!-- Site wrapper -->
    <div class="wrapper">

       
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <MainHeader />
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <MainSidebar />
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
             <router-view />
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <MainFooter />
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark d-none">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
</template>
<script>
  import MainHeader from "./MainHeader.vue"
  import MainFooter from "./MainFooter.vue"
  import MainSidebar from "./MainSidebar.vue"
  export default {
    components: {
        MainHeader,
        MainFooter,
        MainSidebar
    },
    data() {
        return {
            publicPath: process.env.VUE_APP_BASE_URL
        }
    },
    mounted() {
        document.body.className = "hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"
    },
  }
</script>