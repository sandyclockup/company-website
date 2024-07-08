import axios from 'axios';
import authHeader from './auth-header';

class SkillService {

    create(data) {
        return axios
          .post(process.env.VUE_APP_BACKEND_URL + '/cms/content/skill/create', data,  { headers: authHeader() })
          .then(response => { return response.data; });
    }

    update(id, data) {
        return axios
          .put(process.env.VUE_APP_BACKEND_URL + '/cms/content/skill/update/'+id,  data,  { headers: authHeader() })
          .then(response => { return response.data; });
    }

    read(id) {
        return axios
          .get(process.env.VUE_APP_BACKEND_URL + '/cms/content/skill/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    delete(id) {
        return axios
          .delete(process.env.VUE_APP_BACKEND_URL + '/cms/content/skill/'+id, { headers: authHeader() })
          .then(response => { return response.data; });
    }
  
}

export default new SkillService();
