<template>
   <Layout>
        <!-- Pricing section-->
        <section class="bg-light py-5">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">{{ helper.getContentByKey('page-pricing-header-title', contents) }}</h1>
                    <p class="lead fw-normal text-muted mb-0">{{ helper.getContentByKey('page-pricing-header-information', contents) }}</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <!-- Pricing card free-->
                    <div class="col-lg-6 col-xl-4"  v-for="(product) in products" :key="product.id">
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-body p-5">
                                <div class="small text-uppercase fw-bold text-muted">{{ product.name }}</div>
                                <div class="mb-3">
                                    <span class="display-4 fw-bold">$ {{ Number(product.price).toFixed(1) }}</span>
                                    <span class="text-muted">/ mo.</span>
                                </div>
                                <div v-html="product.description"></div>
                                <div class="d-grid">
                                    <router-link to="/contact" class="btn btn-outline-primary">
                                        Choose plan
                                    </router-link>
                                </div>
                            </div>
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
        name: "Pricing",
        components: {
            Footer,
            Layout
        },
        computed: {
            ...mapState({
                contents: state=> state.publication.contents,
                products: state=> state.publication.products
            })
        },
        data(){
            return {
                helper: helper
            }
        },
        mounted() {
            this.getContent()
            this.getProduct()
        },
        methods: {
            ...mapActions('publication', [ 'getContent', 'getProduct'])
        },
        setup() {
            useMeta({
                title: 'Pricing'
            })
        }
    }
</script>