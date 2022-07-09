<template>
   <Layout>
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5 d-flex justify-content-center">
                    <div class="col-md-4 mt-4">
                        <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
                            <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
                        </div>
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-header bg-primary text-white text-center">
                                <i class="fas fa-edit"></i>&nbsp;Please fill in the form below
                            </div>
                            <div class="card-body p-3">
                                <form autocomplete="off" @submit.prevent="handleSubmit">
                                    <div class="alert alert-primary">
                                        We can help reset your password using email address associated with your account.
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" v-model="email" name="email"  class="form-control"  :class="{ 'is-invalid': submitted && v$.email.$error }" :disabled="status.sendRequest">
                                            <span v-if="v$.email.$error" class="invalid-feedback"> {{ v$.email.$errors[0].$message }} </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Password Reset Link" :disabled="status.sendRequest">
                                        <template v-if="status.sendRequest === true">
                                            <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                                        </template>
                                        <template v-else>
                                            <i class="fas fa-envelope"></i>&nbsp;Send Password Reset Link
                                        </template>
                                    </button>
                                </form>
                                <div class="text-center">
                                    <router-link to="/auth/login" class="nav-link">Change your mind ? Sign In</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="fixed-bottom">
            <Footer/>
        </div>
   </Layout>
</template>
<script>

    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import useValidate from '@vuelidate/core'
    import { required, email, minLength } from '@vuelidate/validators'
    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"
    export default {
        name: "ForgotPassword",
        components: {
            Footer,
            Layout
        },
        data(){
            return {
                v$: useValidate(),
                email:"",
                submitted: false,
            }
        },
        computed: {
            ...mapState('auth', ['status']),
            ...mapState({
                alert: state => state.alert
            })
        },
        created() {
           this.logged();
           this.alert.message = ''
        },
        setup() {
            useMeta({
                title: 'Forgot Password'
            })
        },
        methods: {
            ...mapActions('auth', ['forgot_password',  'logged']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.v$.$validate()
                this.submitted = true;
                this.alert.message = ''
                this.v$.$validate()
                if (!this.v$.$error) {
                     this.forgot_password(this.email)
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
                email: { required, email, minLength: minLength(8) }
            }
        },
    }
</script>