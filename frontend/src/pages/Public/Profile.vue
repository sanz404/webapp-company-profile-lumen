<template>
    <Layout>
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5 d-flex justify-content-center">
                    <div class="col-md-12 mt-4">
                        <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
                            <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
                        </div>
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-edit"></i>&nbsp;Please fill in the form below
                            </div>
                            <div class="card-body p-3">
                                <form class="row g-3" autocomplete="off" @submit.prevent="handleSubmit">
                                    <div class="col-md-4">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" v-model="profile.username"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.profile.username.$error }">
                                        <span v-if="v$.profile.username.$error" class="invalid-feedback"> {{ v$.profile.username.$errors[0].$message }} </span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputEmail4" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" v-model="profile.email"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.profile.email.$error }">
                                        <span v-if="v$.profile.email.$error" class="invalid-feedback"> {{ v$.profile.email.$errors[0].$message }} </span>
                                    </div>
                                      <div class="col-md-4">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" v-model="profile.phone"  class="form-control" :disabled="status.sendRequest">
                                    </div>
                                    <div class="col-6">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" v-model="profile.address1" rows="2" :disabled="status.sendRequest"></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="inputAddress2" class="form-label">Address 2</label>
                                       <textarea class="form-control" v-model="profile.address2" rows="2" :disabled="status.sendRequest"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">City</label>
                                        <input type="text" v-model="profile.city"  class="form-control" :disabled="status.sendRequest">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputState" class="form-label">State</label>
                                        <v-select :options="countries" v-model="profile.countrySelected"></v-select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputZip" class="form-label">Zip</label>
                                         <input type="text" v-model="profile.zip_code"  class="form-control" :disabled="status.sendRequest">
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
                submitted: false
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
            },
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