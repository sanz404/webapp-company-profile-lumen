import Detail from "../../pages/Admin/Message/Detail.vue"
import List from "../../pages/Admin/Message/List.vue"

export default [
    {
        path: "/admin/message/detail/:param",
        name: "DetailMessage",
        props: true,
        component: Detail
    },
    {
        path: "/admin/message/list",
        name: "ListMessage",
        component: List
    }
]