import ProductService from '../../services/product';
import router from '../../router'

const state = {
    status: {},
    data: {},
    productCategories:[]
}

const mutations = {
    setProductSuccess(state, data){
        data.categorySelected = {
            code : data.category ? data.category.id : "",
            label : data.category ? data.category.name : "",
        }
        data.description = !data.description ? "" : data.description
        data.price = parseFloat(data.price)
        state.data = data
        state.status = {};
    },
    setProductFailure(state){
        state.data = {};
        state.status = {};
    },
    setProductCategoriesSuccess(state, data){
        state.productCategories = data
        state.status = {};
    },
    setProductCategoriesFailure(state){
        state.productCategories = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    categories({ commit }) {
        ProductService.categoriesProduct()
            .then(
                response => commit('setProductCategoriesSuccess', response),
                error => commit('setProductCategoriesFailure', error)
            );
    },
    detail({ commit }, id) {
        ProductService.detailProduct(id)
            .then(
                response => commit('setProductSuccess', response.data),
                error => commit('setProductFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        ProductService.deleteProduct(id)
            .then(
                response => {
                    commit('setProductSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setProductFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        data.category_id = data.categorySelected.code
        ProductService.createProduct(data)
            .then(
                response => {
                    commit('setProductSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/product/detail/'+response.data.id);
                },
                error => {
                    commit('setProductFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.product);
        data.product.category_id = data.product.categorySelected.code
        ProductService.updateProduct(data.product, data.param)
            .then(
                response => {
                    commit('setProductSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/product/detail/'+data.param);
                },
                error => {
                    commit('setProductFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const product = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default product