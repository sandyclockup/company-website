import axios from 'axios';
import authHeader from './auth-header';

class NotificationService {

    board() {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/account/notification', { headers: authHeader() })
          .then(response => { return response.data; });
    }

    read(id) {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/account/notification/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    delete(id) {
        return axios
          .delete(process.env.VUE_APP_BACKEND_URL + '/account/notification/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }
  
}

export default new NotificationService();
