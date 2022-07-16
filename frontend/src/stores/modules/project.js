import ProjectService from '../../services/project';
import router from '../../router'

const state = {
    status: {},
    data: {},
    projectCategories:[]
}

const mutations = {
    setProjectSuccess(state, data){
        data.categorySelected = {
            code : data.category ? data.category.id : "",
            label : data.category ? data.category.name : "",
        }
        state.data = data
        state.status = {};
    },
    setProjectFailure(state){
        state.data = {};
        state.status = {};
    },
    setProjectCategoriesSuccess(state, data){
        state.projectCategories = data
        state.status = {};
    },
    setProjectCategoriesFailure(state){
        state.projectCategories = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    categories({ commit }) {
        ProjectService.categoriesProject()
            .then(
                response => commit('setProjectCategoriesSuccess', response),
                error => commit('setProjectCategoriesFailure', error)
            );
    },
    detail({ commit }, id) {
        ProjectService.detailProject(id)
            .then(
                response => commit('setProjectSuccess', response.data),
                error => commit('setProjectFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        ProjectService.deleteProject(id)
            .then(
                response => {
                    commit('setProjectSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setProjectFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        data.category_id = data.categorySelected.code
        ProjectService.createProject(data)
            .then(
                response => {
                    commit('setProjectSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/project/detail/'+response.data.id);
                },
                error => {
                    commit('setProjectFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.project);
        data.project.category_id = data.project.categorySelected.code
        ProjectService.updateProject(data.project, data.param)
            .then(
                response => {
                    commit('setProjectSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/project/detail/'+data.param);
                },
                error => {
                    commit('setProjectFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const project = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default project