<template>
    <Layout>
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Summary</li>
        </ol>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Primary Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Warning Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Success Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Danger Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-chart-pie me-1"></i>
                        Pie Chart Example
                    </div>
                    <div class="card-body"><PieChart :height="383" /></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-chart-bar me-1"></i>
                        Bar Chart Example
                    </div>
                    <div class="card-body"><BarChart :height="200"  /></div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-table me-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Website</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in contacts" :key="item.id">
                                <td>{{ parseInt(index) + 1 }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.phone }}</td>
                                <td>{{ item.website }}</td>
                                <td>{{ item.website }}</td>
                            </tr>
                        </tbody>
                    </table>  
                </div>
            </div>
        </div>

    </Layout>
</template>
<script>

    import Layout from "../../components/Admin/Layout.vue"
    import { useMeta } from 'vue-meta'
    import BarChart from '../../components/Charts/BarChart.vue'
    import PieChart from '../../components/Charts/PieChart.vue'

    export default {
        name: "Dashboard",
        components: {
            Layout,
            BarChart,
            PieChart
        },
        data(){
            return {
                contacts: this.getContacts()
            }
        },
        methods: {
             getContacts: function(){
                let items = [];
                let i
                for(i = 0; i < 50; i++){
                    items[i] = {
                        id:i,
                        name: "dummy"+i,
                        email: "dummy"+i,
                        phone: "dummy"+i,
                        website: "dummy"+i
                    }
                }
                return items;
            }
        },
        setup() {
            useMeta({
                title: 'Dashboard'
            })
        }
    }
</script>