import notificationService from "../../services/notification"

const state = {
    status: {},
    current: {},
    data: {}
}

const mutations = {
    setNotificationSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setNotificationFailed(state){
        state.data = {};
        state.status = {};
    },
    setNotificationCurrentSuccess(state, data){
        state.current = data
        state.status = {};
    },
    setNotificationCurrentFailed(state){
        state.current = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {

    detail({ commit }, id) {
        notificationService.detailNotification(id)
            .then(
                response => commit('setNotificationSuccess', response.data),
                error => commit('setNotificationFailed', error)
            );
    },

    current({ commit }) {
        notificationService.currentNotification()
            .then(
                response => commit('setNotificationCurrentSuccess', response.data),
                error => commit('setNotificationCurrentFailed', error)
            );
    },

    delete({ commit }, id) {
        notificationService.deleteNotification(id)
            .then(
                response => commit('setNotificationSuccess', response.data),
                error => commit('setNotificationFailed', error)
            );
    },

}

const notification = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default notification