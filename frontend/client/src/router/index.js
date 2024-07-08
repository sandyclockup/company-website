import { createWebHistory, createRouter } from "vue-router";
import LayoutApp from "@/views/LayoutApp.vue"
import LayoutError from "@/views/LayoutError.vue"
import Home from "@/views/PageHome.vue";
import About from "@/views/PageAbout.vue";
import Team from "@/views/PageTeam.vue";
import Testimonial from "@/views/PageTestimonial.vue";
import Service from "@/views/PageService.vue";
import Portfolio from "@/views/PagePortfolio.vue";
import PortfolioRead from "@/views/PagePortfolioRead.vue";
import Pricing from "@/views/PagePricing.vue";
import Blog from "@/views/PageBlog.vue";
import BlogRead from "@/views/PageBlogRead.vue";
import Contact from "@/views/PageContact.vue";
import AuthLogin from "@/views/PageAuthLogin.vue";
import AuthRegister from "@/views/PageAuthRegister.vue";
import AuthConfirm from "@/views/PageAuthConfirm.vue";
import AuthForgotPassword from "@/views/PageAuthForgotPassword.vue";
import AuthResetPassword from "@/views/PageAuthResetPassword.vue";
import AccountProfile from "@/views/PageAccountProfile.vue";
import AccountPassword from "@/views/PageAccountPassword.vue";
import AccountNotification from "@/views/PageAccountNotification.vue";
import AccountNotificationRead from "@/views/PageAccountNotificationRead.vue";
import Privacy from "@/views/PagePrivacy.vue";
import Term from "@/views/PageTerm.vue";
import PageError from "@/views/PageError.vue"

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
    meta: { layout: LayoutApp }
  },
  {
    path: "/about",
    name: "About",
    component: About,
    meta: { layout: LayoutApp }
  },
  {
    path: "/team",
    name: "Team",
    component: Team,
    meta: { layout: LayoutApp }
  },
  {
    path: "/testimonial",
    name: "Testimonial",
    component: Testimonial,
    meta: { layout: LayoutApp }
  },
  {
    path: "/service",
    name: "Service",
    component: Service,
    meta: { layout: LayoutApp }
  },
  {
    path: "/portfolio",
    name: "Portfolio",
    component: Portfolio,
    meta: { layout: LayoutApp }
  },
  {
    path: "/portfolio/:id",
    name: "PortfolioRead",
    component: PortfolioRead,
    meta: { layout: LayoutApp }
  },
  {
    path: "/pricing",
    name: "Pricing",
    component: Pricing,
    meta: { layout: LayoutApp }
  },
  {
    path: "/blog",
    name: "Blog",
    component: Blog,
    meta: { layout: LayoutApp }
  },
  {
    path: "/blog/:slug",
    name: "BlogRead",
    component: BlogRead,
    meta: { layout: LayoutApp }
  },
  {
    path: "/contact",
    name: "Contact",
    component: Contact,
    meta: { layout: LayoutApp }
  },
  {
    path: "/auth/login",
    name: "AuthLogin",
    component: AuthLogin,
    meta: { layout: LayoutApp }
  },
  {
    path: "/auth/register",
    name: "AuthRegister",
    component: AuthRegister,
    meta: { layout: LayoutApp }
  },
  {
    path: "/auth/confirm/:token",
    name: "AuthConfirm",
    component: AuthConfirm,
    meta: { layout: LayoutApp }
  },
  {
    path: "/auth/email/forgot",
    name: "AuthForgotPassword",
    component: AuthForgotPassword,
    meta: { layout: LayoutApp }
  },
  {
    path: "/auth/email/reset/:token",
    name: "AuthResetPassword",
    component: AuthResetPassword,
    meta: { layout: LayoutApp }
  },
  {
    path: "/account/profile",
    name: "AccountProfile",
    component: AccountProfile,
    meta: { layout: LayoutApp }
  },
  {
    path: "/account/password",
    name: "AccountPassword",
    component: AccountPassword,
    meta: { layout: LayoutApp }
  },
  {
    path: "/account/notification",
    name: "AccountNotification",
    component: AccountNotification,
    meta: { layout: LayoutApp }
  },
  {
    path: "/account/notification/:id",
    name: "AccountNotificationRead",
    component: AccountNotificationRead,
    meta: { layout: LayoutApp }
  },
  {
    path: "/privacy-policy",
    name: "Privacy",
    component: Privacy,
    meta: { layout: LayoutApp }
  },
  {
    path: "/term-and-support",
    name: "Term",
    component: Term,
    meta: { layout: LayoutApp }
  },
  {
    path: "/:pathMatch(.*)*",
    name: "PageError",
    component: PageError,
    meta: { layout: LayoutError }
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;