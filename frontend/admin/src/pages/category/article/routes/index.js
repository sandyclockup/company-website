import LayoutApp from "@/components/LayoutApp.vue";
import CategoryArticleIndex from "@/pages/category/article/views/CategoryArticleIndex";
import CategoryArticleCreate from "@/pages/category/article/views/CategoryArticleCreate";
import CategoryArticleEdit from "@/pages/category/article/views/CategoryArticleEdit";
import CategoryArticleRead from "@/pages/category/article/views/CategoryArticleRead";

const CategoryArticleRoute = [
    {
        path: "/category/article/list",
        component: CategoryArticleIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/article/create",
        component: CategoryArticleCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/article/edit/:id",
        component: CategoryArticleEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/article/read/:id",
        component: CategoryArticleRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default CategoryArticleRoute;