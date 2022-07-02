import { createApp } from 'vue'
import router from "./router"
import App from './App.vue'
import { createMetaManager } from 'vue-meta'

import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { dom } from "@fortawesome/fontawesome-svg-core";
import VueSweetalert2 from 'vue-sweetalert2';


import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-icons/font/bootstrap-icons.scss"
import '@/styles/admin.scss';
import '@/styles/main.scss';
import '@/styles/error.scss';
import "bootstrap"


import 'sweetalert2/dist/sweetalert2.min.css';

library.add(fas);
library.add(fab);
library.add(far);
dom.watch();

router.afterEach((to, from) => {
  const tooltip = document.querySelector('.tooltip')
  if (tooltip !== null) document.body.removeChild(tooltip)
})

createApp(App)
    .use(createMetaManager())
    .use(VueSweetalert2)
    .use(router)
    .component("font-awesome-icon", FontAwesomeIcon)
    .mount('#app')