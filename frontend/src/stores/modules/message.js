import messageService from '../../services/message';

const state = {
    status: {},
    data: {}
}

const mutations = {
    setMessageSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setMessageFailyre(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        messageService.detailMessage(id)
            .then(
                response => commit('setMessageSuccess', response.data),
                error => commit('setMessageFailyre', error)
            );
    }
}


const message = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default message