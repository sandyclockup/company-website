<template>
    <h1 class="display-1 fw-bold">404</h1>
    <p class="fs-3">
        <span class="text-danger">Opps!</span> Page not found.
    </p>
    <p class="lead">
        The page you’re looking for doesn’t exist.
    </p>
    <router-link to="/" class="btn btn-primary">
        <i class="fas fa-home"></i>&nbsp;Back to home page
    </router-link>
</template>
<script>
    export default {
        mounted() {
            document.title = "Page not found | " + process.env.VUE_APP_TITLE
        }
    }
</script>