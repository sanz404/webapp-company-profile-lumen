<template>
    <Layout>
        <section class="py-5" id="page-error">
            <div class="error-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="error-text">
                                <h1 class="error">{{ header }}</h1>
                                <div class="im-sheep">
                                    <div class="top">
                                        <div class="body"></div>
                                        <div class="head">
                                            <div class="im-eye one"></div>
                                            <div class="im-eye two"></div>
                                            <div class="im-ear one"></div>
                                            <div class="im-ear two"></div>
                                        </div>
                                    </div>
                                    <div class="im-legs">
                                        <div class="im-leg"></div>
                                        <div class="im-leg"></div>
                                        <div class="im-leg"></div>
                                        <div class="im-leg"></div>
                                    </div>
                                </div>
                                <h4>{{ info1 }}</h4>
                                <p>{{ info2 }}</p>
                                <router-link to="/" class="btn btn-primary btn-round">Go to homepage</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>
<script>
    import {
        useMeta
    } from 'vue-meta'
    import Layout from "../../components/Public/Layout.vue"
    export default {
        name: "Page503",
        components: {
            Layout
        },
        data(){
            return {
                header:"503 This site is getting a tune-up",
                info1:"Oops! This page Could Not Be Found!",
                info2:"Why don't you come back in a little while and see if our expert are finished tinkering"
            }
        },
        setup() {
            useMeta({
                title: 'This site is getting a tune-up',
                layout: false
            })
        }
    }
</script>