import LayoutApp from "@/components/LayoutApp.vue";
import CustomerIndex from "@/pages/reference/customer/views/CustomerIndex";
import CustomerCreate from "@/pages/reference/customer/views/CustomerCreate";
import CustomerEdit from "@/pages/reference/customer/views/CustomerEdit";
import CustomerRead from "@/pages/reference/customer/views/CustomerRead";

const CustomerRoute = [
    {
        path: "/reference/customer/list",
        component: CustomerIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/customer/create",
        component: CustomerCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/customer/edit/:id",
        component: CustomerEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/customer/read/:id",
        component: CustomerRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default CustomerRoute;