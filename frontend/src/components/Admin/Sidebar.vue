<template>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Main Menu</div>
                <router-link to="/admin/dashboard" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer"></i></div>
                    Dashboard
                </router-link>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Categories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <router-link to="/admin/categories/article/list" class="nav-link">Article</router-link>
                        <router-link to="/admin/categories/faq/list" class="nav-link">Faq</router-link>
                        <router-link to="/admin/categories/product/list" class="nav-link">Product</router-link>
                        <router-link to="/admin/categories/project/list" class="nav-link">Project</router-link>
                    </nav>
                </div>
                <router-link to="/admin/content/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-laptop"></i></div>
                    Content
                </router-link>
                <router-link to="/admin/about/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-clone"></i></div>
                    About Page
                </router-link>
                <router-link to="/admin/article/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></div>
                    Article
                </router-link>
                 <router-link to="/admin/contact/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-child"></i></div>
                    Contact
                </router-link>
                 <router-link to="/admin/message/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-phone-square-alt"></i></div>
                    Message
                </router-link>
                <router-link to="/admin/team/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                    Team
                </router-link>
                 <router-link to="/admin/faq/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-share-alt-square"></i></div>
                    Faq
                </router-link>
                 <router-link to="/admin/feature/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-outdent"></i></div>
                    Feature
                </router-link>
                 <router-link to="/admin/product/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                    Product
                </router-link>
                 <router-link to="/admin/project/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-address-card"></i></div>
                    Portfolio
                </router-link>
                 <router-link to="/admin/user/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    User
                </router-link>
                <div class="sb-sidenav-menu-heading">Account Menu</div>
                 <router-link to="/admin/notification/list" class="nav-link">
                  <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Notification&nbsp;<span class="badge rounded-pill bg-danger">{{ total_unread }}</span>
                </router-link>
                <router-link to="/admin/account/profile" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Profile
                </router-link>
                <router-link to="/admin/account/password" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                    Change Password
                </router-link>
                <router-link to="/auth/logout" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out"></i></div>
                    Log Out
                </router-link>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ profile.email }}
        </div>
    </nav>
</template>
<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        name: "SideBar",
        computed: {
            ...mapState({
                profile: state=> state.account.profile,
                total_unread: state=> state.notification.current.total_unread,
            })
        },
        mounted() {
           this.getProfile()
           this.getCurrent()
        },
        methods: {
            ...mapActions('account', {
                getProfile: 'profile',
            }),
            ...mapActions('notification', {
                getCurrent: 'current',
            })
        },
    }
</script>