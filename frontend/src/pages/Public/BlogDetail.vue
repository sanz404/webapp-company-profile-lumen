<template>
    <Layout>
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                    <div class="col-lg-3">
                        <div class="d-flex align-items-center mt-lg-5 mb-4">
                            <img class="img-fluid rounded-circle" width="40" src="/images/user.png" :alt="article.author.email" />
                            <div class="ms-3">
                                <div class="fw-bold">{{ article.author.email }}</div>
                                <div class="text-muted">{{ article.date_joined }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <!-- Post content-->
                        <article>
                            <!-- Post header-->
                            <header class="mb-4">
                                <!-- Post title-->
                                <h1 class="fw-bolder mb-1">{{ article.title }}</h1>
                                <!-- Post meta content-->
                                <div class="text-muted fst-italic mb-2">{{ article.date_created }}</div>
                                <!-- Post categories-->
                                <div  v-for="(category) in article.categories" :key="category.id">
                                   <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{ category.name }}</a>
                                </div>
                            </header>
                            <!-- Preview image figure-->
                            <template v-if="article.image">
                                <figure class="mb-4"><img class="img-fluid rounded" :src="backendURL+'/uploads/'+article.image" :alt="article.title" /></figure>
                            </template>
                            <template v-else>
                                <figure class="mb-4"><img class="img-fluid rounded" src="/images/no-image.png" :alt="article.title" /></figure>
                            </template>
                            <!-- Post content-->
                            <section class="mb-5" v-html="article.content"></section>
                        </article>
                        <!-- Comments section-->
                        <section v-if="comment.length > 0">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <!-- Comment form-->
                                    <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
                                        <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
                                    </div>
                                    <form class="mb-4" v-if="canComment" autocomplete="off" @submit.prevent="handleSubmit">
                                        <input type="hidden" v-model="formComment.slug" />
                                        <textarea class="form-control" rows="3" v-model="formComment.description" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.formComment.description.$error }"  placeholder="Join the discussion and leave a comment!"></textarea>
                                         <div v-if="v$.formComment.description.$error" class="invalid-feedback"> {{ v$.formComment.description.$errors[0].$message }} </div>
                                        <button class="btn btn-primary btn-sm mt-2" id="submitButton" type="submit">
                                            <template v-if="status.sendRequest === true">
                                                <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                                            </template>
                                            <template v-else>
                                                Send Comment
                                            </template>
                                        </button>
                                    </form>
                                    <!-- Single comment-->
                                    <div class="d-flex mt-3" v-for="(comment) in article.comments" :key="comment.id">
                                        <div class="flex-shrink-0  mt-10"><img class="rounded-circle" width="65"  src="/images/user.png" alt="..." /></div>
                                        <div class="ms-3">
                                            <div class="fw-bold">
                                                <small>{{ comment.date_created }}</small>
                                                <h4><small>{{ comment.email }}</small></h4>
                                            </div>
                                           {{ comment.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
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
    import { required, minLength } from '@vuelidate/validators'
    import useValidate from '@vuelidate/core'

    export default {
       name: "BlogDetail",
       components: {
            Footer,
            Layout
        },
        props: ['slug'],
        computed: {
            ...mapState('publication', ['status']),
            ...mapState({
                alert: state => state.alert,
                article: state=> state.publication.article,
                comment: state=> state.publication.comment
            })
        },
        data(){
            return {
                helper: helper,
                backendURL: process.env.VUE_APP_SERVICE,
                canComment: this.checkAuth(),
                submitted: false,
                v$: useValidate(),
                formComment:{
                    description: '',
                    slug: this.slug
                },
            }
        },
        created() { 
           this.alert.message = ''
        },
        mounted() {
            this.getArticleBySlug(this.slug)
        },
        methods: {
            ...mapActions('publication', [ 'getArticleBySlug', 'sendComment']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.formComment.$validate()
                if (!this.v$.formComment.$error) {
                    this.sendComment(this.formComment)
                    this.getArticleBySlug(this.slug)
                    this.submitted = false;
                } 
                this.formComment.description = ''
                this.alert.message = ''
            },
            checkAuth(){
                let user = JSON.parse(localStorage.getItem('user'));
                if (user && user.token) {
                    let date_now = Math.floor(Date.now() / 1000)
                    let expired = user.expires_in
                    if(parseInt(date_now) > parseInt(expired)){
                        return false;
                    }else{  
                        return parseInt(user.is_admin) === 0 ? true : false;
                    }
                }else{
                    return false;
                }
            }
        },
        watch: {
            $route (to, from){
                // clear alert on location change
                this.clearAlert();
            }
        },
        validations() {
            return {
                formComment: {
                    description: { 
                        required,
                        minLength: minLength(10)
                    },
                }
            }
        },
        setup() {
            useMeta({
                title: 'Hello World'
            })
        }
    }
</script>