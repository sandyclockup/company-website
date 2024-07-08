import axios from 'axios';
import authHeader from './auth-header';

class CategoryPortfolioService {

    create(data) {
        return axios
          .post(process.env.VUE_APP_BACKEND_URL + '/cms/category/portfolio/create', data,  { headers: authHeader() })
          .then(response => { return response.data; });
    }

    update(id, data) {
        return axios
          .put(process.env.VUE_APP_BACKEND_URL + '/cms/category/portfolio/update/'+id,  data,  { headers: authHeader() })
          .then(response => { return response.data; });
    }

    read(id) {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/cms/category/portfolio/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    delete(id) {
        return axios
          .delete(process.env.VUE_APP_BACKEND_URL + '/cms/category/portfolio/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    dropdown() {
      return axios
        .get(process.env.VUE_APP_BACKEND_URL + '/cms/category/portfolio-dropdown', { headers: authHeader() })
        .then(response => { return response.data; });
    }
  
}

export default new CategoryPortfolioService();
