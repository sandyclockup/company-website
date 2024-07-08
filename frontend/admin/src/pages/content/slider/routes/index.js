import LayoutApp from "@/components/LayoutApp.vue";
import SliderIndex from "@/pages/content/slider/views/SliderIndex";
import SliderCreate from "@/pages/content/slider/views/SliderCreate";
import SliderEdit from "@/pages/content/slider/views/SliderEdit";
import SliderRead from "@/pages/content/slider/views/SliderRead";

const SliderRoute = [
    {
        path: "/content/slider/list",
        component: SliderIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/slider/create",
        component: SliderCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/slider/edit/:id",
        component: SliderEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/slider/read/:id",
        component: SliderRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default SliderRoute;