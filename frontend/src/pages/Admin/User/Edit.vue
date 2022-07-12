<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Setting</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/user/list">{{ title }}</router-link></li>
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
                        <label  class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" v-model="user.username"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.user.username.$error }">
                            <span v-if="v$.user.username.$error" class="invalid-feedback"> {{ v$.user.username.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" v-model="user.email"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.user.email.$error }">
                            <span v-if="v$.user.email.$error" class="invalid-feedback"> {{ v$.user.email.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" v-model="user.password"  class="form-control" :disabled="status.sendRequest">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Phone Number </label>
                        <div class="col-sm-10">
                            <input type="text" v-model="user.phone"  class="form-control" :disabled="status.sendRequest">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">City </label>
                        <div class="col-sm-10">
                            <input type="text" v-model="user.city"  class="form-control" :disabled="status.sendRequest">
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Zip Code </label>
                        <div class="col-sm-10">
                           <input type="text" v-model="user.zip_code"  class="form-control" :disabled="status.sendRequest">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">State </label>
                        <div class="col-sm-10">
                            <v-select :options="countries" v-model="user.countrySelected"></v-select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Adderss 1 </label>
                       <div class="col-sm-10">
                            <textarea class="form-control" v-model="user.address1" rows="6" :disabled="status.sendRequest"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Adderss 2 </label>
                       <div class="col-sm-10">
                            <textarea class="form-control" v-model="user.address2" rows="6" :disabled="status.sendRequest"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/user/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
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

    const SITE_TITLE = "User";

    export default {
        name: "EditUser",
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
        computed: {
            ...mapState({
                alert: state => state.alert,
                status: state=> state.user.status,
                user: state=> state.user.data,
                countries: state=> state.account.countries,
            }),
            ...mapState({
                alert: state => state.alert
            })
        },
        created() { 
           this.alert.message = ''
        },
        mounted() {
            this.getUser(this.param)
            this.getCountries()
        },
        methods: {
            ...mapActions('user', {
                getUser: 'detail',
                updateUser: 'update'
            }),
            ...mapActions('account', {
                getCountries: 'countries'
            }),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.user.$validate()
                if (!this.v$.user.$error) {
                    const { user, param } = this;
                    this.updateUser({ user, param })
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
                user: {
                    username: { required },
                    email: { required, email }
                }
            }
        },
    }
</script>