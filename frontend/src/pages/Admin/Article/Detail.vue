<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Reference</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/article/list">{{ title }}</router-link></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
        <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
            <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
        </div>
        <form autocomplete="off">
             <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6><i class="fas fa-search"></i>&nbsp;Detail of {{ title }}</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Image </label>
                        <div class="col-sm-10">
                             <template v-if="article.image">
                                <img :src="this.backendURL+'/uploads/'+article.image" class="img-thumbnail" width="400" />
                            </template>
                            <template v-else>
                                 <img :src="'/images/no-image.png'" class="img-thumbnail" width="400" />
                            </template>
                        </div>
                    </div>
                    
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Categories </label>
                        <div class="col-sm-10">
                            <v-select multiple  :options="articleCategories" v-model="article.categorySelected" :disabled="true"></v-select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Title </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="article.title"  />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Content <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                           <ckeditor :editor="editor" v-model="article.content" :disabled="true" :config="editorConfig"></ckeditor>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Status </label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" v-model="article_status"  />
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/article/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>&nbsp;Back To List
                        </router-link>
                        &nbsp;
                    </div>
                    <div class="float-end"></div>
                </div>
            </div>
        </form>
    </Layout>
</template>
<script>

    import Layout from "../../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import ClassicEditor from "@ckeditor/ckeditor5-build-classic"

    const SITE_TITLE = "Article";

    export default {
        name: "DetailArticle",
        components: {
            Layout
        },
        props: ['param'],
        data(){
            return {
                title: SITE_TITLE,
                backendURL: process.env.VUE_APP_SERVICE,
                editor: ClassicEditor,
                editorConfig: { }
            }
        },
        computed: {
            ...mapState({
                alert: state => state.alert,
                status: state=> state.article.status,
                article: state=> state.article.data,
                articleCategories: state=> state.article.data.categorySelected,
                article_status: state=> parseInt(state.article.data.is_published) === 1 ? 'Published' : 'Draft'
            })
        },
        created() {
            this.alert.message = ''  
        },
        mounted() {
            this.getArticle(this.param)
        },
        methods: {
            ...mapActions('article', {
                getArticle: 'detail'
            }),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
        },
        setup() {
            useMeta({
                title: SITE_TITLE
            })
        },
        watch: {
            $route (to, from){
                // clear alert on location change
                this.clearAlert();
            }
        },
    }
</script>