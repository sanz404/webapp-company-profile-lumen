import articleService from '../../services/article';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setArticleSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setArticleFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        articleService.detailArticle(id)
            .then(
                response => commit('setArticleSuccess', response.data),
                error => commit('setArticleFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        articleService.deleteArticle(id)
            .then(
                response => {
                    commit('setArticleSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setArticleFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        articleService.createArticle(data)
            .then(
                response => {
                    commit('setArticleSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/article/detail/'+response.data.id);
                },
                error => {
                    commit('setArticleFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.article);
        articleService.updateArticle(data.article, data.param)
            .then(
                response => {
                    commit('setArticleSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/article/detail/'+data.param);
                },
                error => {
                    commit('setArticleFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const article = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default article