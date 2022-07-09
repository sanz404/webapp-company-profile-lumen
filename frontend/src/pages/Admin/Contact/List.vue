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
                <div class="clearfix mb-4">
                    <router-link to="/admin/contact/create" data-bs-toggle="tooltip" data-bs-placement="top" title="Create New" class="btn btn-success float-end">
                        <i class="fas fa-plus"></i>&nbsp;Create New
                    </router-link>
                </div>
                <table class="table table-striped" id="table-contact" @click="onClick">
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
                </table>
            </div>
        </div>
    </Layout>
</template>
<script>

    import Layout from "../../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import helper from '../../../helpers/index'

    const SITE_TITLE = "Contact";

    export default {
        name: "ListContact",
        components: {
            Layout
        },
        data(){
            return {
                title: SITE_TITLE
            }
        },
        mounted() {
            this.showDataTable();
        },
        methods:{
            showAlert: function(){
                this.$swal('Hello Vue world!!!');
            },
            showDataTable: function(){
                let element = "#table-contact";
                let url = `${process.env.VUE_APP_SERVICE}/main/contacts/list`;
                let  columns = [
                    {
                        "data": "id",
                        "orderable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'phone',
                    },
                    {
                        data: 'website',
                    },
                    {
                        data: 'id',
                        "orderable": false,
                        "className": "text-center",
                        render: function (data, type, row, meta) {
                            return `
                                <button class="btn btn-sm btn-info text-white btn-view" data-id="`+row.id+`" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class='fas fa-search'></i>
                                </button>
                                <button class="btn btn-sm btn-warning text-white btn-edit" data-id="`+row.id+`" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class='fas fa-edit'></i>
                                </button>
                                <button class="btn btn-sm btn-danger text-white btn-delete" data-id="`+row.id+`" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class='fas fa-trash'></i>
                                </button>
                            `;
                        }
                    },
                ]
                helper.setDataTable(url, columns, element);
            },
            onClick(e) {
                if(e.target.dataset && e.target.dataset.id){
                    let id = e.target.dataset.id
                    if (e.target.classList.contains('btn-view')) {
                        this.$router.push({ path: '/admin/contact/detail/'+id});
                    }
                    if (e.target.classList.contains('btn-edit')) {
                        this.$router.push({ path: '/admin/contact/edit/'+id});
                    }
                    if (e.target.classList.contains('btn-delete')) {
                        this.showAlert()
                    }
                }
            }
        },
        setup() {
            useMeta({
                title: SITE_TITLE
            })
        }
    }
</script>