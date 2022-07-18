import publicationService from '../../services/publication';

const state = {
    status: {},
    contact: {},
    contents:[],
    features:[],
    homeArticle:[],
    abouts:[],
    teams:[],
    faqs:[],
    products:[],
    projects:[],
    project:{},
    article:{},
    comment:{},
    categories:[],
    listArticles:[],
    listArticleLimit: 0,
    listArticleTotal: 0
}

const mutations = {
    setCategoriesSuccess(state, data){
        state.categories = data
        state.status = {};
    },
    setCategoriesFailure(state){
        state.categories = {};
        state.status = {};
    },
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
    setProductSuccess(state, data){
        state.products = data
        state.status = {};
    },
    setProductFailure(state){
        state.products = [];
        state.status = {};
    },
    setProjectsSuccess(state, data){
        state.projects = data
        state.status = {};
    },
    setProjectsFailure(state){
        state.projects = [];
        state.status = {};
    },
    setProjectSuccess(state, data){
        state.project = data
        state.status = {};
    },
    setProjecsFailure(state){
        state.project = [];
        state.status = {};
    },
    setArticleSuccess(state, data){
        state.article = data
        state.status = {};
    },
    setArticleFailure(state){
        state.article = {}
        state.status = {};
    },
    setCommentSuccess(state, data){
        state.comment = data
        state.status = {};
    },
    setCommentFailure(state){
        state.comment = {}
        state.status = {};
    },
    setListArticleSuccess(state, response){
        state.listArticles = response.data
        state.listArticleLimit = response.perpage
        state.listArticleTotal = response.total_records
        state.status = {};
    },
    setListArticleFailure(state){
        state.listArticles = []
        state.status = {};
        state.listArticleLimit = 0
        state.listArticleTotal = 0
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    getListArticle({ dispatch, commit }, data) {
        commit('submit', data);
        publicationService.getListArticle(data)
            .then(
                response => {
                    commit('setListArticleSuccess', response);
                },
                error => {
                    commit('setListArticleFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    sendComment({ dispatch, commit }, data) {
        commit('submit', data);
        publicationService.sendComment(data)
            .then(
                response => {
                    commit('setCommentSuccess', response);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your comment has been added !!', { root: true });
                    })
                },
                error => {
                    commit('setCommentFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
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
    getArticleBySlug({ commit }, slug) {
        publicationService.getArticleBySlug(slug)
            .then(
                response => commit('setArticleSuccess', response),
                error => commit('setArticleFailure', error)
            );
    },
    getProjectById({ commit }, id) {
        publicationService.getProjectById(id)
            .then(
                response => commit('setProjectSuccess', response),
                error => commit('setProjectFailure', error)
            );
    },
    getProjects({ commit }) {
        publicationService.getProject()
            .then(
                response => commit('setProjectsSuccess', response),
                error => commit('setProjectsFailure', error)
            );
    },
    getProduct({ commit }) {
        publicationService.getProduct()
            .then(
                response => commit('setProductSuccess', response),
                error => commit('setProductFailure', error)
            );
    },
    getContent({ commit }) {
        publicationService.getContent()
            .then(
                response => commit('setContentSuccess', response),
                error => commit('setContentSuccess', error)
            );
    },
    getCategories({ commit }) {
        publicationService.getArticleCategories()
            .then(
                response => commit('setCategoriesSuccess', response),
                error => commit('setCategoriesFailure', error)
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