import Create from "../../pages/Admin/Project/Create.vue"
import Detail from "../../pages/Admin/Project/Detail.vue"
import Edit from "../../pages/Admin/Project/Edit.vue"
import List from "../../pages/Admin/Project/List.vue"

export default [
    {
        path: "/admin/project/create",
        name: "CreateProject",
        component: Create
    },
    {
        path: "/admin/project/detail/:param",
        name: "DetailProject",
        props: true,
        component: Detail
    },
    {
        path: "/admin/project/edit/:param",
        name: "EditProject",
        props: true,
        component: Edit
    },
    {
        path: "/admin/project/list",
        name: "ListProject",
        component: List
    }
]