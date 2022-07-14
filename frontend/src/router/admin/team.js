import Create from "../../pages/Admin/Team/Create.vue"
import Detail from "../../pages/Admin/Team/Detail.vue"
import Edit from "../../pages/Admin/Team/Edit.vue"
import List from "../../pages/Admin/Team/List.vue"

export default [
    {
        path: "/admin/team/create",
        name: "CreateTeam",
        component: Create
    },
    {
        path: "/admin/team/detail/:param",
        name: "DetailTeam",
        props: true,
        component: Detail
    },
    {
        path: "/admin/team/edit/:param",
        name: "EditTeam",
        props: true,
        component: Edit
    },
    {
        path: "/admin/team/list",
        name: "ListTeam",
        component: List
    }
]