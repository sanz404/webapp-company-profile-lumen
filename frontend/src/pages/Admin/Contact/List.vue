<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Reference</a></li>
            <li class="breadcrumb-item active">{{ title }}</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h6><i class="fas fa-table"></i>&nbsp;List {{ title }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="clearfix mb-4">
                        <router-link to="/admin/contact/create" data-bs-toggle="tooltip" data-bs-placement="top" title="Create New" class="btn btn-success float-end">
                            <i class="fas fa-plus"></i>&nbsp;Create New
                        </router-link>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Website</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in contacts" :key="item.id">
                                <td>{{ parseInt(index) + 1 }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.phone }}</td>
                                <td>{{ item.website }}</td>
                                <td class="text-center">
                                    <router-link :to='"/admin/contact/detail/"+item.id' data-bs-toggle="tooltip" data-bs-placement="top" title="View" class="btn btn-sm btn-primary">
                                        <i class="fas fa-search"></i>
                                    </router-link>
                                    &nbsp;
                                    <router-link :to='"/admin/contact/edit/"+item.id' data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-pencil"></i>
                                    </router-link>
                                    &nbsp;
                                    <router-link :to='"/admin/contact/delete/"+item.id' data-bs-toggle="tooltip" data-bs-placement="top" title="Dalete" @click="showAlert" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>
<script>

    import Layout from "../../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'

    const SITE_TITLE = "Contact";

    export default {
        name: "ListContact",
        components: {
            Layout
        },
        data(){
            return {
                title: SITE_TITLE,
                contacts: this.getContacts()
            }
        },
        methods:{
            getContacts: function(){
                let items = [];
                let i
                for(i = 0; i < 100; i++){
                    items[i] = {
                        id:i,
                        name: "dummy"+i,
                        email: "dummy"+i,
                        phone: "dummy"+i,
                        website: "dummy"+i
                    }
                }
                return items;
            },
            showAlert: function(){
                this.$swal('Hello Vue world!!!');
            }
        },
        setup() {
            useMeta({
                title: SITE_TITLE
            })
        }
    }
</script>