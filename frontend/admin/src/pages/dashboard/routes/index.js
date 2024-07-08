import LayoutApp from "@/components/LayoutApp.vue";
import DashboardIndex from "@/pages/dashboard/views/DashboardIndex"

const DashboardRoute = [
    {
        path: "/",
        component: DashboardIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default DashboardRoute;