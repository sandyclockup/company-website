import LayoutApp from "@/components/LayoutApp.vue";
import PricingIndex from "@/pages/content/pricing/views/PricingIndex";
import PricingCreate from "@/pages/content/pricing/views/PricingCreate";
import PricingEdit from "@/pages/content/pricing/views/PricingEdit";
import PricingRead from "@/pages/content/pricing/views/PricingRead";

const PricingRoute = [
    {
        path: "/content/pricing/list",
        component: PricingIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/pricing/create",
        component: PricingCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/pricing/edit/:id",
        component: PricingEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/pricing/read/:id",
        component: PricingRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default PricingRoute;