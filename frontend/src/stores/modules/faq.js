import FaqService from '../../services/faq';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setFaqSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setFaqFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        FaqService.detailFaq(id)
            .then(
                response => commit('setFaqSuccess', response.data),
                error => commit('setFaqFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        FaqService.deleteFaq(id)
            .then(
                response => {
                    commit('setFaqSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setFaqFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        FaqService.createFaq(data)
            .then(
                response => {
                    commit('setFaqSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/faq/detail/'+response.data.id);
                },
                error => {
                    commit('setFaqFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.faq);
        FaqService.updateFaq(data.faq, data.param)
            .then(
                response => {
                    commit('setFaqSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/faq/detail/'+data.param);
                },
                error => {
                    commit('setFaqFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const faq = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default faq