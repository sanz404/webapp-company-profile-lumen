import categoryProductService from '../../services/categories/product';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setCategoryProductSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setCategoryProductFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        categoryProductService.detailProduct(id)
            .then(
                response => commit('setCategoryProductSuccess', response.data),
                error => commit('setCategoryProductFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        categoryProductService.deleteProduct(id)
            .then(
                response => {
                    commit('setCategoryProductSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setCategoryProductFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        categoryProductService.createProduct(data)
            .then(
                response => {
                    commit('setCategoryProductSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/categories/product/detail/'+response.data.id);
                },
                error => {
                    commit('setCategoryProductFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.categoryProduct);
        categoryProductService.updateProduct(data.categoryProduct, data.param)
            .then(
                response => {
                    commit('setCategoryProductSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/categories/product/detail/'+data.param);
                },
                error => {
                    commit('setCategoryProductFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const categoryProduct = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default categoryProduct