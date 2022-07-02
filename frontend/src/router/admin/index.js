import Dashboard from "../../pages/Admin/Dashboard.vue"
import ChangePassword from "../../pages/Admin/ChangePassword.vue"
import Profile from "../../pages/Admin/Profile.vue"
import Contact from "./contact"
import Notification from "./notification"

export default [
    ...Contact,
    ...Notification,
    {
        path: "/admin/dashboard",
        name: "AdminDashboard",
        component: Dashboard
    },
    {
        path: "/admin/account/password",
        name: "AdminChangePassword",
        component: ChangePassword
    },
    {
        path: "/admin/account/profile",
        name: "AdminProfile",
        component: Profile
    }
]