import Create from "../../pages/Admin/Contact/Create.vue"
import Detail from "../../pages/Admin/Contact/Detail.vue"
import Edit from "../../pages/Admin/Contact/Edit.vue"
import List from "../../pages/Admin/Contact/List.vue"

export default [
    {
        path: "/admin/contact/create",
        name: "CreateContact",
        component: Create
    },
    {
        path: "/admin/contact/detail/:param",
        name: "DetailContact",
        props: true,
        component: Detail
    },
    {
        path: "/admin/contact/edit/:param",
        name: "EditContact",
        props: true,
        component: Edit
    },
    {
        path: "/admin/contact/list",
        name: "ListContact",
        component: List
    }
]