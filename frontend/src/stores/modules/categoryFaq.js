import categoryFaqService from '../../services/categories/faq';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setCategoryFaqSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setCategoryFaqFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        categoryFaqService.detailFaq(id)
            .then(
                response => commit('setCategoryFaqSuccess', response.data),
                error => commit('setCategoryFaqFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        categoryFaqService.deleteFaq(id)
            .then(
                response => {
                    commit('setCategoryFaqSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setCategoryFaqFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        categoryFaqService.createFaq(data)
            .then(
                response => {
                    commit('setCategoryFaqSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/categories/faq/detail/'+response.data.id);
                },
                error => {
                    commit('setCategoryFaqFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.categoryFaq);
        categoryFaqService.updateFaq(data.categoryFaq, data.param)
            .then(
                response => {
                    commit('setCategoryFaqSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/categories/faq/detail/'+data.param);
                },
                error => {
                    commit('setCategoryFaqFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const categoryFaq = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default categoryFaq