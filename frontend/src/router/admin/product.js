import Create from "../../pages/Admin/Product/Create.vue"
import Detail from "../../pages/Admin/Product/Detail.vue"
import Edit from "../../pages/Admin/Product/Edit.vue"
import List from "../../pages/Admin/Product/List.vue"

export default [
    {
        path: "/admin/product/create",
        name: "CreateProduct",
        component: Create
    },
    {
        path: "/admin/product/detail/:param",
        name: "DetailProduct",
        props: true,
        component: Detail
    },
    {
        path: "/admin/product/edit/:param",
        name: "EditProduct",
        props: true,
        component: Edit
    },
    {
        path: "/admin/product/list",
        name: "ListProduct",
        component: List
    }
]