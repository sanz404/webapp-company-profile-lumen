import Create from "../../pages/Admin/About/Create.vue"
import Detail from "../../pages/Admin/About/Detail.vue"
import Edit from "../../pages/Admin/About/Edit.vue"
import List from "../../pages/Admin/About/List.vue"

export default [
    {
        path: "/admin/about/create",
        name: "CreateAbout",
        component: Create
    },
    {
        path: "/admin/about/detail/:param",
        name: "DetailAbout",
        props: true,
        component: Detail
    },
    {
        path: "/admin/about/edit/:param",
        name: "EditAbout",
        props: true,
        component: Edit
    },
    {
        path: "/admin/about/list",
        name: "ListAbout",
        component: List
    }
]