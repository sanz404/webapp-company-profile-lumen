<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Setting</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/user/list">{{ title }}</router-link></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
        <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
            <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
        </div>
        <form autocomplete="off">
             <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6><i class="fas fa-search"></i>&nbsp;Detail of {{ title }}</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Username </label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" v-model="user.username" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Email </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="user.email" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Phone </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="user.phone" />
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">City </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="user.city" />
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Zip Code </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="user.zip_code" />
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">State </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="user.country_name" />
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Address 1 </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="user.address1" />
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Address 2 </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="user.address2" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Status </label>
                        <div class="col-sm-10">
                           <input type="text" readonly class="form-control-plaintext" v-model="statusUser"  />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Created At</label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" v-model="user.created_at" />
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/user/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>&nbsp;Back To List
                        </router-link>
                        &nbsp;
                    </div>
                    <div class="float-end"></div>
                </div>
            </div>
        </form>
    </Layout>
</template>
<script>

    import Layout from "../../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'

    const SITE_TITLE = "User";

    export default {
        name: "DetailUser",
        components: {
            Layout
        },
        props: ['param'],
        data(){
            return {
                title: SITE_TITLE
            }
        },
        computed: {
            ...mapState({
                alert: state => state.alert,
                status: state=> state.user.status,
                user: state=> state.user.data,
                statusUser: state=> parseInt(state.user.data.status) === 1 ? 'Verified' : 'Unverified',
            })
        },
        created() {
            this.alert.message = ''  
        },
        mounted() {
            this.getUser(this.param)
        },
        methods: {
            ...mapActions('user', {
                getUser: 'detail'
            }),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
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
    }
</script>