<template>
   <Layout>
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mb-5">
                            <h1 class="fw-bolder">{{ project.name }}</h1>
                            <p class="lead fw-normal text-muted mb-0">
                                {{ project.information }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row gx-5">
                    <template v-if="project.image">
                         <div class="col-12"><img class="img-fluid rounded-3 mb-5" :src="backendURL+'/uploads/'+project.image" :alt="project.name" /></div>
                        <div class="col-lg-6"><img class="img-fluid rounded-3 mb-5"  :src="backendURL+'/uploads/'+project.image" :alt="project.name" /></div>
                        <div class="col-lg-6"><img class="img-fluid rounded-3 mb-5"  :src="backendURL+'/uploads/'+project.image" :alt="project.name" /></div>
                    </template>
                    <template v-else>
                         <div class="col-12"><img class="img-fluid rounded-3 mb-5" src="/images/no-image.png" :alt="project.name" /></div>
                        <div class="col-lg-6"><img class="img-fluid rounded-3 mb-5" src="/images/no-image.png" :alt="project.name" /></div>
                        <div class="col-lg-6"><img class="img-fluid rounded-3 mb-5"  src="/images/no-image.png" :alt="project.name" /></div>
                    </template>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mb-5">
                            <p class="lead fw-normal text-muted">{{ project.description }}.</p>
                            <router-link to="/contact" class="text-decoration-none">
                                 View project
                                <i class="bi-arrow-right"></i>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Footer />
   </Layout>
</template>
<script>

    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"
    import { mapState, mapActions } from 'vuex'
    import { useMeta } from 'vue-meta'
    import helper from "../../helpers/index"

    export default {
        name: "PortfolioDetail",
        components: {
            Footer,
            Layout
        },
        props: ['param'],
        computed: {
            ...mapState({
                project: state=> state.publication.project
            })
        },
        data(){
            return {
                helper: helper,
                backendURL: process.env.VUE_APP_SERVICE
            }
        },
        mounted() {
            this.getProjectById(this.param)
        },
        methods: {
            ...mapActions('publication', [ 'getProjectById'])
        },
        setup() {
            useMeta({
                title: 'Hello World'
            })
        }
    }
</script>