import SliderService from '../services/slider.service';

const initialState = {}

export const slider = {

    namespaced: true,
    state: initialState,
    actions: {
        create({ commit }, data) {
            return SliderService.create(data).then(
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
            return SliderService.update(id, data).then(
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
            return SliderService.delete(id).then(
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
            return SliderService.read(id).then(
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