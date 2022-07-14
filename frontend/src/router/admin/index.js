import Dashboard from "../../pages/Admin/Dashboard.vue"
import ChangePassword from "../../pages/Admin/ChangePassword.vue"
import Profile from "../../pages/Admin/Profile.vue"
import Contact from "./contact"
import Content from "./content"
import Faq from "./faq"
import Feature from "./feature"
import Message from "./message"
import Team from "./team"
import User from "./user"
import Notification from "./notification"
import CategoryArticle from "../../router/admin/categories/article"
import CategoryProduct from "../../router/admin/categories/product"
import CategoryProject from "../../router/admin/categories/project"

export default [
    ...Contact,
    ...Content,
    ...Feature,
    ...Team,
    ...Faq,
    ...User,
    ...Notification,
    ...CategoryArticle,
    ...CategoryProduct,
    ...CategoryProject,
    ...Message,
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