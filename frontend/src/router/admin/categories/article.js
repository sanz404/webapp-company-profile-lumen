import Create from "../../../pages/Admin/Categories/Article/Create.vue"
import Detail from "../../../pages/Admin/Categories/Article/Detail.vue"
import Edit from "../../../pages/Admin/Categories/Article/Edit.vue"
import List from "../../../pages/Admin/Categories/Article/List.vue"

export default [
    {
        path: "/admin/categories/article/create",
        name: "CreateCategoryArticle",
        component: Create
    },
    {
        path: "/admin/categories/article/detail/:param",
        name: "DetailCategoryArticle",
        props: true,
        component: Detail
    },
    {
        path: "/admin/categories/article/edit/:param",
        name: "EditCategoryArticle",
        props: true,
        component: Edit
    },
    {
        path: "/admin/categories/article/list",
        name: "ListCategoryArticle",
        component: List
    }
]