<template>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-bullhorn"></i>
                <span class="badge badge-danger navbar-badge total-unread">{{ total_unread }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div id="notification-section" v-for="notification in notifications" :key="notification.id">
                    <router-link :to="`/account/notification/read/${notification.id}`" class="dropdown-item">
                        <div class="media">
                            <img :src="`${publicPath}/img/user.png`" class="img-size-50 mr-3 img-circle" alt="User Image" />
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{ notification.content.substring(0, 15) }}...
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{  this.toDate(notification.created_at) }}</p>
                            </div>
                        </div>
                    </router-link>
                </div>
                <router-link to="/account/notification/list" class="dropdown-item dropdown-footer">View All Notification</router-link>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">

                 <router-link to="/account/profile" class="dropdown-item">
                    <i class="fas fa-user-plus mr-2"></i> My Profile
                    <span class="float-right text-muted text-sm"></span>
                 </router-link>

                <router-link to="/account/password" class="dropdown-item">
                    <i class="fas fa-lock mr-2"></i> Change Password
                    <span class="float-right text-muted text-sm"></span>
                 </router-link>

                 <router-link to="/account/notification/list" class="dropdown-item">
                    <i class="fas fa-bullhorn mr-2"></i> Notification
                    <span class="float-right text-muted text-sm"></span>
                 </router-link>

                <a href="javascript:" @click.prevent="logOut" class="dropdown-item">
                     <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                    <span class="float-right text-muted text-sm"></span>
                 </a>

            </div>
        </li>
    </ul>
</template>
<script>
    import moment from "moment"
    export default {
        data() {
            return {
                publicPath: process.env.VUE_APP_BASE_URL,
                notifications: [],
                total_unread: 0
            }
        },
         mounted() {
            this.$store.dispatch("notification/board").then((result) => {
                this.notifications = result.data.list
                this.total_unread = result.data.total_unread
            },)
        },
        methods: {
            logOut(event){
                event.preventDefault();
                this.$store.dispatch('auth/logout');
                this.$router.push('/auth/login');
                return false;
            },
            toDate(val){
                return moment(val).format("MMMM DD, Y HH:mm:ss")
            }
        },
    }
</script>