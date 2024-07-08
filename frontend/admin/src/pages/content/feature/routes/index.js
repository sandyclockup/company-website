import LayoutApp from "@/components/LayoutApp.vue";
import FeatureIndex from "@/pages/content/feature/views/FeatureIndex";
import FeatureCreate from "@/pages/content/feature/views/FeatureCreate";
import FeatureEdit from "@/pages/content/feature/views/FeatureEdit";
import FeatureRead from "@/pages/content/feature/views/FeatureRead";

const FeatureRoute = [
    {
        path: "/content/feature/list",
        component: FeatureIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/feature/create",
        component: FeatureCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/feature/edit/:id",
        component: FeatureEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/feature/read/:id",
        component: FeatureRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default FeatureRoute;