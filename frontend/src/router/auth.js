import Confirm from "../pages/Auth/Confirmation.vue"
import ForgotPassword from "../pages/Auth/ForgotPassword.vue"
import Login from "../pages/Auth/Login.vue"
import Logout from "../pages/Auth/Logout.vue"
import Register from "../pages/Auth/Register.vue"
import ResetPassword from "../pages/Auth/ResetPassword.vue"


export default [
    {
        path: "/auth/email/confirm/:token",
        name: "EmailConfirm",
        props: true,
        component: Confirm
    },
    {
        path: "/auth/email/forgot",
        name: "ForgotPassword",
        component: ForgotPassword
    },
    {
        path: "/auth/login",
        name: "Login",
        component: Login
    },
    {
        path: "/auth/logout",
        name: "Logout",
        component: Logout
    },
    {
        path: "/auth/register",
        name: "Register",
        component: Register
    },
    {
        path: "/auth/email/reset/:token",
        name: "ResetPassword",
        props: true,
        component: ResetPassword
    },
]