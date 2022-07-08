import accountService from '../../services/account';

const state = {
    status: {},
    profile: {},
    countries: []
}

const mutations = {
    passwordRequest(state) {
        state.status = {};
    },
    passwordSuccess(state) {
        state.status = {};
    },
    passwordFailure(state) {
        state.status = {};
    },
    getAccountRequest(state){
        state.status = { loadingAccount: true};
    },
    getAccountSuccess(state, data){
        state.status = { profile : true };
        state.profile = data;
    },
    getAccountFailure(state){
        state.status = {};
    },
    getCountriesRequest(state){
        state.status = { loadingCountries: true};
    },
    getCountriesSuccess(state, data){
        state.status = { countries : true };
        state.countries = data;
    },
    getCountriesFailure(state){
        state.status = {};
    },
    updateAccountRequest(state){
        state.status = { sendRequest: true };
    },
    updateAccountSuccess(state){
        state.status = {};
    },
    updateAccountFailure(state){
        state.status = {};
    }
}

const actions = {
    updatePassword({ dispatch, commit }, data) {
        commit('passwordRequest', data);
        accountService.updatePassword(data)
            .then(
                data => {
                    commit('passwordSuccess', data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your password has been changed !!', { root: true });
                    })
                },
                error => {
                    commit('passwordFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    profile({ commit } ) {
        commit('getAccountRequest');
        accountService.getProfile()
            .then(
                response => commit('getAccountSuccess', response.data),
                error => commit('getAccountFailure', error)
            );
    },
    countries({ commit } ) {
        commit('getCountriesRequest');
        accountService.getCountries()
            .then(
                response => commit('getCountriesSuccess', response.data),
                error => commit('getCountriesFailure', error)
            );
    },
    updateProfile({ dispatch, commit }, data) {
        commit('updateAccountRequest', data);
        accountService.updateProfile(data)
            .then(
                data => {
                    commit('updateAccountSuccess', data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your profile has been changed !!', { root: true });
                    })
                },
                error => {
                    commit('updateAccountFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const account = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default account