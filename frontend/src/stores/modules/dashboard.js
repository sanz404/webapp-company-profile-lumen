import dashboardService from '../../services/dashboard';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setDashboardSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setDashboardFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }) {
        dashboardService.contentDashboard()
            .then(
                response => commit('setDashboardSuccess', response),
                error => commit('setDashboardFailure', error)
            );
    }
}


const dashboard = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default dashboard