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
                                    <div class="mb-3">
                                        <label for="credential" class="form-label">Username Or Email<span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">
                                                <i class="fas fa-user-plus"></i>
                                            </span>
                                            <input type="text" v-model="username" name="username"  class="form-control"  :class="{ 'is-invalid': submitted && v$.username.$error }" :disabled="status.loggingIn">
                                            <span v-if="v$.username.$error" class="invalid-feedback"> {{ v$.username.$errors[0].$message }} </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text button-password" v-if="showPassword" @click="toggleShow">
                                               <i class="fas fa-eye"></i>
                                            </span>
                                            <span class="input-group-text button-password" v-else @click="toggleShow">
                                               <i class="fas fa-eye-slash"></i>
                                            </span>
                                            <template v-if="showPassword">
                                                <input type="text" v-model="password" name="password"  class="form-control"  :class="{ 'is-invalid': submitted && v$.password.$error }" :disabled="status.loggingIn">
                                            </template>
                                            <template v-else>
                                                <input type="password" v-model="password" name="password"  class="form-control"  :class="{ 'is-invalid': submitted && v$.password.$error }" :disabled="status.loggingIn">
                                            </template>
                                            <span v-if="v$.password.$error" class="invalid-feedback"> {{ v$.password.$errors[0].$message }} </span>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" name="remember_me" v-model="remember_me" id="remember_me" :disabled="status.loggingIn">
                                        <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Sign In" :disabled="status.loggingIn">
                                        <template v-if="status.loggingIn === true">
                                            <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                                        </template>
                                        <template v-else>
                                             <i class="fas fa-sign-in"></i>&nbsp;Sign In
                                        </template>
                                    </button>
                                </form>
                                <div class="text-center">
                                    <router-link to="/auth/email/forgot" class="nav-link">Forgot Password ?</router-link>
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
    import { required, minLength } from '@vuelidate/validators'

    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"

    export default {
        name: "Login",
        components: {
            Footer,
            Layout
        },
        data(){
            return {
                v$: useValidate(),
                username: '',
                password: '',
                remember_me: false,
                submitted: false,
                showPassword: false
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
        methods: {
            toggleShow() {
                this.showPassword = !this.showPassword;
            },
            ...mapActions('auth', ['login', 'logged']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
             handleSubmit(e) {
                this.submitted = true;
                const {
                    username,
                    password,
                    remember_me
                } = this;
                this.v$.$validate()
                if (!this.v$.$error) {
                    this.login({
                        username,
                        password,
                        remember_me
                    })
                }
            }
        },
        setup() {
            useMeta({
                title: 'Login'
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
                username: { required },
                password: { required, minLength: minLength(6) },
            }
        },
    }
</script>