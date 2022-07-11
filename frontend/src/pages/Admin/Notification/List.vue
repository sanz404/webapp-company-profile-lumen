<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Account</a></li>
            <li class="breadcrumb-item active">{{ title }}</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h6><i class="fas fa-table"></i>&nbsp;List {{ title }}</h6>
            </div>
            <div class="card-body">
                 <table class="table table-striped" id="table-notification" @click="onClick">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Created At</th>
                            <th>Subject</th>
                            <th>Sort Message</th>
                            <th>Status</th>
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
    import { mapState, mapActions } from 'vuex'
    import helper from '../../../helpers/index'

    const SITE_TITLE = "Notification";

    export default {
        name: "ListNotification",
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
        },
        computed: {
            ...mapState('notification', ['status']),
            ...mapState({
                alert: state => state.alert
            })
        },
        created() { 
           this.alert.message = ''
        },
        mounted() {
            this.showDataTable();
        },
        methods:{
            ...mapActions('notification', ['delete']),
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
                let element = "#table-notification";
                let url = `${process.env.VUE_APP_SERVICE}/account/notifications/list`;
                let  columns = [
                    {
                        "data": "id",
                        "orderable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'subject',
                    },
                    {
                        data: 'sort_content',
                    },
                    {
                        data: 'readed_at',
                        render: function (data, type, row, meta) {
                            if(data){
                                return `<span class="badge bg-success">Readed</span>`;
                            }else{
                                return `<span class="badge bg-warning">Unread</span>`;
                            }
                        }
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
                        this.$router.push({ path: '/admin/notification/detail/'+id});
                    }
                    if (e.target.classList.contains('btn-delete')) {
                        this.deleteConfirm(id)
                    }
                }
            }
        }
    }
</script>