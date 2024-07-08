import LayoutApp from "@/components/LayoutApp.vue";
import UserIndex from "@/pages/setting/user/views/UserIndex";
import UserCreate from "@/pages/setting/user/views/UserCreate";
import UserEdit from "@/pages/setting/user/views/UserEdit";
import UserRead from "@/pages/setting/user/views/UserRead";

const UserRoute = [
    {
        path: "/setting/user/list",
        component: UserIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/setting/user/create",
        component: UserCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/setting/user/edit/:id",
        component: UserEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/setting/user/read/:id",
        component: UserRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default UserRoute;