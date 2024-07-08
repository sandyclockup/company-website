import {
    createApp
} from 'vue'
import App from './App.vue'
import router from './router' 
import store from "./store";
import CKEditor from '@ckeditor/ckeditor5-vue';
import setupInterceptors from './services/setupInterceptors';


// CSS
import "admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css"
import "admin-lte/plugins/fontawesome-free/css/all.min.css"
import "admin-lte/plugins/select2/css/select2.min.css"
import "admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"
import "admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"
import "admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"
import "admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css"
import "admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"
import "admin-lte/dist/css/adminlte.min.css"
import "./assets/style.css"
// JAVASCRIPT
import "admin-lte/plugins/jquery/jquery.min.js"
import "admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"
import "admin-lte/plugins/select2/js/select2.full.min.js"
import "admin-lte/plugins/datatables/jquery.dataTables.min.js"
import "admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js"
import "admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"
import "admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js"
import "admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"
import "admin-lte/plugins/jszip/jszip.min.js"
import "admin-lte/plugins/pdfmake/pdfmake.min.js"
import "admin-lte/plugins/pdfmake/vfs_fonts.js"
import "admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js"
import "admin-lte/plugins/datatables-buttons/js/buttons.print.min.js"
import "admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js"
import "admin-lte/dist/js/adminlte.min.js"
import moment from 'moment'

setupInterceptors(store);

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
    //   this route requires auth, check if logged in
    //   if not, redirect to login page.
    const loggedIn = localStorage.getItem('user');
      if (!loggedIn) {
        next("/auth/login")
      } else {
        let SessionData = JSON.parse(loggedIn);
        let dateExpired = SessionData.token_expired;
        let a = moment(dateExpired);
        var b = moment().utc();
        var d = a.diff(b,'minutes');
        if(parseInt(d) > 0){
          next();
        }else{
          localStorage.removeItem('user');
          next('/auth/login');
        }
      }
    } else {
      next() // does not require auth, make sure to always call next()!
    }
  })

createApp(App)
    .use(router)
    .use(store)
    .use(CKEditor)
    .mount('#app')