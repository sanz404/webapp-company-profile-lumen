<template>
    <Layout>
        <!-- Header-->
        <header class="py-5">
            <div class="container px-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xxl-6">
                        <div class="text-center my-5">
                            <h1 class="fw-bolder mb-3">{{ helper.getContentByKey('page-about-header-title', contents) }}</h1>
                            <p class="lead fw-normal text-muted mb-4">
                                {{ helper.getContentByKey('page-about-header-info', contents) }}
                            </p>
                            <a class="btn btn-primary btn-lg" href="#scroll-target">{{ helper.getContentByKey('page-about-header-button-text', contents) }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- About section one-->
        <section :class="about.id % 2 === 0 ? 'py-5' : 'py-5  bg-light' "  id="scroll-target" v-for="(about) in abouts" :key="about.id">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div :class="about.id % 2 === 0 ? 'col-lg-6 order-first order-lg-last' : 'col-lg-6' ">
                        <template v-if="about.image">
                            <img class="img-fluid rounded mb-5 mb-lg-0" :src="backendURL+'/uploads/'+about.image" :alt="about.title" />
                        </template>
                        <template v-else>
                            <img class="img-fluid rounded mb-5 mb-lg-0" src="/images/no-image.png" :alt="about.title" />
                        </template>
                    </div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">{{ about.title }}</h2>
                        <p class="lead fw-normal text-muted mb-0">
                            {{ about.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team members section-->
        <section class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="text-center">
                    <h2 class="fw-bolder">{{ helper.getContentByKey('page-about-team-title', contents) }}</h2>
                    <p class="lead fw-normal text-muted mb-5">{{ helper.getContentByKey('page-about-team-information', contents) }}</p>
                </div>
                <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5 mb-5 mb-xl-0" v-for="(team) in teams" :key="team.id"> 
                        <div class="text-center">
                            <template v-if="team.image">
                                <img class="img-fluid rounded-circle mb-4 px-4" :src="backendURL+'/uploads/'+team.image" :alt="team.name" />
                            </template>
                            <template v-else>
                                <img class="img-fluid rounded-circle mb-4 px-4" src="/images/user.png" :alt="team.name" />
                            </template>
                            <h5 class="fw-bolder">{{ team.name }}</h5>
                            <div class="fst-italic text-muted">{{ team.position }}</div>
                        </div>
                    </div>
                </div>
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
        name: "About",
        components: {
            Footer,
            Layout
        },
         computed: {
            ...mapState({
                contents: state=> state.publication.contents,
                teams: state=> state.publication.teams,
                abouts: state=> state.publication.abouts
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
            this.getAbout()
            this.getTeam()
        },
        methods: {
            ...mapActions('publication', [ 'getContent', 'getAbout', 'getTeam'])
        },
        setup() {
            useMeta({
                title: 'About'
            })
        }
    }
</script>