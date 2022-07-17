import publicationService from '../../services/publication';

const state = {
    status: {},
    contact: {},
    contents:[],
    features:[],
    homeArticle:[],
    abouts:[],
    teams:[],
    faqs:[]
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
    setHomeArticleSuccess(state, data){
        state.homeArticle = data
        state.status = {};
    },
    setHomeArticleFailure(state){
        state.homeArticle = [];
        state.status = {};
    },
    setAboutSuccess(state, data){
        state.abouts = data
        state.status = {};
    },
    setAboutFailure(state){
        state.abouts = [];
        state.status = {};
    },
    setTeamSuccess(state, data){
        state.teams = data
        state.status = {};
    },
    setTeamFailure(state){
        state.teams = [];
        state.status = {};
    },
    setFaqSuccess(state, data){
        state.faqs = data
        state.status = {};
    },
    setFaqFailure(state){
        state.faqs = [];
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
    },
    getAbout({ commit }) {
        publicationService.getAbout()
            .then(
                response => commit('setAboutSuccess', response),
                error => commit('setAboutFailure', error)
            );
    },
    getTeam({ commit }) {
        publicationService.getTeam()
            .then(
                response => commit('setTeamSuccess', response),
                error => commit('setTeamFailure', error)
            );
    },
    getFaq({ commit }) {
        publicationService.getFaq()
            .then(
                response => commit('setFaqSuccess', response),
                error => commit('setFaqFailure', error)
            );
    },
    getHomeArticle({ commit }) {
        publicationService.getHomeArticle()
            .then(
                response => commit('setHomeArticleSuccess', response),
                error => commit('setHomeArticleFailure', error)
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