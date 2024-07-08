import WebsiteService from '../services/website.service';

const initialState = {}

export const website = {

    namespaced: true,
    state: initialState,
    actions: {
        index({ commit }) {
            return WebsiteService.index().then(
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