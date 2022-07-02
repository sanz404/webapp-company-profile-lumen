<template>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <!-- Navbar Brand-->
        <router-link to="/" class="navbar-brand ps-3">{{ siteName }}</router-link>
        <!-- Sidebar Toggle-->
        <button @click="toggleSideBar" class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i><sup><span class="badge rounded-pill bg-danger">{{ Math.floor(Math.random() * 100) }}</span></sup>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-3 notification-dropdown">
                    <router-link :to="'/admin/notification/detail/'+Math.floor(Math.random() * 100)" class="text-notification">
                        <div class="clearfix">
                            <div class="float-start">
                                <strong><small>Lorem Ipsum</small></strong>
                            </div>
                            <div class="float-end">
                                <strong><small>1 days ago</small></strong>
                            </div>
                        </div>
                        <p class="text-justify mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </router-link>
                    <hr class="dropdown-divider" />
                    <router-link :to="'/admin/notification/detail/'+Math.floor(Math.random() * 100)" class="text-notification">
                        <div class="clearfix">
                            <div class="float-start">
                                <strong><small>Lorem Ipsum</small></strong>
                            </div>
                            <div class="float-end">
                                <strong><small>1 days ago</small></strong>
                            </div>
                        </div>
                        <p class="text-justify mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </router-link>
                    <hr class="dropdown-divider" />
                    <router-link :to="'/admin/notification/detail/'+Math.floor(Math.random() * 100)" class="text-notification">
                        <div class="clearfix">
                            <div class="float-start">
                                <strong><small>Lorem Ipsum</small></strong>
                            </div>
                            <div class="float-end">
                                <strong><small>1 days ago</small></strong>
                            </div>
                        </div>
                        <p class="text-justify mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </router-link>
                    <hr class="dropdown-divider" />
                    <router-link to="/admin/notification/list" class="btn btn-sm btn-warning text-white w-100">See All Notifiaction</router-link>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-plus fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                     <li>
                        <router-link to="/" class="dropdown-item"><i class="fas fa-home"></i>&nbsp;Back to Home</router-link>
                    </li>
                    <li>
                        <router-link to="/admin/account/profile" class="dropdown-item"><i class="fas fa-user"></i>&nbsp;Profile</router-link>
                    </li>
                    <li>
                        <router-link to="/admin/account/password" class="dropdown-item"><i class="fas fa-lock"></i>&nbsp;Password</router-link>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <router-link to="/auth/logout" class="dropdown-item"><i class="fas fa-sign-out"></i>&nbsp;Log Out</router-link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>
<script>
    export default{
        name: "Navigation",
        props:['isAuth', 'isAdmin'],
        data(){
            return {
                siteName: process.env.VUE_APP_TITLE
            }
        },
        setup(){

            function toggleSideBar(){
                let element = document.getElementById("admin-container");
                if(element){    
                    element.classList.toggle("sb-sidenav-toggled");
                    localStorage.setItem('sb|sidebar-toggle', element.classList.contains('sb-sidenav-toggled'));
                }
            }

            return { toggleSideBar };

        }
    }
</script>