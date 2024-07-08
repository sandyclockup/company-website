import axios from 'axios';
import authHeader from './auth-header';

class PortfolioImageService {

    headerUpload(){
        let user = JSON.parse(localStorage.getItem('user'));
        return {
           'Authorization': 'Bearer ' + user.access_token,
           'Content-Type': 'multipart/form-data'
        }
    }

    list(id) {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/cms/content/portfolio-image/list/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    create(id, data) {
        return axios
          .post(process.env.VUE_APP_BACKEND_URL + '/cms/content/portfolio-image/create/'+id, data,  { headers: this.headerUpload()  })
          .then(response => { return response.data; });
    }

    primary(id) {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/cms/content/portfolio-image/primary/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    delete(id) {
        return axios
          .delete(process.env.VUE_APP_BACKEND_URL + '/cms/content/portfolio-image/delete/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }
  
}

export default new PortfolioImageService();
