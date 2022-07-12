import userService from '../../services/user';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setUserSuccess(state, data){
        data.countrySelected = {
            code: data.country_id,
            label: data.country_name 
        }
        state.data = data
        state.status = {};
    },
    setUserFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        userService.detailUser(id)
            .then(
                response => commit('setUserSuccess', response.data),
                error => commit('setUserFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        userService.deleteUser(id)
            .then(
                response => {
                    commit('setUserSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setUserFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        data.country_id = data.countrySelected.code
        userService.createUser(data)
            .then(
                response => {
                    commit('setUserSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/user/detail/'+response.data.id);
                },
                error => {
                    commit('setUserFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.user);
        data.user.country_id = data.user.countrySelected.code
        userService.updateUser(data.user, data.param)
            .then(
                response => {
                    commit('setUserSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/user/detail/'+data.param);
                },
                error => {
                    commit('setUserFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const User = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default User