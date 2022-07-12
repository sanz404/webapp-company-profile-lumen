import categoryArticleService from '../../services/categories/article';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setCategoryArticleSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setCategoryArticleFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        categoryArticleService.detailArticle(id)
            .then(
                response => commit('setCategoryArticleSuccess', response.data),
                error => commit('setCategoryArticleFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        categoryArticleService.deleteArticle(id)
            .then(
                response => {
                    commit('setCategoryArticleSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setCategoryArticleFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        categoryArticleService.createArticle(data)
            .then(
                response => {
                    commit('setCategoryArticleSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/categories/article/detail/'+response.data.id);
                },
                error => {
                    commit('setCategoryArticleFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.categoryArticle);
        categoryArticleService.updateArticle(data.categoryArticle, data.param)
            .then(
                response => {
                    commit('setCategoryArticleSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/categories/article/detail/'+data.param);
                },
                error => {
                    commit('setCategoryArticleFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const categoryArticle = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default categoryArticle