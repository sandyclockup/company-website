<template>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <router-view />
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            document.body.className = ""
        },
    }
</script>