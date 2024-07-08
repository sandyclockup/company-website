import {
    createWebHistory,
    createRouter
} from "vue-router";

import DashboardRoute from "@/pages/dashboard/routes/index";
import AccountRoute from "@/pages/account/routes/index";
import ContactRoute from "@/pages/reference/contact/routes/index";
import CustomerRoute from "@/pages/reference/customer/routes/index";
import PortfolioRoute from "@/pages/reference/portfolio/routes/index";
import ServiceRoute from "@/pages/reference/service/routes/index";
import TeamRoute from "@/pages/reference/team/routes/index";
import CategoryArticleRoute from "@/pages/category/article/routes/index";
import CategoryPortfolioRoute from "@/pages/category/portfolio/routes/index";
import CategoryTagRoute from "@/pages/category/tag/routes/index";
import UserRoute from "@/pages/setting/user/routes/index";
import WebsiteRoute from "@/pages/setting/website/routes/index";
import ArticleRoute from "@/pages/content/article/routes/index";
import FaqRoute from "@/pages/content/faq/routes/index";
import FeatureRoute from "@/pages/content/feature/routes/index";
import SliderRoute from "@/pages/content/slider/routes/index";
import TestimonialRoute from "@/pages/content/testimonial/routes/index";
import SkillRoute from "@/pages/content/skill/routes/index";
import PricingRoute from "@/pages/content/pricing/routes/index";
import AuthRoute from "@/pages/auth/routes/index";
import ErrorRoute from "@/pages/error/routes/index";

const routes = [
    ...AuthRoute,
    ...DashboardRoute,
    ...AccountRoute,
    ...ContactRoute,
    ...CustomerRoute,
    ...PortfolioRoute,
    ...ServiceRoute,
    ...TeamRoute,
    ...CategoryArticleRoute,
    ...CategoryPortfolioRoute,
    ...CategoryTagRoute,
    ...UserRoute,
    ...WebsiteRoute,
    ...ArticleRoute,
    ...FaqRoute,
    ...FeatureRoute,
    ...SliderRoute,
    ...TestimonialRoute,
    ...SkillRoute,
    ...PricingRoute,
    ...ErrorRoute
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active", // active class for non-exact links.
    linkExactActiveClass: "active" // active class for *exact* links.
});

export default router;