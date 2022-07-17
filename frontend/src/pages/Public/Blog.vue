<template>
    <Layout>
        <!-- Page Content-->
        <section class="py-5" v-if="articles.length > 0">
            <div class="container px-5">
                <h1 class="fw-bolder fs-5 mb-4">Company Blog</h1>
                <div class="card border-0 shadow rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row gx-0">
                            <div class="col-lg-6 col-xl-5 py-lg-5">
                                <div class="p-4 p-md-5">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2"  v-for="(category) in articles[0].categories" :key="category.id">
                                        {{ category }}
                                    </div>
                                    <div class="h2 fw-bolder">{{ articles[0].detail.title }}</div>
                                    <p>{{ articles[0].detail.content }}</p>
                                    <router-link :to="{ name: 'BlogDetail', params: { slug: articles[0].detail.slug }}" class="stretched-link text-decoration-none">
                                        Read more
                                        <i class="bi bi-arrow-right"></i>
                                    </router-link>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-7">
                               <template v-if="articles[0].detail.image">
                                    <div class="bg-featured-blog" :style="`background-image: url('`+backendURL+'/uploads/'+articles[0].detail.image+`')`"></div>
                               </template>
                               <template v-else>
                                    <div class="bg-featured-blog" style="background-image: url('/images/no-image.png')"></div>
                               </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 bg-light">
            <div class="container px-5">
                <div class="row gx-5">
                    <div class="col-xl-8">
                        <h2 class="fw-bolder fs-5 mb-4">News</h2>
                        <!-- News item-->
                        <div class="mb-4"  v-for="(article) in articles" :key="article.id">
                            <div class="small text-muted">{{ article.detail.date_created  }}</div>
                            <router-link :to="{ name: 'BlogDetail', params: { slug: article.detail.slug }}" class="link-dark">
                                <h3>{{ article.detail.title }}</h3>
                            </router-link>
                        </div>
                        <div class="text-end mb-5 mb-xl-0">
                            <router-link to="/articles/list" class="text-decoration-none">
                                More news
                                <i class="bi bi-arrow-right"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card border-0 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex h-100 align-items-center justify-content-center">
                                    <div class="text-center">
                                        <div class="h6 fw-bolder">Contact</div>
                                        <p class="text-muted mb-4">
                                            For press inquiries, email us at
                                            <br />
                                            <a :href="'mailto:' + helper.getContentByKey('contact-email', contents)">{{ helper.getContentByKey('contact-email', contents) }}</a>
                                        </p>
                                        <div class="h6 fw-bolder">Follow us</div>
                                        <a class="fs-5 px-2 link-dark" :href="'https://www.twitter.com/' + helper.getContentByKey('contact-twitter', contents)"><i class="bi-twitter"></i></a>
                                        <a class="fs-5 px-2 link-dark" :href="'https://www.facebook.com/' + helper.getContentByKey('contact-facebook', contents)"><i class="bi-facebook"></i></a>
                                        <a class="fs-5 px-2 link-dark" :href="'https://www.linkedin.com/' + helper.getContentByKey('contact-linked-in', contents)"><i class="bi-linkedin"></i></a>
                                        <a class="fs-5 px-2 link-dark" :href="'https://www.youtube.com/' + helper.getContentByKey('contact-youtube', contents)"><i class="bi-youtube"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog preview section-->
        <section class="py-5">
            <div class="container px-5">
                <h2 class="fw-bolder fs-5 mb-4">Featured Stories</h2>
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
                <div class="text-end mb-5 mb-xl-0">
                    <router-link to="/articles/list" class="text-decoration-none">
                        More stories
                        <i class="bi bi-arrow-right"></i>
                     </router-link>
                </div>
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
        name: "Blog",
        components: {
            Footer,
            Layout
        },
        computed: {
            ...mapState({
                contents: state=> state.publication.contents,
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
            this.getHomeArticle()
        },
        methods: {
            ...mapActions('publication', [ 'getContent', 'getHomeArticle'])
        },
        setup(){
            useMeta({  title: 'Blog' })
        }
    }
</script>