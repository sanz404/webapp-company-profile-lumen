import FeatureService from '../../services/feature';
import router from '../../router'

const state = {
    status: {},
    data: {},
    fonts:[]
}

const mutations = {
    setFeatureSuccess(state, data){
        data.iconSelected = {
            code: data.icon,
            label: data.icon
        }
        state.data = data
        state.status = {};
    },
    setFeatureFailure(state){
        state.data = {};
        state.status = {};
    },
    setFontSuccess(state, data){
        state.fonts = data
        state.status = {};
    },
    setFontFailure(state){
        state.fonts = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    font({ commit }) {
        FeatureService.fontFeature()
            .then(
                response => commit('setFontSuccess', response),
                error => commit('setFontFailure', error)
            );
    },
    detail({ commit }, id) {
        FeatureService.detailFeature(id)
            .then(
                response => commit('setFeatureSuccess', response.data),
                error => commit('setFeatureFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        FeatureService.deleteFeature(id)
            .then(
                response => {
                    commit('setFeatureSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setFeatureFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        FeatureService.createFeature(data)
            .then(
                response => {
                    commit('setFeatureSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/feature/detail/'+response.data.id);
                },
                error => {
                    commit('setFeatureFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.feature);
        FeatureService.updateFeature(data.feature, data.param)
            .then(
                response => {
                    commit('setFeatureSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/feature/detail/'+data.param);
                },
                error => {
                    commit('setFeatureFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const feature = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default feature