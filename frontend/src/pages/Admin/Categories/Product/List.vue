<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Categories</a></li>
            <li class="breadcrumb-item active">{{ title }}</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h6><i class="fas fa-table"></i>&nbsp;List {{ title }}</h6>
            </div>
            <div class="card-body">
                <div class="clearfix mb-4">
                    <router-link to="/admin/categories/product/create" data-bs-toggle="tooltip" data-bs-placement="top" title="Create New" class="btn btn-success float-end">
                        <i class="fas fa-plus"></i>&nbsp;Create New
                    </router-link>
                </div>
                <table class="table table-striped" id="table-category-product" @click="onClick">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </Layout>
</template>
<script>

    import Layout from "../../../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import { mapState, mapActions } from 'vuex'
    import helper from '../../../../helpers/index'

    const SITE_TITLE = "Category Product";

    export default {
        name: "ListCategoryProduct",
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
        computed: {
            ...mapState('categoryProduct', ['status']),
            ...mapState({
                alert: state => state.alert
            })
        },
        created() { 
           this.alert.message = ''
        },
        methods:{
            ...mapActions('categoryProduct', ['delete']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            deleteConfirm: function(id){
                let app = this
                app.$swal({ 
                    title: 'Confirmation',
                    text: "Are you sure you want to delete this item ?",
                    icon: 'warning',
                    showCancelButton: !0, 
                    confirmButtonColor: "#31ce77", 
                    cancelButtonColor: "#f34943", 
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then(
                    function (t) {
                        app.delete(id)
                        setTimeout(function(){
                            app.$swal({
                                title: "Success!", 
                                text: "Your item has been deleted!", 
                                icon: "success"
                            })
                            app.showDataTable()
                        }, 500)
                    }
                );
            },
            showDataTable: function(){
                let element = "#table-category-product";
                let url = `${process.env.VUE_APP_SERVICE}/main/categories/product/list`;
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
                        data: 'description',
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
                        this.$router.push({ path: '/admin/categories/product/detail/'+id});
                    }
                    if (e.target.classList.contains('btn-edit')) {
                        this.$router.push({ path: '/admin/categories/product/edit/'+id});
                    }
                    if (e.target.classList.contains('btn-delete')) {
                        this.deleteConfirm(id)
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