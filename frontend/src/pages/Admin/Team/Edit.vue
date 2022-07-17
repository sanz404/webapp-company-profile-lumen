<template>
    <Layout>
        <h1 class="mt-4">{{ title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><a href="#">Reference</a></li>
            <li class="breadcrumb-item"><router-link to="/admin/team/list">{{ title }}</router-link></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
        <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
            <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
        </div>
        <form autocomplete="off" @submit.prevent="handleSubmit">
             <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6><i class="fas fa-edit"></i>&nbsp;Please fill in the form below</h6>
                </div>
               <div class="card-body">
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Photo</label>
                        <div class="col-sm-10">
                           <input type="file" class="form-control" v-on:change="handleFileUpload" accept="image/*" />
                           <span v-if="file_error" class="invalid-feedback"> {{ file_error_message }} </span>
                           <template v-if="team.image && (team.image).length === 40">
                                <h1></h1>
                                <img :src="this.backendURL+'/uploads/'+team.image" class="img-thumbnail" width="250" />
                            </template>
                            <template v-else>
                                <h1></h1>
                                <template v-if="team.image">
                                    <img :src="team.image" class="img-thumbnail" width="250" />
                                </template>
                                <template v-else>
                                    <img :src="'/images/no-image.png'" class="img-thumbnail" width="400" />
                                </template>
                            </template>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" v-model="team.name"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.team.name.$error }">
                            <span v-if="v$.team.name.$error" class="invalid-feedback"> {{ v$.team.name.$errors[0].$message }} </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Position <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" v-model="team.position"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.team.position.$error }">
                            <span v-if="v$.team.position.$error" class="invalid-feedback"> {{ v$.team.position.$errors[0].$message }} </span>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" v-model="team.description" rows="6" :disabled="status.sendRequest"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label  class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="1" v-model="team.is_published">
                                <label class="form-check-label" for="inlineRadio1">Published</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="0" v-model="team.is_published">
                                <label class="form-check-label text-nowrap" for="inlineRadio2">Draft</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-start">
                         <router-link to="/admin/team/list" data-bs-toggle="tooltip" data-bs-placement="top" title="Back To List" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>&nbsp;Back To List
                        </router-link>
                        &nbsp;
                        <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Save From" :disabled="status.sendRequest">
                            <template v-if="status.sendRequest === true">
                                <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                            </template>
                            <template v-else>
                                <i class="fa fa-save"></i>&nbsp;Save Change
                            </template>
                        </button>
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
    import { mapState, mapActions } from 'vuex'
    import useValidate from '@vuelidate/core'
    import { required  } from '@vuelidate/validators'
    import helper from "../../../helpers/index"

    const SITE_TITLE = "Team";

    export default {
        name: "EditTeam",
        components: {
            Layout
        },
        props: ['param'],
        data(){
            return {
                title: SITE_TITLE,
                submitted: false,
                v$: useValidate(),
                file_error: false,
                file_error_message: "",
                backendURL: process.env.VUE_APP_SERVICE
            }
        },
        setup() {
            useMeta({
                title: SITE_TITLE
            })
        },
         computed: {
            ...mapState('team', ['status']),
            ...mapState({
                alert: state => state.alert,
                status: state=> state.team.status,
                team: state=> state.team.data,

            })
        },
        created() { 
           this.alert.message = ''
        },
        mounted() {
            this.getTeam(this.param)
        },
        methods: {
            ...mapActions('team', {
                getTeam: 'detail',
                updateTeam: 'update'
            }),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.$validate()
                if (!this.v$.team.$error) {
                    const { team, param } = this;
                    this.updateTeam({ team, param })
                } 
            },
           handleFileUpload(e){
                if(e.target.files){
                    let files = e.target.files
                    if(files[0]){
                        let fileSelected = files[0]
                        let fileSize = fileSelected.size / 1024 / 1024;
                        if (!fileSelected.name.match(/.(jpg|jpeg|png|gif)$/i)){
                            e.target.value = ""
                            this.team.image = ""
                            this.file_error = true
                            this.file_error_message = "The photo must be an image."
                        }else if(fileSize > 2){
                            e.target.value = ""
                            this.team.image = ""
                            this.file_error = true
                            this.file_error_message = "Maximum upload file size: 2MB."
                        }else{
                            this.file_error = false
                            this.file_error_message = ""
                            helper.getBase64(fileSelected).then(
                                data => this.team.image = data
                            );
                        }
                    }
                }
            }
        },
        watch: {
            $route (to, from){
                // clear alert on location change
                this.clearAlert();
            }
        },
        validations() {
            return {
                team: {
                    name: { required },
                    position: { required }
                }
            }
        },
    }
</script>