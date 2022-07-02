<template>
    <Layout>
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5 d-flex justify-content-center">
                    <div class="col-md-12 mt-4">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-edit"></i>&nbsp;Please fill in the form below
                            </div>
                            <div class="card-body p-3">
                                <form class="row g-3" autocomplete="off">
                                    <div class="col-md-4">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="username">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputEmail4" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" v-model="email">
                                    </div>
                                      <div class="col-md-4">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" v-model="phone">
                                    </div>
                                    <div class="col-6">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" rows="2" v-model="address1"></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="inputAddress2" class="form-label">Address 2</label>
                                       <textarea class="form-control" rows="2" v-model="address2"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">City</label>
                                        <input type="text" class="form-control" v-model="city">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputState" class="form-label">State</label>
                                        <select v-model="stateSelected" class="form-select">
                                            <option selected disabled>Choose State...</option>
                                            <option  v-for="(item) in stateOptions" :key="item.id">
                                                {{ item.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputZip" class="form-label">Zip</label>
                                        <input type="text" class="form-control" v-model="zip_code">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success w-25" data-bs-toggle="tooltip" data-bs-placement="top" title="Update My Profile"><i class="fa fa-save"></i>&nbsp;Update Profile</button>
                                        &nbsp;
                                        <button type="reset" class="btn btn-warning text-white w-25" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Form"><i class="fa fa-refresh"></i>&nbsp;Reset Form</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="fixed-bottom">
            <Footer />
        </div>
    </Layout>
</template>
<script>
    import { useMeta } from 'vue-meta'
    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"
    export default {
        name: "My Profile",
        components: {
            Footer,
            Layout
        },
        data(){
            return {
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
                title: 'My Profile'
            })
        },
    }
</script>