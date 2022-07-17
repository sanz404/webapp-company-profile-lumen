<template>
    <Layout>
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">{{ helper.getContentByKey('page-faq-header-title', contents) }}</h1>
                    <p class="lead fw-normal text-muted mb-0">{{ helper.getContentByKey('page-faq-header-question', contents) }}</p>
                </div>
                <div class="row gx-5">
                    <div class="col-xl-8">
                        <div v-for="(faq) in faqs" :key="faq.id">
                            <h2 class="fw-bolder mb-3">{{ faq.category_name }}</h2>
                            <div class="accordion mb-5" :id="'accordionExample'+faq.category_id">
                                <div class="accordion-item"  v-for="(detail, item) in faq.details" :key="detail.id">
                                    <h3 class="accordion-header" :id="'headingOne'+detail.id">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseOne'+detail.id" aria-expanded="true"  :aria-controls="'collapseOne'+detail.id">{{ detail.question }}</button></h3>
                                        <div :class=" item === 0 ? 'accordion-collapse collapse show' : 'accordion-collapse collapse' " :id="'collapseOne'+detail.id" aria-labelledby="headingOne" :data-bs-parent="'#accordionExample'+detail.category_id">
                                        <div class="accordion-body">
                                            {{ detail.answer }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card border-0 bg-light mt-xl-5">
                            <div class="card-body p-4 py-lg-5">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <div class="h6 fw-bolder">Have more questions?</div>
                                        <p class="text-muted mb-4">
                                            Contact us at
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
        name: "Faq",
        components: {
            Footer,
            Layout
        },
         computed: {
            ...mapState({
                contents: state=> state.publication.contents,
                faqs: state=> state.publication.faqs
            })
        },
         data(){
            return {
                helper: helper
            }
        },
        mounted() {
            this.getContent()
            this.getFaq()
        },
        methods: {
            ...mapActions('publication', [ 'getContent', 'getFaq'])
        },
        setup() {
            useMeta({
                title: 'Faq'
            })
        }
    }
</script>