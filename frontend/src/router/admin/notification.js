import Detail from "../../pages/Admin/Notification/Detail.vue"
import List from "../../pages/Admin/Notification/List.vue"

export default [
    
    {
        path: "/admin/notification/detail/:param",
        name: "DetailNotifiaction",
        props: true,
        component: Detail
    },
    {
        path: "/admin/notification/list",
        name: "ListNotifiaction",
        component: List
    }
]