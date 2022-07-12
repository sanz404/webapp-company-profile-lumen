import Create from "../../../pages/Admin/Categories/Project/Create.vue"
import Detail from "../../../pages/Admin/Categories/Project/Detail.vue"
import Edit from "../../../pages/Admin/Categories/Project/Edit.vue"
import List from "../../../pages/Admin/Categories/Project/List.vue"

export default [
    {
        path: "/admin/categories/project/create",
        name: "CreateCategoryProject",
        component: Create
    },
    {
        path: "/admin/categories/project/detail/:param",
        name: "DetailCategoryProject",
        props: true,
        component: Detail
    },
    {
        path: "/admin/categories/project/edit/:param",
        name: "EditCategoryProject",
        props: true,
        component: Edit
    },
    {
        path: "/admin/categories/project/list",
        name: "ListCategoryProject",
        component: List
    }
]