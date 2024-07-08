import LayoutApp from "@/components/LayoutApp.vue";
import PortfolioIndex from "@/pages/reference/portfolio/views/PortfolioIndex";
import PortfolioCreate from "@/pages/reference/portfolio/views/PortfolioCreate";
import PortfolioEdit from "@/pages/reference/portfolio/views/PortfolioEdit";
import PortfolioRead from "@/pages/reference/portfolio/views/PortfolioRead";
import PortfolioImage from "@/pages/reference/portfolio/views/PortfolioImage";

const PortfolioRoute = [
    {
        path: "/reference/portfolio/list",
        component: PortfolioIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/portfolio/create",
        component: PortfolioCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/portfolio/edit/:id",
        component: PortfolioEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/portfolio/read/:id",
        component: PortfolioRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/portfolio/image/:id",
        component: PortfolioImage,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
];

export default PortfolioRoute;