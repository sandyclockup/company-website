import LayoutApp from "@/components/LayoutApp.vue";
import CategoryTagIndex from "@/pages/category/tag/views/CategoryTagIndex";
import CategoryTagCreate from "@/pages/category/tag/views/CategoryTagCreate";
import CategoryTagEdit from "@/pages/category/tag/views/CategoryTagEdit";
import CategoryTagRead from "@/pages/category/tag/views/CategoryTagRead";

const CategoryTagRoute = [
    {
        path: "/category/tag/list",
        component: CategoryTagIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/tag/create",
        component: CategoryTagCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/tag/edit/:id",
        component: CategoryTagEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/category/tag/read/:id",
        component: CategoryTagRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default CategoryTagRoute;