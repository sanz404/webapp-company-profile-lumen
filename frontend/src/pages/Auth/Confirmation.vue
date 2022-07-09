<template>
   <Layout>
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5 d-flex justify-content-center">
                    <div class="col-md-4 mt-4">
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-body p-3 text-center">
                                <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
                                    <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
                                </div>
                                <div class="text-center">
                                    <router-link to="/auth/login" class="btn w-100 btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to continue">Click here to continue...</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="fixed-bottom">
            <Footer/>
        </div>
   </Layout>
</template>
<script>

    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"

    export default {
        props: ['token'],
        name: "Confirmation",
        components: {
            Footer,
            Layout
        },
        computed: {
            ...mapState('auth', ['status']),
            ...mapState({
                alert: state => state.alert
            })
        },
        created() {
           this.logged();
           this.confirmAccount();
           this.alert.message = ''
        },
        methods: {
            ...mapActions('auth', ['confirm',  'logged']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            confirmAccount(){
                if(this.token){
                    this.confirm(this.token);
                }
            }
        },
        setup() {
            useMeta({
                title: 'Confirmation'
            })
        },
        watch: {
            $route (to, from){
                // clear alert on location change
                this.clearAlert();
            }
        } 
    }
</script>