<template>
    <div class="login-box">
        <div class="card card-outline card-primary">
             <div class="card-header text-center">
                 <router-link to="/" class="h1">
                    <b>Company</b>
                 </router-link>
            </div>
            <div class="card-body">
               <router-view />
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
    <!-- /.login-box -->
</template>
<script>
    export default {
        mounted() {
            document.body.className = "hold-transition login-page"
        },
    }
</script>