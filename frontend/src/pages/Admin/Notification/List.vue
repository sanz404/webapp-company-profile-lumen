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
                <div class="table-responsive">
                    <table class="table table-striped">
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
                        <tbody>
                            <tr v-for="(item, index) in rows" :key="item.id">
                                <td>{{ parseInt(index) + 1 }}</td>
                                <td>{{ item.created_at }}</td>
                                <td>{{ item.subject }}</td>
                                <td>{{ item.sortContent }}</td>
                                <td>
                                    <template v-if="parseInt(index) % 2 === 0">
                                       <span class="badge bg-success">Read</span>
                                    </template>
                                    <template v-else>
                                        <span class="badge bg-warning">Unread</span>
                                    </template>
                                </td>
                                <td class="text-center">
                                    <router-link :to='"/admin/notification/detail/"+item.id' data-bs-toggle="tooltip" data-bs-placement="top" title="View" class="btn btn-sm btn-primary">
                                        <i class="fas fa-search"></i>
                                    </router-link>
                                    &nbsp;
                                    <router-link :to='"/admin/notification/delete/"+item.id' data-bs-toggle="tooltip" data-bs-placement="top" title="Dalete" @click="showAlert" class="btn btn-sm btn-danger">
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

    const SITE_TITLE = "Notification";

    export default {
        name: "ListNotification",
        components: {
            Layout
        },
        data(){
            return {
                title: SITE_TITLE,
                rows: this.getRows()
            }
        },
        methods:{
            getRows: function(){
                let items = [];
                let i
                for(i = 0; i < 100; i++){
                    items[i] = {
                        id:i,
                        created_at: "dummy"+i,
                        subject: "dummy"+i,
                        sortContent: "dummy"+i,
                        status: "dummy"+i,
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