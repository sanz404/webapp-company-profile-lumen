<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Account</a></li>
            <li class="breadcrumb-item active">{{ title }}</li>
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
                          <input type="text" v-model="profile.username"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.profile.username.$error }">
                          <span v-if="v$.profile.username.$error" class="invalid-feedback"> {{ v$.profile.username.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                       <label  class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                       <div class="col-sm-10">
                          <input type="email" v-model="profile.email"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.profile.email.$error }">
                          <span v-if="v$.profile.email.$error" class="invalid-feedback"> {{ v$.profile.email.$errors[0].$message }} </span>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Phone Number </label>
                        <div class="col-sm-10">
                            <input type="text" v-model="profile.phone"  class="form-control" :disabled="status.sendRequest">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">City </label>
                        <div class="col-sm-10">
                            <input type="text" v-model="profile.city"  class="form-control" :disabled="status.sendRequest">
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Zip Code </label>
                        <div class="col-sm-10">
                           <input type="text" v-model="profile.zip_code"  class="form-control" :disabled="status.sendRequest">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">State </label>
                        <div class="col-sm-10">
                            <v-select :options="countries" v-model="profile.countrySelected"></v-select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Adderss 1 </label>
                       <div class="col-sm-10">
                            <textarea class="form-control" v-model="profile.address1" rows="6" :disabled="status.sendRequest"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Adderss 2 </label>
                       <div class="col-sm-10">
                            <textarea class="form-control" v-model="profile.address2" rows="6" :disabled="status.sendRequest"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-success float-start" data-bs-toggle="tooltip" data-bs-placement="top" title="Save From">
                        <template v-if="status.sendRequest === true">
                            <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                        </template>
                        <template v-else>
                            <i class="fa fa-save"></i>&nbsp;Save Change
                        </template>
                    </button>
                    <button type="reset" class="btn btn-warning text-white float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Form"><i class="fa fa-refresh"></i>&nbsp;Reset Form</button>
                </div>
            </div>
        </form>
    </Layout>
</template>
<script>

    import Layout from "../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import useValidate from '@vuelidate/core'
    import { required, minLength, email } from '@vuelidate/validators'

    const SITE_TITLE = "My Profile";

    export default {
        name: "Profile",
        components: {
            Layout
        },
        data(){
            return {
                title: SITE_TITLE,
                v$: useValidate(),
                submitted: false,
            }
        },
        computed: {
            ...mapState({
                alert: state => state.alert,
                status: state=> state.account.status,
                profile: state=> state.account.profile,
                countries: state=> state.account.countries,
            })
        },
        mounted() {
           this.getCountries()
           this.getProfile()
        },
        created() { 
            this.alert.message = ''
        },
        methods: {
            ...mapActions('account', {
                getCountries: 'countries',
                getProfile: 'profile',
                updateProfile: 'updateProfile'
            }),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.$validate()
                if (!this.v$.$error) {
                    this.updateProfile(this.profile)
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
                profile: {
                    username: { required, minLength: minLength(8) },
                    email: { required, minLength: minLength(8), email },
                }
            }
        },
    }
</script>