<template>
    <!-- Brand Logo -->
    <router-link to="/" class="brand-link">
        <img :src="`${publicPath}/img/logo.png`" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Company</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img :src="imageUser" class="img-circle elevation-2" id="img-user" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block" id="text-username">{{ username }}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <router-link to="/" class="nav-link" @click="active = 'dashboard'">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </router-link>
                </li>
                <li class="nav-item">
                     <router-link to="/reference/contact/list" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>
                            Contact
                            <span class="badge badge-warning text-white right total-contact">{{ total_contact }}</span>
                        </p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/reference/customer/list" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Customer</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/reference/portfolio/list" class="nav-link">
                        <i class="nav-icon fas fa-trophy"></i>
                        <p>Portfolio</p>
                    </router-link>
                </li>

                <li class="nav-item">
                     <router-link to="/reference/service/list" class="nav-link">
                        <i class="nav-icon fab fa-weixin"></i>
                        <p>Service</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/reference/team/list" class="nav-link">
                         <i class="nav-icon fas fa-user-secret"></i>
                        <p>Team</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <a class="nav-link clickable">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Categories
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/category/article/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Article</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/category/tag/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Tag</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                             <router-link to="/category/portfolio/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Portfolio</p>
                            </router-link>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link clickable">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>
                            Content
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/content/article/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Article</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/content/faq/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>FAQ</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/content/feature/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Feature</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/content/slider/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Slider</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/content/testimonial/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Testimonial</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/content/pricing/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Pricing</p>
                            </router-link>
                        </li>
                         <li class="nav-item">
                            <router-link to="/content/skill/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Skill</p>
                            </router-link>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a class="nav-link clickable">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Setting
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/setting/user/list" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>User</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/setting/website" class="nav-link">
                                <i class="fas fa-arrow-circle-right nav-icon"></i>
                                <p>Website</p>
                            </router-link>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <router-link to="/account/profile" class="nav-link">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>My Profile</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/account/password" class="nav-link">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>Change Password</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/account/notification/list" class="nav-link">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            Notification
                            <span class="badge badge-danger right total-unread">{{ total_unread }}</span>
                        </p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <a href="javascript:" @click.prevent="logOut" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Sign Out</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</template>
<script>
    export default {
        data() {
            return {
                loading: true,
                publicPath: process.env.VUE_APP_BASE_URL,
                active: 'dashboard',
                total_unread: 0,
                total_contact: 0,
                username: "",
                imageUser: process.env.VUE_APP_BASE_URL+"/img/user.png"
            }
        },
        mounted() {
            this.$store.dispatch("notification/board").then((result) => {
                this.total_unread = result.data.total_unread
            })
            this.$store.dispatch("contact/total").then((result) => {
                this.total_contact = result.total
            })
            this.$store.dispatch("account/profile").then((result) => {
 
                let user = result.data.user;
                let person = result.data.person;

                if(!this.isEmptyOrSpaces(person.full_name)){
                    this.username = person.full_name;
                }else if(!this.isEmptyOrSpaces(person.nick_name)){
                    this.username = person.nick_name;
                }else{
                    this.username = user.username;
                }

                if(!this.isEmptyOrSpaces(person.image)){
                    this.imageUser = process.env.VUE_APP_BACKEND_URL+"/files/"+person.image;
                }

            })
        },
        methods: {
            isEmptyOrSpaces(str){
                return str === null || str.match(/^ *$/) !== null;
            },
            logOut(event){
                event.preventDefault();
                this.$store.dispatch('auth/logout');
                this.$router.push('/auth/login');
                return false;
            }
        },
    }
</script>
<script setup>
  import * as $ from 'jquery';
  import * as AdminLte from 'admin-lte';
  import { onUpdated } from 'vue'
   onUpdated(() => {
     $('[data-widget="treeview"]').each(function() {
        AdminLte.Treeview._jQueryInterface.call($(this), 'init');
    });
   })
</script>