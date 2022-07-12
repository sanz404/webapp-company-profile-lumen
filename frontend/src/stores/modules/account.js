import accountService from '../../services/account';
import router from '../../router'

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
    getAccountSuccess(state, authProfile){
        authProfile.countrySelected = {
            code: authProfile.country ? authProfile.country.id : null,
            label: authProfile.country ? authProfile.country.name : null
        }
        state.profile = authProfile.data;
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
                data => {
                    commit('getAccountSuccess', data);
                },
                error => {
                    router.push('/auth/logout');
                }
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