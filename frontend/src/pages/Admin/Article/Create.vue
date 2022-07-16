<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Reference</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/article/list">{{ title }}</router-link></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
         <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
            <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
        </div>
        <form autocomplete="off" @submit.prevent="handleSubmit">
             <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6><i class="fas fa-edit"></i>&nbsp;Please fill in the form below</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                           <input type="file" class="form-control" v-on:change="handleFileUpload" accept="image/*" :disabled="status.sendRequest" :class="{ 'is-invalid': file_error }" />
                           <span v-if="file_error" class="invalid-feedback"> {{ file_error_message }} </span>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Categories</label>
                        <div class="col-sm-10">
                            <v-select multiple  :options="categories" v-model="article.categorySelected" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted  }"></v-select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Title <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" v-model="article.title"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.article.title.$error }">
                            <span v-if="v$.article.title.$error" class="invalid-feedback"> {{ v$.article.title.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Content <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                           <ckeditor :editor="editor" v-model="article.content" :config="editorConfig"></ckeditor>
                           <span v-if="v$.article.content.$error" class="invalid-feedback"> {{ v$.article.content.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="1" v-model="article.is_published">
                                <label class="form-check-label" for="inlineRadio1">Published</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="0" v-model="article.is_published">
                                <label class="form-check-label text-nowrap" for="inlineRadio2">Draft</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/article/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>&nbsp;Back To List
                        </router-link>
                        &nbsp;
                        <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Save From" :disabled="status.sendRequest">
                            <template v-if="status.sendRequest === true">
                                <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                            </template>
                            <template v-else>
                                <i class="fa fa-save"></i>&nbsp;Save Change
                            </template>
                        </button>
                    </div>
                    <div class="float-end">
                        <button type="reset" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Form"><i class="fa fa-refresh"></i>&nbsp;Reset Form</button>
                    </div>
                </div>
            </div>
        </form>
    </Layout>
</template>
<script>

    import Layout from "../../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import useValidate from '@vuelidate/core'
    import { required } from '@vuelidate/validators'
    import helper from "../../../helpers/index"
    import ClassicEditor from "@ckeditor/ckeditor5-build-classic"
    

    const SITE_TITLE = "Article";

    export default {
        name: "CreteArticle",
        components: {
            Layout
        },
        data(){
            return {
                title: SITE_TITLE,
                submitted: false,
                v$: useValidate(),
                article:{
                    title: "",
                    content: "",
                    is_published: 0,
                    image: "",
                    categorySelected:[]
                },
                editor: ClassicEditor,
                editorConfig: { },
                file_error: false,
                file_error_message: ""
            }
        },
        computed: {
            ...mapState('article', ['status']),
            ...mapState({
                alert: state => state.alert,
                categories: state=> state.article.articleCategories,
            })
        },
        created() { 
           this.alert.message = ''
        },
        mounted() {
            this.getCategories()
        },
        methods: {
            ...mapActions({
                clearAlert: 'alert/clear'
            }),
            ...mapActions('article', {
                create: 'create',
                getCategories: 'categories'
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.article.$validate()
                if (!this.v$.article.$error) {
                    this.create(this.article)
                } 
            },
            handleFileUpload(e){
                if(e.target.files){
                    let files = e.target.files
                    if(files[0]){
                        let fileSelected = files[0]
                        let fileSize = fileSelected.size / 1024 / 1024;
                        if (!fileSelected.name.match(/.(jpg|jpeg|png|gif)$/i)){
                            e.target.value = ""
                            this.article.image = ""
                            this.file_error = true
                            this.file_error_message = "The file must be an image."
                        }else if(fileSize > 2){
                            e.target.value = ""
                            this.article.image = ""
                            this.file_error = true
                            this.file_error_message = "Maximum upload file size: 2MB."
                        }else{
                            this.file_error = false
                            this.file_error_message = ""
                            helper.getBase64(fileSelected).then(
                                data => this.article.image = data
                            );
                        }
                    }
                }
            }
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
        validations() {
            return {
                article: {
                    title: { required },
                    content: { required }
                }
            }
        },
    }
</script>