<template>
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; {{yearNow}} <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
</template>
<script>
    export default {
        data(){
            return {
                yearNow: new Date().getFullYear()
            }
        }
    }
</script>