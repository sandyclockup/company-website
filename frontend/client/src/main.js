import {
    createApp
} from 'vue'
import App from './App.vue'
import router from './router' // <---
import store from "./store";
import setupInterceptors from './services/setupInterceptors';

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.min.js"
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'aos/src/sass/aos.scss'
import "animate.css"
import 'boxicons/css/boxicons.min.css'
import 'remixicon/fonts/remixicon.css'
import 'glightbox/dist/css/glightbox.min.css'
import "glightbox/dist/js/glightbox.js"
import "./assets/css/style.css"
import "./assets/css/dataTables.bootstrap5.css"

import { library, dom } from "@fortawesome/fontawesome-svg-core"
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome"
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'

setupInterceptors(store);

library.add(fas, far, fab)
dom.watch()

router.beforeEach((to, from, next) => {
    fetch(process.env.VUE_APP_BACKEND_URL + '/page/guest/content')
    .then(response => response.json())
    .then(result => {
        localStorage.setItem("config", JSON.stringify(result.data));
        next();
    });
})

createApp(App)
    .use(router)
    .use(store)
    .component("font-awesome-icon", FontAwesomeIcon)
    .mount('#app')