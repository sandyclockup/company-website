import LayoutApp from "@/components/LayoutApp.vue";
import AccountPassword from "@/pages/account/views/AccountPassword.vue";
import AccountProfile from "@/pages/account/views/AccountProfile.vue";
import NotificationList from "@/pages/account/views/NotificationList.vue";
import NotificationRead from "@/pages/account/views/NotificationRead.vue";

const AccountRoute = [
    {
        path: "/account/password",
        component: AccountPassword,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/account/profile",
        component: AccountProfile,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/account/notification/list",
        component: NotificationList,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/account/notification/read/:id",
        component: NotificationRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default AccountRoute;