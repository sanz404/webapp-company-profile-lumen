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
                                    <input type="hidden" name="token" :value="this.token" />
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address<span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" v-model="email" name="email"  class="form-control" :disabled="status.recoveryRequest"  :class="{ 'is-invalid': submitted && !email }">
                                            <span v-if="v$.email.$error" class="invalid-feedback"> {{ v$.email.$errors[0].$message }} </span>
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
                                                <input type="text" v-model="password" name="password"  class="form-control" :disabled="status.recoveryRequest"  :class="{ 'is-invalid': submitted && v$.password.$error }">
                                            </template>
                                            <template v-else>
                                                <input type="password" v-model="password" name="password"  class="form-control"  :disabled="status.recoveryRequest" :class="{ 'is-invalid': submitted && v$.password.$error }">
                                            </template>
                                            <span v-if="v$.password.$error" class="invalid-feedback"> {{ v$.password.$errors[0].$message }} </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirm" class="form-label">Password Confirmation<span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text button-password" v-if="showPasswordConfirm" @click="toggleShowConfirm">
                                               <i class="fas fa-eye"></i>
                                            </span>
                                            <span class="input-group-text button-password" v-else @click="toggleShowConfirm">
                                               <i class="fas fa-eye-slash"></i>
                                            </span>
                                            <template v-if="showPasswordConfirm">
                                                <input type="text" v-model="passwordConfirm" name="password_confirm"  class="form-control" :disabled="status.recoveryRequest" :class="{ 'is-invalid': submitted && v$.passwordConfirm.$error }">
                                            </template>
                                            <template v-else>
                                                <input type="password" v-model="passwordConfirm" name="password_confirm"  class="form-control" :disabled="status.recoveryRequest"  :class="{ 'is-invalid': submitted && v$.passwordConfirm.$error }">
                                            </template>
                                            <span v-if="v$.passwordConfirm.$error" class="invalid-feedback"> {{ v$.passwordConfirm.$errors[0].$message }} </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Sign up for an account" :disabled="status.recoveryRequest">
                                         <template v-if="status.recoveryRequest === true">
                                            <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                                        </template>
                                        <template v-else>
                                            <i class="fas fa-refresh"></i>&nbsp;Reset Password
                                        </template>
                                    </button>
                                </form>
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
    import { required, email, minLength, sameAs } from '@vuelidate/validators'

    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"
    
    export default {
        name: "ResetPassword",
        components: {
            Footer,
            Layout
        },
        props:['token'],
        data(){
            return {
                v$: useValidate(),
                showPassword: false,
                showPasswordConfirm: false,
                email:"",
                password:"",
                passwordConfirm:"",
                submitted: false
            }
        },
        computed: {
            ...mapState('auth', ['status']),
            ...mapState({
                alert: state => state.alert
            })
        },
        methods: {
            toggleShow() {
                this.showPassword = !this.showPassword;
            },
            toggleShowConfirm() {
                this.showPasswordConfirm = !this.showPasswordConfirm;
            },
            ...mapActions('auth', ['reset_password', 'logged']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.$validate()
                if (!this.v$.$error) {
                    let formUser = {
                        token: this.token,
                        email: this.email,
                        password: this.password,
                        password_confirm: this.passwordConfirm
                    }
                    this.reset_password(formUser);
                } 
            }
        },
        setup() {
            useMeta({
                title: 'Reset Password'
            })
        },
        watch: {
            $route (to, from){
                this.clearAlert();
            }
        },
        validations() {
            return {
                email: { required, email, minLength: minLength(8) },
                password: { required, minLength: minLength(8) },
                passwordConfirm: { required, sameAs: sameAs(this.password) }
            }
        },
    }
</script>