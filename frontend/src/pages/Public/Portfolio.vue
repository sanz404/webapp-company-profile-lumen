<template>
    <Layout>
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">{{ helper.getContentByKey('page-portfolio-header-title', contents) }}</h1>
                    <p class="lead fw-normal text-muted mb-0">{{ helper.getContentByKey('page-portfolio-header-information', contents) }}</p>
                </div>
                <div class="row gx-5">
                    <div class="col-lg-6" v-for="(project) in projects" :key="project.id">
                        <div class="position-relative mb-5">
                            <template v-if="project.image">
                                <img class="img-fluid rounded-3 mb-3" :src="backendURL+'/uploads/'+project.image" :alt="project.name" />
                            </template>
                            <template v-else>
                                <img class="img-fluid rounded-3 mb-3" src="/images/no-image.png" :alt="project.name" />
                            </template>
                            <router-link :to="{ name: 'PortfolioDetail', params: { param: project.id }}" class="h3 fw-bolder text-decoration-none link-dark stretched-link">
                                {{ project.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 bg-light">
            <div class="container px-5 my-5">
                <h2 class="display-4 fw-bolder mb-4">{{ helper.getContentByKey('page-portfolio-footer-quote', contents) }}</h2>
                <router-link to="/contact" class="btn btn-lg btn-primary">
                   Contact us
                 </router-link>
            </div>
        </section>
        <Footer/>
    </Layout>
</template>
<script>

    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"
    import { mapState, mapActions } from 'vuex'
    import { useMeta } from 'vue-meta'
    import helper from "../../helpers/index"

    export default {
        name: "Portfolio",
        components: {
            Footer,
            Layout
        },
         computed: {
            ...mapState({
                contents: state=> state.publication.contents,
                projects: state=> state.publication.projects
            })
        },
        data(){
            return {
                helper: helper,
                backendURL: process.env.VUE_APP_SERVICE
            }
        },
        mounted() {
            this.getContent()
            this.getProjects()
        },
        methods: {
            ...mapActions('publication', [ 'getContent', 'getProjects'])
        },
        setup() {
            useMeta({
                title: 'Portfolio'
            })
        }
    }
</script>