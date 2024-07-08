import LayoutApp from "@/components/LayoutApp.vue";
import TestimonialIndex from "@/pages/content/testimonial/views/TestimonialIndex";
import TestimonialCreate from "@/pages/content/testimonial/views/TestimonialCreate";
import TestimonialEdit from "@/pages/content/testimonial/views/TestimonialEdit";
import TestimonialRead from "@/pages/content/testimonial/views/TestimonialRead";

const TestimonialRoute = [
    {
        path: "/content/testimonial/list",
        component: TestimonialIndex,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/testimonial/create",
        component: TestimonialCreate,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/testimonial/edit/:id",
        component: TestimonialEdit,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    },
    {
        path: "/content/testimonial/read/:id",
        component: TestimonialRead,
        meta: {
            layout: LayoutApp,
            requiresAuth: true
        }
    }
];

export default TestimonialRoute;