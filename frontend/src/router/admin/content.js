import Create from "../../pages/Admin/Content/Create.vue"
import Detail from "../../pages/Admin/Content/Detail.vue"
import Edit from "../../pages/Admin/Content/Edit.vue"
import List from "../../pages/Admin/Content/List.vue"

export default [
    {
        path: "/admin/content/create",
        name: "CreateContent",
        component: Create
    },
    {
        path: "/admin/content/detail/:param",
        name: "DetailContent",
        props: true,
        component: Detail
    },
    {
        path: "/admin/content/edit/:param",
        name: "EditContent",
        props: true,
        component: Edit
    },
    {
        path: "/admin/content/list",
        name: "ListContent",
        component: List
    }
]