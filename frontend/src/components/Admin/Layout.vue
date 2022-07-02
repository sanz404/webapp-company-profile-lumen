<template>
    <div id="page-admin">
        <div class="sb-nav-fixed" id="admin-container">
            <Navigation :isAuth="this.isAuth" :isAdmin="this.isAdmin"/>
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <SideBar/>
                </div>
                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                            <slot />
                        </div>
                    </main>
                    <footer class="py-4 bg-light mt-auto">
                        <div class="container-fluid px-4">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; {{ siteName }} {{ new Date().getFullYear() }}</div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import Navigation from "./Navigation.vue"
import SideBar from "./Sidebar.vue"

export default{
    name: "AdminLayout",
    data() {
        return {
            isAuth: true,
            isAdmin: false,
            siteName: process.env.VUE_APP_TITLE
        }
    },
    components:{
        Navigation,
        SideBar
    },
    mounted() {
        this.initApp();
    },
    unmounted() {
        this.initApp();
    },
    methods: {
        initApp() {
            document.body.classList.remove('d-flex', 'flex-column', 'h-100');
        }
    }
}

</script>