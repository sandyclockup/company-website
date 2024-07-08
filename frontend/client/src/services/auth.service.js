import axios from 'axios';
import TokenService from "./token.service";

class AuthService {
  login(user) {
    return axios
      .post(process.env.VUE_APP_BACKEND_URL + '/auth/login', {
        credential: user.username,
        password: user.password,
        is_admin: 0
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

  confirm(token) {
    return axios
      .get(process.env.VUE_APP_BACKEND_URL + '/auth/confirm/'+token)
      .then(response => { return response.data; });
  }

  register(data) {
    return axios
      .post(process.env.VUE_APP_BACKEND_URL + '/auth/register', data)
      .then(response => { return response.data; });
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
