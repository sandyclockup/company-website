import axios from 'axios';
import authHeader from './auth-header';

class WebsiteService {

    index() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/setting/website',  { headers: authHeader() })
          .then(response => { return response.data; });
    }
  
}

export default new WebsiteService();
