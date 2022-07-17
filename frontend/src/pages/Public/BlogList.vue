<template>
    <Layout>

         <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">{{ helper.getContentByKey('page-blog-header-title', contents) }}</h1>
                    <p class="lead mb-0">{{ helper.getContentByKey('page-blog-header-information', contents) }}</p>
                </div>
            </div>
        </header>

           <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->

                    <div class="card mb-4" v-if="articles.length > 0">
                        <template v-if="articles[0].detail.image">
                            <a :href="backendURL+'/uploads/'+articles[0].detail.image">
                                <img class="card-img-top" :src="backendURL+'/uploads/'+articles[0].detail.image" :alt="articles[0].detail.title" />
                            </a>
                        </template>
                        <template v-else>
                             <a href="/images/no-image.png">
                                <img class="card-img-top" src="/images/no-image.png" :alt="articles[0].detail.title" />
                            </a>
                        </template>
                        <div class="card-body">
                            <div class="small text-muted">{{ articles[0].detail.date_created }}</div>
                            <h2 class="card-title">{{ articles[0].detail.title }}</h2>
                            <p class="card-text">{{ articles[0].detail.content }}</p>
                            <router-link :to="{ name: 'BlogDetail', params: { slug: articles[0].detail.slug }}" class="btn btn-primary">
                                Read more →
                           </router-link>
                        </div>
                    </div>

                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-4" v-for="(article) in listArticles.slice(0,2)" :key="article.id">
                                <template v-if="article.image">
                                    <a :href="backendURL+'/uploads/'+article.image">
                                        <img class="card-img-top" :src="backendURL+'/uploads/'+article.image" :alt="article.title" />
                                    </a>
                                </template>
                                <template v-else>
                                    <a href="/images/no-image.png">
                                        <img class="card-img-top" src="/images/no-image.png" :alt="article.title" />
                                    </a>
                                </template>
                                <div class="card-body">
                                    <div class="small text-muted">{{ article.date_created  }}</div>
                                    <h2 class="card-title h4">{{ article.title  }}</h2>
                                    <p class="card-text">{{ article.content  }}</p>
                                    <router-link :to="{ name: 'BlogDetail', params: { slug: article.slug }}" class="btn btn-primary">
                                        Read more →
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card mb-4" v-for="(article) in listArticles.slice(2,4)" :key="article.id">
                                <template v-if="article.image">
                                    <a :href="backendURL+'/uploads/'+article.image">
                                        <img class="card-img-top" :src="backendURL+'/uploads/'+article.image" :alt="article.title" />
                                    </a>
                                </template>
                                <template v-else>
                                    <a href="/images/no-image.png">
                                        <img class="card-img-top" src="/images/no-image.png" :alt="article.title" />
                                    </a>
                                </template>
                                <div class="card-body">
                                    <div class="small text-muted">{{ article.date_created  }}</div>
                                    <h2 class="card-title h4">{{ article.title  }}</h2>
                                    <p class="card-text">{{ article.content  }}</p>
                                    <router-link :to="{ name: 'BlogDetail', params: { slug: article.slug }}" class="btn btn-primary">
                                        Read more →
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination-->
                    <nav aria-label="Pagination">
                        <hr class="my-0" />
                        <div class="pagination justify-content-center my-4">
                            <pagination v-model="page" :records="totalRecords" :per-page="4" @paginate="myCallback($event)"/>
                        </div>
                    </nav>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" v-model="search"  type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" @click="searchData" type="button">Go!</button>
                            </div>
                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">Web Design</a></li>
                                        <li><a href="#!">HTML</a></li>
                                        <li><a href="#!">Freebies</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">JavaScript</a></li>
                                        <li><a href="#!">CSS</a></li>
                                        <li><a href="#!">Tutorials</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">{{ helper.getContentByKey('page-blog-sidebar-title', contents) }}</div>
                        <div class="card-body">{{ helper.getContentByKey('page-blog-sidebar-information', contents) }}</div>
                    </div>
                </div>
            </div>
        </div>
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
    name: "BlogList",
    components: {
        Footer,
        Layout
    },
    computed: {
        ...mapState({
            contents: state=> state.publication.contents,
            articles: state=> state.publication.homeArticle,
            listArticles: state=> state.publication.listArticles,
            totalRecords: state=> state.publication.listArticleTotal
        })
    },
    data(){
        return {
            helper: helper,
            backendURL: process.env.VUE_APP_SERVICE,
            page: 1,
            limitperpage: 4,
            search: ""
        }
    },
    mounted() {
        this.getContent()
        this.getHomeArticle()
        this.getListArticle({ limit: this.limitperpage, offset: Math.round(this.page / this.limitperpage), search : this.search  })
    },
    methods: {
        ...mapActions('publication', [ 'getContent', 'getHomeArticle', 'getListArticle']),
        myCallback(e){
            let limit = this.limitperpage
            let offset = e/limit
            offset = Math.round(offset)
            this.getListArticle({ limit: limit, offset: offset, search : this.search })
        },
        searchData(){
            this.getListArticle({ limit: this.limitperpage, offset: Math.round(this.page / this.limitperpage), search : this.search  })
        }
    },
    setup(){
        useMeta({  title: 'Blog' })
    }
}

</script>