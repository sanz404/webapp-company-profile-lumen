<template>
   <Layout>
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5 d-flex justify-content-center">
                    <div class="col-md-4 mt-4">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-header bg-primary text-white text-center">
                                <i class="fas fa-edit"></i>&nbsp;Please fill in the form below
                            </div>
                            <div class="card-body p-3">
                                <form autocomplete="off">
                                    <div class="alert alert-primary">
                                        We can help reset your password using email address associated with your account.
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" v-model="email" class="form-control is-invalid">
                                            <small class="invalid-feedback">
                                                Invalid feed back
                                            </small>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Password Reset Link">
                                        <i class="fas fa-envelope"></i>&nbsp;Send Password Reset Link
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
    import {
        useMeta
    } from 'vue-meta'
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
                email:"",
            }
        },
        setup() {
            useMeta({
                title: 'Forgot Password'
            })
        },
    }
</script>