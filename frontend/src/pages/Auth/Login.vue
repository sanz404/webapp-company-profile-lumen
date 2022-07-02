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
                                    <div class="mb-3">
                                        <label for="credential" class="form-label">Username Or Email<span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">
                                                <i class="fas fa-user-plus"></i>
                                            </span>
                                            <input type="text" v-model="credential" class="form-control is-invalid">
                                            <small class="invalid-feedback">
                                                Invalid feed back
                                            </small>
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
                                                <input type="text" v-model="password"  class="form-control is-invalid">
                                            </template>
                                            <template v-else>
                                                <input type="password" v-model="password"  class="form-control is-invalid">
                                            </template>
                                            <small class="invalid-feedback">
                                                Invalid feed back
                                            </small>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Sign In">
                                        <i class="fas fa-sign-in"></i>&nbsp;Sign In
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
    import {
        useMeta
    } from 'vue-meta'
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
                showPassword: false,
                credential:"",
                password:""
            }
        },
        methods: {
            toggleShow() {
                this.showPassword = !this.showPassword;
            }
        },
        setup() {
            useMeta({
                title: 'Login'
            })
        },
    }
</script>