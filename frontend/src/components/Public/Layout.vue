<template>
    <main class="flex-shrink-0">
        <Navigation :isAuth="this.isAuth" :isAdmin="this.isAdmin" />
        <slot />
    </main>
</template>
<script>
    import Navigation from "./Navigation.vue"
    export default {
        name: "PublicLayout",
        components: {
            Navigation
        },
        data() {
            return {
                isAuth: false,
                isAdmin: false
            }
        },
        mounted() {
            this.initApp();
        },
        unmounted() {
            this.initApp();
        },
        methods: {
            initApp() {
                document.body.classList.add('d-flex', 'flex-column', 'h-100');
                let user = JSON.parse(localStorage.getItem('user'));
                if (user && user.token) {
                    let date_now = Math.floor(Date.now() / 1000)
                    let expired = user.expires_in
                    if(parseInt(date_now) > parseInt(expired)){
                        this.isAuth = false;
                    }else{  
                        this.isAuth = true;
                        this.isAdmin = parseInt(user.is_admin) === 1 ? true : false;
                    }
                }else{
                    this.isAuth = false;
                }

            }
        }
    }
</script>