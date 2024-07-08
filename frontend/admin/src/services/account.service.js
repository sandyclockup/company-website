import axios from 'axios';
import authHeader from './auth-header';

class AccountService {

    changePassword(data) {
        
        let formData = {
            old_password: data.current_password,
            new_password: data.password,
            new_password_confirm: data.password_confirm,
        }

        return axios
          .post(process.env.VUE_APP_BACKEND_URL + '/account/profile/password', formData, { headers: authHeader() })
          .then(response => { return response.data; });
    }

    profile(){
        return axios
            .get(process.env.VUE_APP_BACKEND_URL + '/account/profile/info', { headers: authHeader() })
            .then(response => { return response.data; });
    }

    checkToken(){
        return axios
            .get(process.env.VUE_APP_BACKEND_URL + '/account/profile/token', { headers: authHeader() })
            .then(response => { return response.data; });
    }

    changeProfile(data){
        return axios
            .post(process.env.VUE_APP_BACKEND_URL + '/account/profile/update', data,  { headers: authHeader() })
            .then(response => { return response.data; });
    }

    upload(data){
        return axios
            .post(process.env.VUE_APP_BACKEND_URL + '/account/profile/upload', data, { headers: authHeader() })
            .then(response => { return response.data; });
    }
  
}

export default new AccountService();
