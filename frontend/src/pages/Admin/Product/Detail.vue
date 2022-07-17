<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Reference</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/product/list">{{ title }}</router-link></li>
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
                             <template v-if="product.image">
                                <img :src="this.backendURL+'/uploads/'+product.image" class="img-thumbnail" width="400" />
                            </template>
                            <template v-else>
                                 <img :src="'/images/no-image.png'" class="img-thumbnail" width="400" />
                            </template>
                        </div>
                    </div>
                    <template v-if="product.category">
                        <div class="row mb-3">
                            <label  class="col-sm-2 col-form-label">Category </label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" v-model="product.category.name" />
                            </div>
                        </div>
                    </template>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Name </label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" v-model="product.name" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Price </label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" v-model="product.price" />
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Description </label>
                        <div class="col-sm-10">
                            <ckeditor :editor="editor" v-model="product.description" :disabled="true" :config="editorConfig"></ckeditor>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="product_status"  />
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/product/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
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

    const SITE_TITLE = "Product";

    export default {
        name: "DetailProduct",
        components: {
            Layout
        },
        props: ['param'],
        data(){
            return {
                title: SITE_TITLE,
                backendURL: process.env.VUE_APP_SERVICE,
                editor: ClassicEditor,
                editorConfig: { },
            }
        },
        computed: {
            ...mapState({
                alert: state => state.alert,
                status: state=> state.product.status,
                product: state=> state.product.data,
                product_status: state=> parseInt(state.product.data.is_published) === 1 ? 'Published' : 'Draft'
            })
        },
        created() {
            this.alert.message = ''  
        },
        mounted() {
            this.getDataById(this.param)
        },
        methods: {
            ...mapActions('product', {
                getDataById: 'detail'
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