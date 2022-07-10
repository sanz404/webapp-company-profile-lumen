<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Reference</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/contact/list">{{ title }}</router-link></li>
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
                            <input type="text" v-model="contact.name"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.contact.name.$error }">
                            <span v-if="v$.contact.name.$error" class="invalid-feedback"> {{ v$.contact.name.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" v-model="contact.email"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.contact.email.$error }">
                            <span v-if="v$.contact.email.$error" class="invalid-feedback"> {{ v$.contact.email.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Phone <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" v-model="contact.phone"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.contact.phone.$error }">
                            <span v-if="v$.contact.phone.$error" class="invalid-feedback"> {{ v$.contact.phone.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                             <input type="text"  v-model="contact.website"  class="form-control" :disabled="status.sendRequest" />
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Address <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" v-model="contact.address" rows="6" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.contact.address.$error }"></textarea>
                            <span v-if="v$.contact.address.$error" class="invalid-feedback"> {{ v$.contact.address.$errors[0].$message }} </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/contact/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
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
    import { required, email } from '@vuelidate/validators'

    const SITE_TITLE = "Contact";

    export default {
        name: "EditContact",
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
            ...mapState('contact', ['status']),
            ...mapState({
                alert: state => state.alert,
                status: state=> state.contact.status,
                contact: state=> state.contact.data
            })
        },
        created() { 
           this.alert.message = ''
        },
        mounted() {
            this.getContact(this.param)
        },
        methods: {
            ...mapActions('contact', {
                getContact: 'detail',
                updateContact: 'update'
            }),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.$validate()
                if (!this.v$.contact.$error) {
                    const { contact, param } = this;
                    this.updateContact({ contact, param })
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
                contact: {
                    name: { required },
                    email: { required, email },
                    phone: { required },
                    address: { required },
                }
            }
        },
    }
</script>