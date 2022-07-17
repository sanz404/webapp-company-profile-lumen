<template>
    <Layout>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-7 col-xxl-6">
                        <div class="my-5 text-center text-xl-start">
                            <h1 class="display-5 fw-bolder text-white mb-2">{{ helper.getContentByKey('page-home-header-heading', contents) }}
                            </h1>
                            <p class="lead fw-normal text-white-50 mb-4">{{ helper.getContentByKey('page-home-header-information', contents) }}
                            </p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <router-link to="/contact" class="btn btn-primary btn-lg px-4 me-sm-3">
                                    {{ helper.getContentByKey('page-home-header-button1', contents) }}
                                </router-link>
                                 <router-link to="/about" class="btn btn-outline-light btn-lg px-4">
                                   {{ helper.getContentByKey('page-home-header-button2', contents) }}
                                </router-link>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5"
                            :src="helper.getContentByKey('page-home-header-image', contents)" alt="..." /></div>
                </div>
            </div>
        </header>
        <!-- Features section-->
        <section class="py-5" id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h2 class="fw-bolder mb-0">{{ helper.getContentByKey('page-home-feature-section-title', contents) }}</h2>
                    </div>
                    <div class="col-lg-8">
                        <div class="row gx-5 row-cols-1 row-cols-md-2">
                            <div class="col mb-5 h-100" v-for="(item) in features" :key="item.id">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                        :class="item.icon"></i></div>
                                <h2 class="h5">{{ item.title }}</h2>
                                <p class="mb-0">{{ item.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial section-->
        <div class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-10 col-xl-7">
                        <div class="text-center">
                            <div class="fs-4 mb-4 fst-italic">"{{ helper.getContentByKey('page-home-testimonial-content', contents) }}"</div>
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="rounded-circle me-3" width="85" src="/images/user.png"  alt="..." />
                                <div class="fw-bold">
                                    {{ helper.getContentByKey('page-home-testimonial-name', contents) }}
                                    <span class="fw-bold text-primary mx-1">/</span>
                                    {{ helper.getContentByKey('page-home-testimonial-position', contents) }}, {{ helper.getContentByKey('page-home-testimonial-company', contents) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog preview section-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <div class="text-center">
                            <h2 class="fw-bolder">{{ helper.getContentByKey('page-home-blog-title', contents) }}</h2>
                            <p class="lead fw-normal text-muted mb-5">{{ helper.getContentByKey('page-home-blog-subtitle', contents) }}</p>
                        </div>
                    </div>
                </div>
                <div class="row gx-5">
                   <div class="col-lg-4 mb-5"  v-for="(article) in articles" :key="article.id">
                        <div class="card h-100 shadow border-0">
                            <template v-if="article.detail.image">
                                <img class="card-img-top" :src="backendURL+'/uploads/'+article.detail.image" :alt="article.detail.title" />
                            </template>
                            <template v-else>
                                <img class="card-img-top" src="/images/no-image.png" :alt="article.detail.title" />
                            </template>
                            <div class="card-body p-4">
                                <div class="badge bg-primary bg-gradient rounded-pill mb-2"  v-for="(category) in article.categories" :key="category.id">
                                    {{ category }}
                                </div>
                                <router-link :to="{ name: 'BlogDetail', params: { slug: article.detail.slug }}" class="text-decoration-none link-dark stretched-link">
                                     <h5 class="card-title mb-3">{{ article.detail.title }}</h5>
                                </router-link>
                                <p class="card-text mb-0">
                                    {{ article.detail.content  }}
                                </p>
                            </div>
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                <div class="d-flex align-items-end justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle me-3" width="40" src="/images/user.png" :alt="article.detail.title" />
                                        <div class="small">
                                            <div class="fw-bold">{{ article.detail.author.email  }}</div>
                                            <div class="text-muted">{{ article.detail.date_created  }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Call to action-->
                <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                    <div
                        class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                        <div class="mb-4 mb-xl-0">
                            <div class="fs-3 fw-bold text-white">{{ helper.getContentByKey('page-home-call-to-action-info1', contents) }}</div>
                            <div class="text-white-50">{{ helper.getContentByKey('page-home-call-to-action-info2', contents) }}</div>
                        </div>
                        <div class="ms-xl-4">
                            <div class="input-group mb-2">
                                <router-link to="/contact" class="btn btn-outline-light w-100">
                                    Contact Here
                                </router-link>
                            </div>
                            <div class="small text-white-50">{{ helper.getContentByKey('page-home-call-to-action-info3', contents) }}</div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
        <Footer/>
    </Layout>
</template>

<script>

    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"
    import helper from "../../helpers/index"

    export default {
        name: "Home",
        components: {
            Footer,
            Layout
        },
        computed: {
            ...mapState({
                contents: state=> state.publication.contents,
                features: state=> state.publication.features,
                articles: state=> state.publication.homeArticle
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
            this.getFeature()
            this.getHomeArticle()
        },
        methods: {
            ...mapActions('publication', [ 'getContent', 'getFeature', 'getHomeArticle'])
        },
        setup(){
            useMeta({  title: 'Home' })
        }
    }
</script>