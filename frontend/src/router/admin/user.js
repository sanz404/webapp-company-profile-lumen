import Create from "../../pages/Admin/User/Create.vue"
import Detail from "../../pages/Admin/User/Detail.vue"
import Edit from "../../pages/Admin/User/Edit.vue"
import List from "../../pages/Admin/User/List.vue"

export default [
    {
        path: "/admin/user/create",
        name: "CreateUser",
        component: Create
    },
    {
        path: "/admin/user/detail/:param",
        name: "DetailUser",
        props: true,
        component: Detail
    },
    {
        path: "/admin/user/edit/:param",
        name: "EditUser",
        props: true,
        component: Edit
    },
    {
        path: "/admin/user/list",
        name: "ListUser",
        component: List
    }
]