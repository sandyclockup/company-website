import LayoutApp from "@/components/LayoutApp.vue";
import TeamIndex from "@/pages/reference/team/views/TeamIndex";
import TeamCreate from "@/pages/reference/team/views/TeamCreate";
import TeamEdit from "@/pages/reference/team/views/TeamEdit";
import TeamRead from "@/pages/reference/team/views/TeamRead";

const TeamRoute = [
    {
        path: "/reference/team/list",
        component: TeamIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/team/create",
        component: TeamCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/team/edit/:id",
        component: TeamEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/reference/team/read/:id",
        component: TeamRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default TeamRoute;