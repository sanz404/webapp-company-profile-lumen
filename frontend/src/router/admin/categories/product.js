import Create from "../../../pages/Admin/Categories/Product/Create.vue"
import Detail from "../../../pages/Admin/Categories/Product/Detail.vue"
import Edit from "../../../pages/Admin/Categories/Product/Edit.vue"
import List from "../../../pages/Admin/Categories/Product/List.vue"

export default [
    {
        path: "/admin/categories/product/create",
        name: "CreateCategoryProduct",
        component: Create
    },
    {
        path: "/admin/categories/product/detail/:param",
        name: "DetailCategoryProduct",
        props: true,
        component: Detail
    },
    {
        path: "/admin/categories/product/edit/:param",
        name: "EditCategoryProduct",
        props: true,
        component: Edit
    },
    {
        path: "/admin/categories/product/list",
        name: "ListCategoryProduct",
        component: List
    }
]