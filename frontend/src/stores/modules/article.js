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
    setArticleCategoriesSuccess(state, data){
        state.articleCategories = data
        state.status = {};
    },
    setArticleCategoriesFailure(state){
        state.articleCategories = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    categories({ commit }) {
        articleService.categoriesArticle()
            .then(
                response => commit('setArticleCategoriesSuccess', response),
                error => commit('setArticleCategoriesFailure', error)
            );
    },
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
        let categories = []
        if(data.categorySelected){
            let i = 0
            while(i < data.categorySelected.length){
                categories[i] = data.categorySelected[i].code
                i++;
            }
        }
        data.categories = categories
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
        let categories = []
        if(data.article.categorySelected){
            let i = 0
            while(i < data.article.categorySelected.length){
                categories[i] = data.article.categorySelected[i].code
                i++;
            }
        }
        data.article.categories = categories
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