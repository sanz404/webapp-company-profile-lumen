<template>
   <Layout>
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5 d-flex justify-content-center">
                    <div class="col-md-4 mt-4">
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-body p-3 text-center">
                                <div class="alert alert-success">
                                    <p><i class="fa fa-check-circle"></i>&nbsp;Your e-mail is already verified. You can now login. Thank you</p>
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
    import {
        useMeta
    } from 'vue-meta'
    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"
    export default {
        name: "Confirmation",
        components: {
            Footer,
            Layout
        },
        setup() {
            useMeta({
                title: 'Confirmation'
            })
        },
    }
</script>