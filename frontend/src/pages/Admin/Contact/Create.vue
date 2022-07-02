<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Reference</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/contact/list">{{ title }}</router-link></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
        <form autocomplete="off">
             <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6><i class="fas fa-edit"></i>&nbsp;Please fill in the form below</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Phone <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="website" class="form-control" >
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Address <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="6"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/contact/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>&nbsp;Back To List
                        </router-link>
                        &nbsp;
                        <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Save From"><i class="fa fa-save"></i>&nbsp;Save Change</button>
                    </div>
                    <div class="float-end">
                        <button type="reset" class="btn btn-warning text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Form"><i class="fa fa-refresh"></i>&nbsp;Reset Form</button>
                    </div>
                </div>
            </div>
        </form>
    </Layout>
</template>
<script>

    import Layout from "../../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'

    const SITE_TITLE = "Contact";

    export default {
        name: "CreteContact",
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