import categoryProjectService from '../../services/categories/project';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setCategoryProjectSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setCategoryProjectFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        categoryProjectService.detailProject(id)
            .then(
                response => commit('setCategoryProjectSuccess', response.data),
                error => commit('setCategoryProjectFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        categoryProjectService.deleteProject(id)
            .then(
                response => {
                    commit('setCategoryProjectSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setCategoryProjectFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        categoryProjectService.createProject(data)
            .then(
                response => {
                    commit('setCategoryProjectSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/categories/project/detail/'+response.data.id);
                },
                error => {
                    commit('setCategoryProjectFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.categoryProject);
        categoryProjectService.updateProject(data.categoryProject, data.param)
            .then(
                response => {
                    commit('setCategoryProjectSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/categories/project/detail/'+data.param);
                },
                error => {
                    commit('setCategoryProjectFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const categoryProject = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default categoryProject