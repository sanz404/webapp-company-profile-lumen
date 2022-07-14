<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Reference</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/feature/list">{{ title }}</router-link></li>
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
                        <label  class="col-sm-2 col-form-label">Title <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" v-model="feature.title"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.feature.title.$error }">
                            <span v-if="v$.feature.title.$error" class="invalid-feedback"> {{ v$.feature.title.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Icon <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                             <v-select :options="fonts" v-model="feature.iconSelected" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.feature.iconSelected }"></v-select>
                             <span v-if="v$.feature.iconSelected.$error" class="invalid-feedback"> {{ v$.feature.iconSelected.$errors[0].$message }} </span>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Description </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" v-model="feature.description" rows="6" :disabled="status.sendRequest" ></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="1" v-model="feature.is_published">
                                <label class="form-check-label" for="inlineRadio1">Published</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="0" v-model="feature.is_published">
                                <label class="form-check-label text-nowrap" for="inlineRadio2">Draft</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/feature/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
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

    const SITE_TITLE = "Feature";

    export default {
        name: "CreateFeature",
        components: {
            Layout
        },
        data(){
            return {
                title: SITE_TITLE,
                submitted: false,
                v$: useValidate(),
                feature:{
                    icon: "",
                    title: "",
                    description: "",
                    is_published: 0,
                    iconSelected: { code: "", label: "" }
                }
            }
        },
        mounted() {
            this.font()
        },
        computed: {
            ...mapState('feature', ['status']),
            ...mapState({
                alert: state => state.alert,
                fonts: state=> state.feature.fonts,
            })
        },
        created() { 
           this.alert.message = ''
        },
        methods: {
            ...mapActions('feature', ['create', 'font']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.feature.$validate()
                if (!this.v$.feature.$error) {
                    if(this.feature.iconSelected){
                        this.feature.icon = this.feature.iconSelected.code
                    }
                    this.create(this.feature)
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
                feature: {
                    title: { required },
                    iconSelected: { required }
                }
            }
        },
    }
</script>