import Create from "../../pages/Admin/Article/Create.vue"
import Detail from "../../pages/Admin/Article/Detail.vue"
import Edit from "../../pages/Admin/Article/Edit.vue"
import List from "../../pages/Admin/Article/List.vue"

export default [
    {
        path: "/admin/article/create",
        name: "CreateArticle",
        component: Create
    },
    {
        path: "/admin/article/detail/:param",
        name: "DetailArticle",
        props: true,
        component: Detail
    },
    {
        path: "/admin/article/edit/:param",
        name: "EditArticle",
        props: true,
        component: Edit
    },
    {
        path: "/admin/article/list",
        name: "ListArticle",
        component: List
    }
]