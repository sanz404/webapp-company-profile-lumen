<template>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Main Menu</div>
                <router-link to="/admin/dashboard" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer"></i></div>
                    Dashboard
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
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                    Message
                </router-link>
                 <router-link to="/admin/service/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-gift"></i></div>
                    Service
                </router-link>
                  <router-link to="/admin/team/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                    Team
                </router-link>
                 <router-link to="/admin/faq/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-share-alt-square"></i></div>
                    Faq
                </router-link>
                 <router-link to="/admin/product/list" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                    Product
                </router-link>
                 <router-link to="/admin/portfolio/list" class="nav-link">
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
                    Notification&nbsp;<span class="badge rounded-pill bg-primary">{{ Math.floor(Math.random() * 100) }}</span>
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
            {{ user.full_name }}
        </div>
    </nav>
</template>
<script>
    export default {
        name: "SideBar",
        data(){
            return {
                user: {
                    full_name: "Sandy Andryanto"
                }
            }
        }
    }
</script>