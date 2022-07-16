import publicationService from '../../services/publication';

const state = {
    status: {},
    contact: {},
    contents:[],
    features:[]
}

const mutations = {
    setContactSuccess(state, data){
        state.contact = data
        state.status = {};
    },
    setContactFailure(state){
        state.contact = {};
        state.status = {};
    },
    setContentSuccess(state, data){
        state.contents = data
        state.status = {};
    },
    setContenttFailure(state){
        state.contents = [];
        state.status = {};
    },
    setFeatureSuccess(state, data){
        state.features = data
        state.status = {};
    },
    setFeatureFailure(state){
        state.features = [];
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    sendContact({ dispatch, commit }, data) {
        commit('submit', data);
        publicationService.contactSend(data)
            .then(
                response => {
                    commit('setContactSuccess', response);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your message has been sent !!', { root: true });
                        location.reload(true)
                    })
                },
                error => {
                    commit('setContactFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    getContent({ commit }) {
        publicationService.getContent()
            .then(
                response => commit('setContentSuccess', response),
                error => commit('setContentSuccess', error)
            );
    },
    getFeature({ commit }) {
        publicationService.getFeature()
            .then(
                response => commit('setFeatureSuccess', response),
                error => commit('setFeatureFailure', error)
            );
    }
}


const publication = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default publication