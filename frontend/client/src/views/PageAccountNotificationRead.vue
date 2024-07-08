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
            <li>
              <router-link :to="{ name: 'AccountNotification'}">Notification</router-link>
            </li>
            <li>Read</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section id="about-us">
      <div class="container" data-aos="fade-up">
        <div class="row content">
          <div class="col-lg-12">
            <div class="card border-0 shadow rounded-3 my-5 p-5 ">
              <div class="card-body">

                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td width="100">Date Send</td>
                      <td width="20">:</td>
                      <td v-if="loading">
                        <i class="spinner-border spinner-border-sm mr-2"></i>
                      </td>
                      <td v-else>
                        {{notification.created_at}}
                      </td>
                    </tr>
                    <tr>
                      <td>Readed At</td>
                      <td>:</td>
                      <td v-if="loading">
                        <i class="spinner-border spinner-border-sm mr-2"></i>
                      </td>
                      <td v-else>
                        {{notification.readed_at}}
                      </td>
                    </tr>
                    <tr>
                      <td>Subject</td>
                      <td>:</td>
                      <td v-if="loading">
                        <i class="spinner-border spinner-border-sm mr-2"></i>
                      </td>
                      <td v-else>
                        {{notification.subject}}
                      </td>
                    </tr>
                    <tr>
                      <td>Content</td>
                      <td>:</td>
                      <td v-if="loading">
                        <i class="spinner-border spinner-border-sm mr-2"></i>
                      </td>
                      <td v-else>
                        {{notification.content}}
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="mx-3 clearfix">

                  <router-link :to="{ name: 'AccountNotification'}" title="Back To List"
                    class="btn  btn-secondary float-start">
                    <i class="fas fa-arrow-left"></i>&nbsp;Back To List
                  </router-link>

                    <a href="#" class="btn btn-danger float-end" @click.prevent="deleteData" data-toggle="tooltip" title="Delete Item">
                      <i class="fas fa-trash"></i>&nbsp;Delete Notification
                    </a>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


  </main>
</template>
<script>
    import Swal from 'sweetalert2';
    import moment from "moment"
    export default {
        data(){
            return {
                message: "",
                loading: true,
                notification: {}
            }
        },
        mounted() {
            document.title = "Notification | " + process.env.VUE_APP_TITLE
            this.$store.dispatch("notification/read", this.$route.params.id).then((result) => {
                this.loading = false;
                this.notification = result.data;
                this.notification.created_at =  moment(this.notification.created_at).format("MMMM DD, Y HH:mm:ss");
                this.notification.readed_at =  moment(this.notification.readed_at).format("MMMM DD, Y HH:mm:ss");
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
            deleteData(){
               let id = this.$route.params.id;
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
                            this.$router.push("/account/notification");
                        })
                    }
                });
            }
        },
    }
</script>