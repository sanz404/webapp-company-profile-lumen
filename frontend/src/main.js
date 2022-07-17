import { createApp } from 'vue'
import { createStore } from "vuex";
import router from "./router"
import App from './App.vue'
import { createMetaManager } from 'vue-meta'
import storeApp from './stores/index'
import createPersistedState from "vuex-persistedstate";

import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { dom } from "@fortawesome/fontawesome-svg-core";
import VueSweetalert2 from 'vue-sweetalert2';
import vSelect from 'vue-select'
import CKEditor from '@ckeditor/ckeditor5-vue'
import Pagination from 'v-pagination-3';

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-icons/font/bootstrap-icons.scss"
import '@/styles/admin.scss';
import '@/styles/main.scss';
import '@/styles/error.scss';
import "bootstrap"

import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-select/dist/vue-select.css';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';


library.add(fas);
library.add(fab);
library.add(far);
dom.watch();

const publicRoutes = [
  "Profile",
  "ChangePassword",
]


const authUser = JSON.parse(localStorage.getItem('user'));

router.afterEach((to, from) => {
  const tooltip = document.querySelector('.tooltip')
  if (tooltip !== null) document.body.removeChild(tooltip)
})

router.beforeEach((to, from, next) => {

    let pathArray = window.location.pathname.split('/');
    let pathAdmin = pathArray[1];

    if(publicRoutes.includes(to.name)){
        if(authUser && authUser.token) {
            if(parseInt(authUser.is_admin) === 0){
              let date_now = Math.floor(Date.now() / 1000)
              let expired = authUser.expires_in
              if(parseInt(date_now) > parseInt(expired)){
                next({ name: 'Logout' })
              }else{
                next()  
              }
            }else{
              next({ name: 'error403' })
            }  
        }else{
            next({ name: 'Login' })
        }
    }else if(pathAdmin === 'admin'){
      if(authUser && authUser.token) {
          if(parseInt(authUser.is_admin) === 1){
            let date_now = Math.floor(Date.now() / 1000)
            let expired = authUser.expires_in
            if(parseInt(date_now) > parseInt(expired)){
              next({ name: 'Logout' })
            }else{
              next()  
            }
          }else{
            next({ name: 'error403' })
          }
      }else{
          next({ name: 'Login' })
      }
    }else{
      next()
    }
})



const store = createStore({ 
    modules: storeApp, 
    plugins: [createPersistedState()] 
});

createApp(App)
    .use(createMetaManager())
    .use(VueSweetalert2)
    .use(CKEditor)
    .use(router)
    .use(store)
    .component("font-awesome-icon", FontAwesomeIcon)
    .component("v-select", vSelect)
    .component("pagination", Pagination)
    .mount('#app')