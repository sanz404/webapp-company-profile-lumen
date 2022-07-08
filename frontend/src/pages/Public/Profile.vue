<template>
    <Layout>
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5 d-flex justify-content-center">
                    <div class="col-md-12 mt-4">
                        <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
                            <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-edit"></i>&nbsp;Please fill in the form below
                            </div>
                            <div class="card-body p-3">
                                <form class="row g-3" autocomplete="off" @submit.prevent="handleSubmit">
                                    <div class="col-md-4">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" v-model="username" name="username"  class="form-control" :disabled="status.sendRequest"  :class="{ 'is-invalid': submitted && !username }">
                                        <span v-if="v$.username.$error" class="invalid-feedback"> {{ v$.username.$errors[0].$message }} </span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputEmail4" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" v-model="email" name="email"  class="form-control" :disabled="status.sendRequest"  :class="{ 'is-invalid': submitted && !email }">
                                        <span v-if="v$.email.$error" class="invalid-feedback"> {{ v$.email.$errors[0].$message }} </span>
                                    </div>
                                      <div class="col-md-4">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" v-model="phone" name="phone"  class="form-control" :disabled="status.sendRequest"  :class="{ 'is-invalid': submitted && !phone }">
                                    </div>
                                    <div class="col-6">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" rows="2" v-model="address1" :disabled="status.sendRequest" ></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="inputAddress2" class="form-label">Address 2</label>
                                       <textarea class="form-control" rows="2" v-model="address2" :disabled="status.sendRequest" ></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">City</label>
                                        <input type="text" class="form-control" v-model="city" :disabled="status.sendRequest" >
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputState" class="form-label">State</label>
                                        <v-select :options="stateOptions" v-model="stateSelected"></v-select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputZip" class="form-label">Zip</label>
                                        <input type="text" class="form-control" v-model="zip_code" :disabled="status.sendRequest" >
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success w-25" data-bs-toggle="tooltip" data-bs-placement="top" title="Update My Profile">
                                            <template v-if="status.sendRequest === true">
                                                <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                                            </template>
                                            <template v-else>
                                                <i class="fa fa-save"></i>&nbsp;Update Profile
                                            </template>
                                        </button>
                                        &nbsp;
                                        <button type="reset" class="btn btn-warning text-white w-25" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Form"><i class="fa fa-refresh"></i>&nbsp;Reset Form</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="fixed-bottom">
            <Footer />
        </div>
    </Layout>
</template>
<script>
     
    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import useValidate from '@vuelidate/core'
    import { required, minLength, email } from '@vuelidate/validators'

    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"
    export default {
        name: "My Profile",
        components: {
            Footer,
            Layout
        },
        data(){
            return {
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
                zip_code:"",
                myValue: '',
                myOptions: ['op1', 'op2', 'op3']
            }
        },
        setup() {
            useMeta({
                title: 'My Profile'
            })
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