import LayoutApp from "@/components/LayoutApp.vue";
import ContactIndex from "@/pages/reference/contact/views/ContactIndex";
import ContactRead from "@/pages/reference/contact/views/ContactRead";

const ContactRoute = [
    {
        path: "/reference/contact/list",
        component: ContactIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/contact/read/:id",
        component: ContactRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default ContactRoute;