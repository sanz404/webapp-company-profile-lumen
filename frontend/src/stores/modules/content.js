import ContentService from '../../services/content';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setContentSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setContentFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        ContentService.detailContent(id)
            .then(
                response => commit('setContentSuccess', response.data),
                error => commit('setContentFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        ContentService.deleteContent(id)
            .then(
                response => {
                    commit('setContentSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setContentFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        ContentService.createContent(data)
            .then(
                response => {
                    commit('setContentSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/content/detail/'+response.data.id);
                },
                error => {
                    commit('setContentFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.content);
        ContentService.updateContent(data.content, data.param)
            .then(
                response => {
                    commit('setContentSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/content/detail/'+data.param);
                },
                error => {
                    commit('setContentFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const content = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default content