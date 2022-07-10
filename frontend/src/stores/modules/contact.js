import contactService from '../../services/contact';
import router from '../../router'

const state = {
    status: {},
    data: {}
}

const mutations = {
    setContactSuccess(state, data){
        state.data = data
        state.status = {};
    },
    setContactFailure(state){
        state.data = {};
        state.status = {};
    },
    submit(state) {
        state.status = { sendRequest: true };
    },
}

const actions = {
    detail({ commit }, id) {
        contactService.detailContact(id)
            .then(
                response => commit('setContactSuccess', response.data),
                error => commit('setContactFailure', error)
            );
    },
    delete({ dispatch, commit }, id) {
        contactService.deleteContact(id)
            .then(
                response => {
                    commit('setContactSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been delete !!', { root: true });
                    })
                },
                error => {
                    commit('setContactFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    create({ dispatch, commit }, data) {
        commit('submit', data);
        contactService.createContact(data)
            .then(
                response => {
                    commit('setContactSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been created !!', { root: true });
                    })
                    router.push('/admin/contact/detail/'+response.data.id);
                },
                error => {
                    commit('setContactFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    update({ dispatch, commit }, data) {
        commit('submit', data.contact);
        contactService.updateContact(data.contact, data.param)
            .then(
                response => {
                    commit('setContactSuccess', response.data);
                    setTimeout(() => {
                        dispatch('alert/success', 'Your record has been updated !!', { root: true });
                    })
                    router.push('/admin/contact/detail/'+data.param);
                },
                error => {
                    commit('setContactFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
}


const contact = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default contact