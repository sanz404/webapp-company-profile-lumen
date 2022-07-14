import Create from "../../pages/Admin/Feature/Create.vue"
import Detail from "../../pages/Admin/Feature/Detail.vue"
import Edit from "../../pages/Admin/Feature/Edit.vue"
import List from "../../pages/Admin/Feature/List.vue"

export default [
    {
        path: "/admin/feature/create",
        name: "CreateFeature",
        component: Create
    },
    {
        path: "/admin/feature/detail/:param",
        name: "DetailFeature",
        props: true,
        component: Detail
    },
    {
        path: "/admin/feature/edit/:param",
        name: "EditFeature",
        props: true,
        component: Edit
    },
    {
        path: "/admin/feature/list",
        name: "ListFeature",
        component: List
    }
]