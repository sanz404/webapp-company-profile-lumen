import Create from "../../../pages/Admin/Categories/Faq/Create.vue"
import Detail from "../../../pages/Admin/Categories/Faq/Detail.vue"
import Edit from "../../../pages/Admin/Categories/Faq/Edit.vue"
import List from "../../../pages/Admin/Categories/Faq/List.vue"

export default [
    {
        path: "/admin/categories/faq/create",
        name: "CreateCategoryFaq",
        component: Create
    },
    {
        path: "/admin/categories/faq/detail/:param",
        name: "DetailCategoryFaq",
        props: true,
        component: Detail
    },
    {
        path: "/admin/categories/faq/edit/:param",
        name: "EditCategoryFaq",
        props: true,
        component: Edit
    },
    {
        path: "/admin/categories/faq/list",
        name: "ListCategoryFaq",
        component: List
    }
]