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
                            <input type="text" v-model="username" name="username"  class="form-control" :disabled="status.sendRequest"  :class="{ 'is-invalid': submitted && !username }">
                            <span v-if="v$.username.$error" class="invalid-feedback"> {{ v$.username.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                       <label  class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                       <div class="col-sm-10">
                            <input type="email" v-model="email" name="email"  class="form-control" :disabled="status.sendRequest"  :class="{ 'is-invalid': submitted && !email }">
                            <span v-if="v$.email.$error" class="invalid-feedback"> {{ v$.email.$errors[0].$message }} </span>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Phone Number </label>
                        <div class="col-sm-10">
                            <input type="text" v-model="phone" name="phone"  class="form-control" :disabled="status.sendRequest"  :class="{ 'is-invalid': submitted && !phone }">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">City </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="city" :disabled="status.sendRequest" >
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Zip Code </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="zip_code" :disabled="status.sendRequest" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">State </label>
                        <div class="col-sm-10">
                            <v-select :options="stateOptions" v-model="stateSelected"></v-select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Adderss 1 </label>
                       <div class="col-sm-10">
                            <textarea class="form-control" rows="4" v-model="address1" :disabled="status.sendRequest" ></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Adderss 2 </label>
                       <div class="col-sm-10">
                            <textarea class="form-control" rows="4" v-model="address2" :disabled="status.sendRequest" ></textarea>
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
                username:"",
                email:"",
                phone:"",
                address1:"",
                address2:"",
                city:"",
                stateSelected: { label: "", code: "" },
                stateOptions:[],
                zip_code:""
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
            this.loadData()
        },
        created() { 
            this.alert.message = ''
            this.username = this.profile.username
            this.email = this.profile.email
            this.phone = this.profile.phone
            this.address1 = this.profile.address1
            this.address2 = this.profile.address2
            this.city = this.profile.city
            this.stateOptions = this.countries
            this.zip_code = this.profile.zip_code

            let country = this.stateOptions.find(o => o.code === this.profile.country_id)
            if(country){
                this.stateSelected =  { label: country.label, code: country.code }
            }

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
                    let formData = {
                        username: this.username,
                        email: this.email,
                        phone: this.phone,
                        address1: this.address1,
                        address2: this.address2,
                        city: this.city,
                        zip_code:this.zip_code,
                        country_id: this.stateSelected.code
                    }
                    this.updateProfile(formData)
                    this.loadData()
                }
            },
            loadData(){
                this.getCountries()
                this.getProfile()
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
                username: { required, minLength: minLength(8) },
                email: { required, minLength: minLength(8), email },
            }
        },
    }
</script>