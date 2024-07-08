import LayoutApp from "@/components/LayoutApp.vue";
import FaqIndex from "@/pages/content/faq/views/FaqIndex";
import FaqCreate from "@/pages/content/faq/views/FaqCreate";
import FaqEdit from "@/pages/content/faq/views/FaqEdit";
import FaqRead from "@/pages/content/faq/views/FaqRead";

const FaqRoute = [
    {
        path: "/content/faq/list",
        component: FaqIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/faq/create",
        component: FaqCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/faq/edit/:id",
        component: FaqEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/faq/read/:id",
        component: FaqRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default FaqRoute;