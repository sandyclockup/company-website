import LayoutAuth from "@/components/LayoutAuth.vue";
import AuthLogin from "@/pages/auth/views/AuthLogin.vue";
import AuthResetPassword from "@/pages/auth/views/AuthResetPassword.vue";
import AuthForgotPassword from "@/pages/auth/views/AuthForgotPassword.vue";

const AuthRoute = [
    {
        path: "/auth/login",
        component: AuthLogin,
        meta: {
            layout: LayoutAuth,
            requiresAuth: false
        }
    },
    {
        path: "/auth/email/forgot",
        component: AuthForgotPassword,
        meta: {
            layout: LayoutAuth,
            requiresAuth: false
        }
    },
    {
        path: "/auth/email/reset/:token",
        component: AuthResetPassword,
        meta: {
            layout: LayoutAuth,
            requiresAuth: false
        }
    },
]

export default AuthRoute;