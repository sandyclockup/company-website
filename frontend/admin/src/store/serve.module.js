import ServeService from '../services/serve.services';

const initialState = {}

export const serve = {

    namespaced: true,
    state: initialState,
    actions: {
        create({ commit }, data) {
            return ServeService.create(data).then(
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
        update({ commit }, { id, data }) {
            return ServeService.update(id, data).then(
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
        delete({ commit }, id) {
            return ServeService.delete(id).then(
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
            return ServeService.read(id).then(
                result => {
                    commit('resultSuccess', result);
                    return Promise.resolve(result);
                },
                error => {
                    commit('resultFailure');
                    return Promise.reject(error);
                }
            );
        }
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