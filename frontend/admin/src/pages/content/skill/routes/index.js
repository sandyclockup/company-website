import LayoutApp from "@/components/LayoutApp.vue";
import SkillIndex from "@/pages/content/skill/views/SkillIndex";
import SkillCreate from "@/pages/content/skill/views/SkillCreate";
import SkillEdit from "@/pages/content/skill/views/SkillEdit";
import SkillRead from "@/pages/content/skill/views/SkillRead";

const SkillRoute = [
    {
        path: "/content/skill/list",
        component: SkillIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/skill/create",
        component: SkillCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/skill/edit/:id",
        component: SkillEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/skill/read/:id",
        component: SkillRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default SkillRoute;