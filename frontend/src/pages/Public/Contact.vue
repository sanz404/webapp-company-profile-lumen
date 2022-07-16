<template>
    <Layout>
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <!-- Contact form-->
                <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i>
                        </div>
                        <h1 class="fw-bolder">Get in touch</h1>
                        <p class="lead fw-normal text-muted mb-0">We'd love to hear from you</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div v-if="alert.message" :class="`alert alert-dismissible fade show ${alert.type}`" role="alert">
                                <small><i class="fa" v-bind:class="[ alert.type === 'alert-success' ? 'fa-check' : 'fa-warning']"></i> &nbsp;{{alert.message}}</small>
                            </div>
                           <form autocomplete="off" @submit.prevent="handleSubmit">
                               
                                <div class="form-floating mb-3">
                                    <input type="text" v-model="contact.full_name" placeholder="Enter your name..."  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.contact.full_name.$error }">
                                    <label for="full_name">Full name</label>
                                    <div v-if="v$.contact.full_name.$error" class="invalid-feedback"> {{ v$.contact.full_name.$errors[0].$message }} </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" v-model="contact.email" placeholder="name@example.com"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.contact.email.$error }">
                                    <label for="email">Email address</label>
                                    <div v-if="v$.contact.email.$error" class="invalid-feedback"> {{ v$.contact.email.$errors[0].$message }} </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" v-model="contact.phone" placeholder="(123) 456-7890"  class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.contact.phone.$error }">
                                    <label for="phone">Phone number</label>
                                    <div v-if="v$.contact.phone.$error" class="invalid-feedback"> {{ v$.contact.phone.$errors[0].$message }} </div>
                                </div>

                                 <div class="form-floating mb-3">
                                    <input type="text" v-model="contact.message" placeholder="Enter your message here..." style="height: 10rem" class="form-control" :disabled="status.sendRequest" :class="{ 'is-invalid': submitted && v$.contact.message.$error }">
                                    <label for="message">Message</label>
                                    <div v-if="v$.contact.message.$error" class="invalid-feedback"> {{ v$.contact.message.$errors[0].$message }} </div>
                                </div>
                               
                              
                                <div class="d-none" id="submitSuccessMessage">
                                    <div class="text-center mb-3">
                                        <div class="fw-bolder">Form submission successful!</div>
                                        To activate this form, sign up at
                                        <br />
                                        <a
                                            href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                    </div>
                                </div>
                                
                                <div class="d-none" id="submitErrorMessage">
                                    <div class="text-center text-danger mb-3">Error sending message!</div>
                                </div>
                                <!-- Submit Button-->
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" id="submitButton" type="submit">
                                         <template v-if="status.sendRequest === true">
                                            <i class="fa fa-spinner fa-spin"></i>&nbsp;Send Data...
                                        </template>
                                        <template v-else>
                                            Submit
                                        </template>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Contact cards-->
                <div class="row gx-5 row-cols-2 row-cols-lg-4 py-5">
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                class="bi bi-chat-dots"></i></div>
                        <div class="h5 mb-2">Chat with us</div>
                        <p class="text-muted mb-0">Chat live with one of our support specialists.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-people"></i>
                        </div>
                        <div class="h5">Ask the community</div>
                        <p class="text-muted mb-0">Explore our community forums and communicate with other users.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                class="bi bi-question-circle"></i></div>
                        <div class="h5">Support center</div>
                        <p class="text-muted mb-0">Browse FAQ's and support articles to find solutions.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                class="bi bi-telephone"></i></div>
                        <div class="h5">Call us</div>
                        <p class="text-muted mb-0">Call us during normal business hours at (555) 892-9403.</p>
                    </div>
                </div>
            </div>
        </section>
        <Footer/>
    </Layout>
</template>
<script>

    import { useMeta } from 'vue-meta'
    import useValidate from '@vuelidate/core'
    import { required, email, numeric, minLength, maxLength } from '@vuelidate/validators'
    import { mapState, mapActions } from 'vuex'
    import Layout from "../../components/Public/Layout.vue"
    import Footer from "../../components/Public/Footer.vue"

    export default {
       name: "Contact",
       components: {
            Footer,
            Layout
        },
        data() {
            return {
                submitted: false,
                v$: useValidate(),
                contact:{
                    full_name: "",
                    email: "",
                    phone: "",
                    message: "",
                }
            }
        },
        computed: {
            ...mapState('publication', ['status']),
            ...mapState({
                alert: state => state.alert
            })
        },
        created() { 
           this.alert.message = ''
        },
        mounted() {
            this.getContent()
        },
        methods: {
            ...mapActions('publication', ['sendContact', 'getContent']),
            ...mapActions({
                clearAlert: 'alert/clear' 
            }),
            handleSubmit(e) {
                this.submitted = true;
                this.v$.contact.$validate()
                if (!this.v$.contact.$error) {
                    this.sendContact(this.contact)
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
                contact: {
                    full_name: { required },
                    email: { required, email },
                    phone: { 
                        required,
                        numeric,
                        minLength: minLength(7),
                        maxLength: maxLength(13)
                    },
                    message: { required }
                }
            }
        },
        setup() {
            useMeta({
                title: 'Contact'
            })
        }
    }
</script>