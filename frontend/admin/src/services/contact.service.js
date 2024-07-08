import axios from 'axios';
import authHeader from './auth-header';

class ContactService {

    read(id) {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/cms/reference/contact/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    delete(id) {
        return axios
          .delete(process.env.VUE_APP_BACKEND_URL + '/cms/reference/contact/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    total() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/cms/reference/contact-total', { headers: authHeader() })
          .then(response => { return response.data; });
    }
  
}

export default new ContactService();
