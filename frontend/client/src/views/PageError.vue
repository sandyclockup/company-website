<template>
  <div id="error-section">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="main">
      <h1>{{ code }}</h1>

       <template v-if="code === '400'">
        <p>Your browser sent an invalid request ?</p>
      </template>

       <template v-if="code === '403'">
         <p>You don't have permission to access on this server.?</p>
      </template>

      <template v-if="code === '404'">
        <p>
          Who0ps! Page not found <br />
          This page cannot found or is missing. <br />
          Use the navigation above or the button below to get back and track.
        </p>
      </template>

       <template v-if="code === '500'">
        <p>Why not try refreshing your page? or you can contact ?</p>
      </template>

       <template v-if="code === '503'">
        <p>Why don't you come back in a little while and see if our expert are finished tinkering ?</p>
      </template>

      <button type="button" @click="backLink" id="btn-back">Go back</button>
    </div>
  </div>
</template>
<script>
  import "../assets/css/error.css"
  export default {
    data() {
      return {
        code: this.getCode()
      }
    },
    mounted() {
       if(this.code === '400'){
         document.title = "Bad Request"
       }
       if(this.code === '403'){
         document.title = "Forbidden"
       }
       if(this.code === '404'){
         document.title = "Page not found"
       }
       if(this.code === '500'){
         document.title = "Internal Server Error"
       }
       if(this.code === '503'){
         document.title = "This site is getting a tune-up"
       }
    },
    methods: {
      getCode: function () {
         return "404"
      },
      backLink: function () {
        this.$router.push({
          name: 'Home'
        })
      }
    },
  }
</script>