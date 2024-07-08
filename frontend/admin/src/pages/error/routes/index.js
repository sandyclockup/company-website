import LayoutError from "@/components/LayoutError.vue";
import PageError404 from "@/pages/error/views/PageError404.vue"

const ErrorRoute = [
    {
        path: "/:pathMatch(.*)*",
        component: PageError404,
        meta: {
            layout: LayoutError,
            requiresAuth: false
        }
    }
];

export default ErrorRoute;