import LayoutApp from "@/components/LayoutApp.vue";
import WebsiteIndex from "@/pages/setting/website/views/WebsiteIndex";

const WebsiteRoute = [
    {
        path: "/setting/website",
        component: WebsiteIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default WebsiteRoute;