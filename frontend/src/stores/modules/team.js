import teamService from '../../services/team';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setTeamSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setTeamFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        teamService.detailTeam(id)
            .then(
                response => commit('setTeamSuccess', response.data),
                error => commit('setTeamFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        teamService.deleteTeam(id)
            .then(
                response => {
                    commit('setTeamSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setTeamFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        teamService.createTeam(data)
            .then(
                response => {
                    commit('setTeamSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/team/detail/'+response.data.id);
                },
                error => {
                    commit('setTeamFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.team);
        teamService.updateTeam(data.team, data.param)
            .then(
                response => {
                    commit('setTeamSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/team/detail/'+data.param);
                },
                error => {
                    commit('setTeamFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const team = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default team