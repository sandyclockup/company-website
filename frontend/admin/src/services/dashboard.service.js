import axios from 'axios';
import authHeader from './auth-header';

class DashboardService {

    total() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/dashboard/total', { headers: authHeader() })
          .then(response => { return response.data; });
    }

    visitor() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/dashboard/visitor', { headers: authHeader() })
          .then(response => { return response.data; });
    }

    reader() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/dashboard/reader', { headers: authHeader() })
          .then(response => { return response.data; });
    }

    portfolioCustomer() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/dashboard/portfolio/customer', { headers: authHeader() })
          .then(response => { return response.data; });
    }

    portfolioCategory() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/dashboard/portfolio/category', { headers: authHeader() })
          .then(response => { return response.data; });
    }

    articleTag() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/dashboard/article/tag', { headers: authHeader() })
          .then(response => { return response.data; });
    }

    articleCategory() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/dashboard/article/category', { headers: authHeader() })
          .then(response => { return response.data; });
    }
    
  
}

export default new DashboardService();
