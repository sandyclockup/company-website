import LayoutApp from "@/components/LayoutApp.vue";
import ArticleIndex from "@/pages/content/article/views/ArticleIndex";
import ArticleCreate from "@/pages/content/article/views/ArticleCreate";
import ArticleEdit from "@/pages/content/article/views/ArticleEdit";
import ArticleRead from "@/pages/content/article/views/ArticleRead";

const ArticleRoute = [
    {
        path: "/content/article/list",
        component: ArticleIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/article/create",
        component: ArticleCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/article/edit/:id",
        component: ArticleEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/article/read/:id",
        component: ArticleRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default ArticleRoute;