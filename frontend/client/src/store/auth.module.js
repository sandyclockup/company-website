import AuthService from '../services/auth.service';

const user = JSON.parse(localStorage.getItem('user'));
const initialState = user
  ? { status: { loggedIn: true }, user }
  : { status: { loggedIn: false }, user: null };

export const auth = {
  namespaced: true,
  state: initialState,
  actions: {
    login({ commit }, user) {
      return AuthService.login(user).then(
        user => {
          commit('loginSuccess', user);
          return Promise.resolve(user);
        },
        error => {
          commit('loginFailure');
          return Promise.reject(error);
        }
      );
    },
    register({ commit }, data) {
        return AuthService.register(data).then(
            result => {
                commit('register', result);
                return Promise.resolve(result);
            },
            error => {
                commit('register');
                return Promise.reject(error);
            }
        );
    },
    confirm({ commit }, token) {
      return AuthService.confirm(token).then(
          result => {
              commit('confirm', result);
              return Promise.resolve(result);
          },
          error => {
              commit('confirm');
              return Promise.reject(error);
          }
      );
  },
    forgotPassword({ commit }, user) {
      return AuthService.forgotPassword(user.email).then(
        user => {
          commit('forgotPassword', user);
          return Promise.resolve(user);
        },
        error => {
          commit('forgotPassword');
          return Promise.reject(error);
        }
      );
    },
    resetPassword({ commit }, { user, token }) {
      return AuthService.resetPassword(user, token).then(
        user => {
          commit('resetPassword', user);
          return Promise.resolve(user);
        },
        error => {
          commit('resetPassword');
          return Promise.reject(error);
        }
      );
    },
    logout({ commit }) {
      AuthService.logout();
      commit('logout');
    },
    refreshToken({ commit }, accessToken) {
      commit('refreshToken', accessToken);
    }
  },
  mutations: {
    loginSuccess(state, user) {
      state.status.loggedIn = true;
      state.user = user;
    },
    loginFailure(state) {
      state.status.loggedIn = false;
      state.user = null;
    },
    logout(state) {
      state.status.loggedIn = false;
      state.user = null;
    },
    forgotPassword(state){
      state.status.loggedIn = false;
      state.user = null;
    },
    resetPassword(state){
      state.status.loggedIn = false;
      state.user = null;
    },
    register(state){
      state.status.loggedIn = false;
      state.user = null;
    },
    confirm(state){
      state.status.loggedIn = false;
      state.user = null;
    },
    refreshToken(state, accessToken) {
      state.status.loggedIn = true;
      state.user = { ...state.user, accessToken: accessToken };
    }
  }
};
