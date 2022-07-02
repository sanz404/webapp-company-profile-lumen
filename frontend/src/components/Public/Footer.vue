<template>
    <footer class="bg-primary py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright &copy; {{ siteName }} {{ new Date().getFullYear() }}</div>
                </div>
                <div class="col-auto">
                    <a class="link-light small" href="#!">Privacy</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Terms</a>
                    <span class="text-white mx-1">&middot;</span>
                    <router-link to="/contact" class="link-light small">Contact</router-link>
                </div>
            </div>
        </div>
    </footer>
</template>
<script>
    export default  {
        name: "Footer",
        data(){
            return {
                siteName: process.env.VUE_APP_TITLE
            }
        }
    }
</script>