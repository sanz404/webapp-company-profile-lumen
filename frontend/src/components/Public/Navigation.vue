<template>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container px-5">
            <router-link to="/" class="navbar-brand">{{ siteName }}</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                            <router-link to="/home" class="nav-link">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/about" class="nav-link">About Us</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/contact" class="nav-link">Contact</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/faq" class="nav-link">Faq</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/pricing" class="nav-link">Pricing</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/blog" class="nav-link">Blog</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/portfolio" class="nav-link">Portfolio</router-link>
                    </li>
                    <template v-if="isAuth">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                <template v-if="isAdmin">
                                    <li>
                                        <router-link to="/admin/dashboard" class="dropdown-item">Admin Page</router-link>
                                    </li>
                                </template>
                                <template v-else>
                                    <li>
                                        <router-link to="/account/password" class="dropdown-item">Change Password</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/account/profile" class="dropdown-item">My Profile</router-link>
                                    </li>
                                </template>
                                <li>
                                    <router-link to="/auth/logout" class="dropdown-item">Log Out</router-link>
                                </li>
                            </ul>
                        </li>
                    </template>
                    <template v-else>
                         <li class="nav-item">
                            <router-link to="/auth/login" class="nav-link">Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/auth/register" class="nav-link">Register</router-link>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
    export default  {
        name: "Navigation",
        props:['isAuth', 'isAdmin'],
        data(){
            return {
                siteName: process.env.VUE_APP_TITLE
            }
        }
    }
</script>