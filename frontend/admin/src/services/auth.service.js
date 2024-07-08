import axios from 'axios';
import TokenService from "./token.service";

class AuthService {
  login(user) {
    return axios
      .post(process.env.VUE_APP_BACKEND_URL + '/auth/login', {
        credential: user.username,
        password: user.password,
        is_admin: 1
      })
      .then(response => {
        if (response.data.data.access_token) {
          let user = response.data.data;
          TokenService.setUser(user);
        }
        return response.data;
      });
  }

  logout() {
    localStorage.removeItem('user');
  }

  forgotPassword(email) {
    return axios
      .post(process.env.VUE_APP_BACKEND_URL + '/auth/email/forgot', {email: email })
      .then(response => { return response.data; });
  }

  resetPassword(user, token) {
    return axios
      .post(process.env.VUE_APP_BACKEND_URL + '/auth/email/reset/'+token, user)
      .then(response => { return response.data; });
  }

}

export default new AuthService();
