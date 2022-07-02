<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Account</a></li>
            <li class="breadcrumb-item active">{{ title }}</li>
        </ol>
        <form>
             <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6><i class="fas fa-edit"></i>&nbsp;Please fill in the form below</h6>
                </div>
                <div class="card-body">
                   <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                       <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                       <div class="col-sm-10">
                            <input type="email" class="form-control">
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Phone Number </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">City </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Zip Code </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">State </label>
                        <div class="col-sm-10">
                            <select v-model="stateSelected" class="form-select">
                                <option selected disabled>Choose State...</option>
                                <option  v-for="(item) in stateOptions" :key="item.id">
                                    {{ item.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Adderss 1 </label>
                       <div class="col-sm-10">
                            <textarea class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Adderss 2 </label>
                       <div class="col-sm-10">
                            <textarea class="form-control" rows="4"></textarea>
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

    const SITE_TITLE = "My Profile";

    export default {
        name: "Profile",
        components: {
            Layout
        },
        data(){
            return {
                title: SITE_TITLE,
                username:"",
                email:"",
                phone:"",
                address1:"",
                address2:"",
                city:"",
                stateSelected:"",
                stateOptions: [
                     {
                        name: "Indonesia",
                        id: "ID"
                    },
                    {
                        name: "Malaysia",
                        id: "ML"
                    },
                    {
                        name: "Singapore",
                        id: "SG"
                    },
                    {
                        name: "Vietnam",
                        id: "VT"
                    },
                    {
                        name: "Thailand",
                        id: "TH"
                    }
                ],
                zip_code:""
            }
        },
        setup() {
            useMeta({
                title: SITE_TITLE
            })
        }
    }
</script>