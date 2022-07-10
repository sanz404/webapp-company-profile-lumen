import accountService from '../../services/account';

const state = {
    status: {},
    profile: {},
    countries: []
}

const mutations = {
    passwordRequest(state) {
        state.status = { sendRequest: true };
    },
    passwordSuccess(state) {
        state.status = {};
    },
    getAccountSuccess(state, data){
        data.countrySelected = {
            code: data.country ? data.country.id : null,
            label: data.country ? data.country.name : null
        }
        state.profile = data;
    },
    getAccountFailure(state){
        state.status = {};
    },
    getCountriesSuccess(state, data){
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
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    profile({ commit } ) {
        accountService.getProfile()
            .then(
                response => commit('getAccountSuccess', response.data),
                error => commit('getAccountFailure', error)
            );
    },
    countries({ commit } ) {
        accountService.getCountries()
            .then(
                response => commit('getCountriesSuccess', response.data),
                error => commit('getCountriesFailure', error)
            );
    },
    updateProfile({ dispatch, commit }, data) {
        commit('updateAccountRequest', data);
        data.country_id = data.countrySelected.code
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