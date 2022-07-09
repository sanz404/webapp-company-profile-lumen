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
                        <label  class="col-sm-2 col-form-label">Current Password <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" v-model="password_old"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.password_old.$error }">
                            <span v-if="v$.password_old.$error" class="invalid-feedback"> {{ v$.password_old.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">New Password <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" v-model="password" name="password"  class="form-control" :disabled="status.sendRequest"  :class="{ 'is-invalid': submitted && v$.password.$error }">
                            <span v-if="v$.password.$error" class="invalid-feedback"> {{ v$.password.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">New Password Confirmation <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" v-model="passwordConfirm" name="password_confirm"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.passwordConfirm.$error }">
                            <span v-if="v$.passwordConfirm.$error" class="invalid-feedback"> {{ v$.passwordConfirm.$errors[0].$message }} </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-success float-start" data-bs-toggle="tooltip" data-bs-placement="top" title="Save From" :disabled="status.sendRequest">
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
    import { required, minLength, sameAs } from '@vuelidate/validators'

    const SITE_TITLE = "Change Password";

    export default {
        name: "ChangePassword",
        components: {
            Layout
        },
        data(){
            return {
                v$: useValidate(),
                title: SITE_TITLE,
                password_old:"",
                password:"",
                passwordConfirm:"",
                submitted: false
            }
        },
        computed: {
            ...mapState('account', ['status']),
            ...mapState({
                alert: state => state.alert
            })
        },
        created() { 
           this.alert.message = ''
        },
        methods: {
            ...mapActions('account', ['updatePassword']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.$validate()
                if (!this.v$.$error) {
                    let data = {
                        password_old: this.password_old,
                        password: this.password,
                        password_confirm: this.passwordConfirm
                    }
                    this.updatePassword(data)
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
                password_old: { required },
                password: { required, minLength: minLength(8) },
                passwordConfirm: { required, sameAs: sameAs(this.password) }
            }
        },
    }
</script>