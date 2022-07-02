import { createWebHistory, createRouter } from "vue-router";
import routePublic from "./public"
import routeAuth from "./auth"
import routeAdmin from "./admin"
import Page400 from "../pages/Error/Page400.vue"
import Page401 from "../pages/Error/Page401.vue"
import Page403 from "../pages/Error/Page403.vue"
import Page404 from "../pages/Error/Page404.vue"
import Page500 from "../pages/Error/Page500.vue"
import Page503 from "../pages/Error/Page503.vue"

const routes = [
    ...routePublic,
    ...routeAuth,
    ...routeAdmin,
    {
        path: "/:catchAll(.*)",
        name: "page404",
        component: Page404
    },
    {
        path: "/400",
        name: "error400",
        component: Page400
    },
    {
        path: "/401",
        name: "error401",
        component: Page401
    },
    {
        path: "/403",
        name: "error403",
        component: Page403
    },
    {
        path: "/404",
        name: "error404",
        component: Page404
    },
    {
        path: "/500",
        name: "error500",
        component: Page500
    },
    {
        path: "/503",
        name: "error504",
        component: Page503
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    mode:'history',
    linkActiveClass: "active"
});

export default router