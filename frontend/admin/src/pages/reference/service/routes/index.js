import LayoutApp from "@/components/LayoutApp.vue";
import ServiceIndex from "@/pages/reference/service/views/ServiceIndex";
import ServiceCreate from "@/pages/reference/service/views/ServiceCreate";
import ServiceEdit from "@/pages/reference/service/views/ServiceEdit";
import ServiceRead from "@/pages/reference/service/views/ServiceRead";

const ServiceRoute = [
    {
        path: "/reference/service/list",
        component: ServiceIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/service/create",
        component: ServiceCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/service/edit/:id",
        component: ServiceEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/service/read/:id",
        component: ServiceRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default ServiceRoute;