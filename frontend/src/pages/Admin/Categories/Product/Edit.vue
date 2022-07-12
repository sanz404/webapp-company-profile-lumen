<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Categories</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/categories/product/list">{{ title }}</router-link></li>
            <li class="breadcrumb-item active">Edit</li>
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
                        <label  class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" v-model="categoryProduct.name"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.categoryProduct.name.$error }">
                            <span v-if="v$.categoryProduct.name.$error" class="invalid-feedback"> {{ v$.categoryProduct.name.$errors[0].$message }} </span>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" v-model="categoryProduct.description" rows="6" :disabled="status.sendRequest"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/categories/product/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
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

    import Layout from "../../../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import useValidate from '@vuelidate/core'
    import { required, email } from '@vuelidate/validators'

    const SITE_TITLE = "Category Product";

    export default {
        name: "EditCategoryProduct",
        components: {
            Layout
        },
        props: ['param'],
        data(){
            return {
                title: SITE_TITLE,
                submitted: false,
                v$: useValidate()
            }
        },
        setup() {
            useMeta({
                title: SITE_TITLE
            })
        },
         computed: {
            ...mapState('categoryProduct', ['status']),
            ...mapState({
                alert: state => state.alert,
                status: state=> state.categoryProduct.status,
                categoryProduct: state=> state.categoryProduct.data
            })
        },
        created() { 
           this.alert.message = ''
        },
        mounted() {
            this.getDataById(this.param)
        },
        methods: {
            ...mapActions('categoryProduct', {
                getDataById: 'detail',
                updateData: 'update'
            }),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.$validate()
                if (!this.v$.categoryProduct.$error) {
                    const { categoryProduct, param } = this;
                    this.updateData({ categoryProduct, param })
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
                categoryProduct: {
                    name: { required }
                }
            }
        },
    }
</script>