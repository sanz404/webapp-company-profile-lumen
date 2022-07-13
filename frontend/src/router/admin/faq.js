import Create from "../../pages/Admin/Faq/Create.vue"
import Detail from "../../pages/Admin/Faq/Detail.vue"
import Edit from "../../pages/Admin/Faq/Edit.vue"
import List from "../../pages/Admin/Faq/List.vue"

export default [
    {
        path: "/admin/faq/create",
        name: "CreateFaq",
        component: Create
    },
    {
        path: "/admin/faq/detail/:param",
        name: "DetailFaq",
        props: true,
        component: Detail
    },
    {
        path: "/admin/faq/edit/:param",
        name: "EditFaq",
        props: true,
        component: Edit
    },
    {
        path: "/admin/faq/list",
        name: "ListFaq",
        component: List
    }
]