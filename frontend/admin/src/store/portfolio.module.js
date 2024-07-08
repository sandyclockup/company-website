import PortfolioService from '../services/portfolio.service';

const initialState = {}

export const portfolio = {

    namespaced: true,
    state: initialState,
    actions: {
        create({ commit }, data) {
            return PortfolioService.create(data).then(
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
            return PortfolioService.update(id, data).then(
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
            return PortfolioService.delete(id).then(
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
            return PortfolioService.read(id).then(
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