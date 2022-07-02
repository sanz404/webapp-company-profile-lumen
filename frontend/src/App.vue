<template>
   <loading v-model:active="isLoading" :loader="'spinner'" :background-color="'#f1f1f1'" :width=250 :height=250 :color="'#0d6efd'" :can-cancel="true" :opacity=1 :is-full-page="fullPage"/>
   <metainfo>
    <template v-slot:title="{ content }">{{ content ? `${siteName} | ${content}` : `SITE_NAME` }}</template>
  </metainfo>
  <router-view></router-view>
</template>

<script>

  import { useRoute } from 'vue-router'
  import { computed } from 'vue'
  import { useMeta } from 'vue-meta'
  import { Tooltip } from "bootstrap";

  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/vue-loading.css';

  new Tooltip(document.body, {
    selector: "[data-bs-toggle='tooltip']",
    trigger: 'hover'
  });

  const totalTimeOut = 3500;

  export default {
    name: 'App', 
    components: {
       Loading
    },
    data(){
       return {
          isLoading: true,
          fullPage: true
       }
    },
    created() {
      setTimeout(() => {
          this.isLoading = false;
      }, totalTimeOut);
    },
    mounted(){
       setTimeout(() => {
          this.isLoading = false;
      }, totalTimeOut);
    },
    updated(){
       setTimeout(() => {
          this.isLoading = false;
      }, totalTimeOut);
    },
    setup() {

      useMeta({
        title: '',
        htmlAttrs: { lang: 'en', amp: true }
      })

      const siteName = process.env.VUE_APP_TITLE
      const route = useRoute();
      const path = computed(() => route.path)
      return {
        path,
        siteName,
      }
    },
     watch: {
      $route: {
        immediate: true,
        handler(to, from) {
          this.isLoading = true;
        }
      },
    }
  }
</script>