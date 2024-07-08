import NotificationService from '../services/notification.service';

const initialState = {}

export const notification = {

    namespaced: true,
    state: initialState,
    actions: {
        delete({ commit }, id) {
            return NotificationService.delete(id).then(
                result => {
                    commit('resultSuccess', result);
                    return Promise.resolve(result);
                },
                error => {
                    commit('resultFailure');
                    return Promise.reject(error);
                }
            );
        },
        read({ commit }, id) {
            return NotificationService.read(id).then(
                result => {
                    commit('resultSuccess', result);
                    return Promise.resolve(result);
                },
                error => {
                    commit('resultFailure');
                    return Promise.reject(error);
                }
            );
        },
        board({ commit }) {
            return NotificationService.board().then(
                result => {
                    commit('resultSuccess', result);
                    return Promise.resolve(result);
                },
                error => {
                    commit('resultFailure');
                    return Promise.reject(error);
                }
            );
        },
    },
    mutations: {
        resultSuccess(state){
            state.resultData = state;
        },
        resultFailure(state){
            state.resultData = state;
        }
    }

}