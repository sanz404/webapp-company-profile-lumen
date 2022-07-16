import aboutService from '../../services/about';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setAboutSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setAboutFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        aboutService.detailAbout(id)
            .then(
                response => commit('setAboutSuccess', response.data),
                error => commit('setAboutFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        aboutService.deleteAbout(id)
            .then(
                response => {
                    commit('setAboutSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setAboutFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        aboutService.createAbout(data)
            .then(
                response => {
                    commit('setAboutSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/about/detail/'+response.data.id);
                },
                error => {
                    commit('setAboutFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.about);
        aboutService.updateAbout(data.about, data.param)
            .then(
                response => {
                    commit('setAboutSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/about/detail/'+data.param);
                },
                error => {
                    commit('setAboutFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const about = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default about