import LayoutApp from "@/components/LayoutApp.vue";
import CategoryPortfolioIndex from "@/pages/category/portfolio/views/CategoryPortfolioIndex";
import CategoryPortfolioCreate from "@/pages/category/portfolio/views/CategoryPortfolioCreate";
import CategoryPortfolioEdit from "@/pages/category/portfolio/views/CategoryPortfolioEdit";
import CategoryPortfolioRead from "@/pages/category/portfolio/views/CategoryPortfolioRead";

const CategoryPortfolioRoute = [
    {
        path: "/category/portfolio/list",
        component: CategoryPortfolioIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/portfolio/create",
        component: CategoryPortfolioCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/portfolio/edit/:id",
        component: CategoryPortfolioEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/portfolio/read/:id",
        component: CategoryPortfolioRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default CategoryPortfolioRoute;