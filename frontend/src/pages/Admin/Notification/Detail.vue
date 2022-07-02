<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Account</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/notification/list">{{ title }}</router-link></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
        <form autocomplete="off">
             <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6><i class="fas fa-search"></i>&nbsp;Detail of {{ title }}</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Created Date </label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" value="XXX" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Subject </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" value="XXX" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Sort Message </label>
                        <div class="col-sm-10">
                           <input type="text" readonly class="form-control-plaintext" value="XXX" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Full Message</label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" value="XXX" />
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Status </label>
                        <div class="col-sm-10">
                             <input type="text" readonly class="form-control-plaintext" value="XXX" />
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/notification/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
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

    const SITE_TITLE = "Notification";

    export default {
        name: "DetailNotification",
        components: {
            Layout
        },
        data(){
            return {
                title: SITE_TITLE
            }
        },
        setup() {
            useMeta({
                title: SITE_TITLE
            })
        }
    }
</script>