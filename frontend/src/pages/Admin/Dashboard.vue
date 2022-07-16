<template>
    <Layout>
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
             <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Summary</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-start">
                                <i class="fa fa-clipboard fa-4x"></i>
                            </div>
                            <div class="float-end">
                                <h1>{{ dashboard.total_article }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <router-link to="/admin/article/list" class="small text-white stretched-link">
                            View Article
                        </router-link>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-start">
                                <i class="fa fa-users fa-4x"></i>
                            </div>
                            <div class="float-end">
                                 <h1>{{ dashboard.total_user }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                         <router-link to="/admin/user/list" class="small text-white stretched-link">
                            View User
                        </router-link>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-start">
                                <i class="fa fa-address-card fa-4x"></i>
                            </div>
                            <div class="float-end">
                                <h1>{{ dashboard.total_project }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <router-link to="/admin/project/list" class="small text-white stretched-link">
                            View Project
                        </router-link>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-start">
                                <i class="fa fa-phone-square-alt fa-4x"></i>
                            </div>
                            <div class="float-end">
                                <h1>{{ dashboard.total_contact }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                         <router-link to="/admin/contact/list" class="small text-white stretched-link">
                            View Contact
                        </router-link>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6" v-if="pieChart">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-chart-pie me-1"></i>
                        Project By Category
                    </div>
                    <div class="card-body"><PieChart :height="383" :dataChart="pieChart" /></div>
                </div>
            </div>
            <div class="col-xl-6" v-if="barChart">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-chart-bar me-1"></i>
                        Article on this year
                    </div>
                    <div class="card-body"><BarChart :height="200" :dataChart="barChart"  /></div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-users me-1"></i>
                Message From Guest
            </div>
            <div class="card-body">
               <table class="table table-striped" id="table-message-dashboard" @click="onClick">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Created At</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </Layout>
</template>
<script>

    import Layout from "../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import BarChart from '../../components/Charts/BarChart.vue'
    import PieChart from '../../components/Charts/PieChart.vue'
    import helper from '../../helpers/index'
    import { mapState, mapActions } from 'vuex'

    export default {
        name: "Dashboard",
        components: {
            Layout,
            BarChart,
            PieChart
        },
        computed: {
            ...mapState({
                dashboard: state=> state.dashboard.data,
                barChart: state=> state.dashboard.data.bar_chart,
                pieChart: state=> state.dashboard.data.pie_chart
            })
        },
        mounted() {
            this.showDataTable()
            this.getDashboard()
        },
        methods: {
            ...mapActions('dashboard', {
                getDashboard: 'detail'
            }),
            showDataTable: function(){
                let element = "#table-message-dashboard";
                let url = `${process.env.VUE_APP_SERVICE}/main/messages/list`;
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
                        data: 'full_name',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'phone',
                    },
                    {
                        data: 'message',
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
                        this.$router.push({ path: '/admin/message/detail/'+id});
                    }
                }
            }
        },
        setup() {
            useMeta({
                title: 'Dashboard'
            })
        }
    }
</script>