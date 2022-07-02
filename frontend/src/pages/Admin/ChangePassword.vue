<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Account</a></li>
            <li class="breadcrumb-item active">{{ title }}</li>
        </ol>
        <form autocomplete="off">
             <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6><i class="fas fa-edit"></i>&nbsp;Please fill in the form below</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Current Password <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">New Password <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">New Password Confirmation <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-success float-start" data-bs-toggle="tooltip" data-bs-placement="top" title="Save From"><i class="fa fa-save"></i>&nbsp;Save Change</button>
                    <button type="reset" class="btn btn-warning text-white float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Form"><i class="fa fa-refresh"></i>&nbsp;Reset Form</button>
                </div>
            </div>
        </form>
    </Layout>
</template>
<script>

    import Layout from "../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'

    const SITE_TITLE = "Change Password";

    export default {
        name: "ChangePassword",
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