import SkillService from '../services/skill.service';

const initialState = {}

export const skill = {

    namespaced: true,
    state: initialState,
    actions: {
        create({ commit }, data) {
            return SkillService.create(data).then(
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
            return SkillService.update(id, data).then(
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
            return SkillService.delete(id).then(
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
            return SkillService.read(id).then(
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