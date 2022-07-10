import userService from '../../services/auth';
import router from '../../router'

const user = JSON.parse(localStorage.getItem('user'));
const state = user
    ? { status: { loggedIn: true }, user }
    : { status: {}, user: null };

const actions = {
    login({ dispatch, commit }, { username, password, remember_me }) {
        commit('loginRequest', { username });
    
        userService.login(username, password, remember_me)
            .then(
                user => {
                    commit('loginSuccess', user);
                    router.push('/home');
                    setTimeout(() => {
                        location.reload(true)
                    })
                },
                error => {
                    commit('loginFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    logout({ commit }) {

        userService.logout();
        commit('logout');

        router.push('/home');
        setTimeout(() => {
            localStorage.clear();
            location.reload(true)
        })
    },
    logged({ commit }){
        commit('logged');
        if(state.user){
            router.push('/home');
            setTimeout(() => {
                location.reload(true)
            })
        }
    },
    register({ dispatch, commit }, user) {
        commit('registerRequest', user);
    
        userService.register(user)
            .then(
                user => {
                    commit('registerSuccess', user);
                    router.push('/auth/login');
                    setTimeout(() => {
                        dispatch('alert/success', 'You need to confirm your account. We have sent you an activation code, please check your email. !!', { root: true });
                    })
                },
                error => {
                    commit('registerFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    forgot_password({ dispatch, commit }, email) {
        commit('forgotRequest', email);
        userService.forgot_password(email)
            .then(
                email => {
                    commit('forgotSuccess', email);
                    setTimeout(() => {
                        dispatch('alert/success', 'We have e-mailed your password reset link!', { root: true });
                    })
                },
                error => {
                    commit('forgotFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    reset_password({ dispatch, commit }, user) {
        commit('recoveryRequest', user);
        userService.reset_password(user)
            .then(
                user => {
                    commit('recoverySuccess', user);
                    router.push('/auth/login');
                    setTimeout(() => {
                        dispatch('alert/success', 'Your password has been reset!', { root: true });
                    })
                },
                error => {
                    commit('recoveryFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    confirm({ dispatch, commit }, token) {
        commit('confirmRequest', token);
        userService.confirm(token)
            .then(
                token => {
                    commit('confirmSuccess', token);
                    router.push('/auth/login');
                    setTimeout(() => {
                        dispatch('alert/success', 'Your e-mail is verified. You can now login.', { root: true });
                    })
                },
                error => {
                    commit('confirmFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
};

const mutations = {
    loginRequest(state, user) {
        state.status = { loggingIn: true };
        state.user = user;
    },
    loginSuccess(state, user) {
        state.status = { loggedIn: true };
        state.user = user;
    },
    loginFailure(state) {
        state.status = {};
        state.user = null;
    },
    logout(state) {
        state.status = {};
        state.user = null;
    },
    registerRequest(state, user) {
        state.status = { registering: true };
    },
    registerSuccess(state, user) {
        state.status = {};
    },
    registerFailure(state, error) {
        state.status = {};
    },
    logged(state){
        state.status = {};
    },
    forgotRequest(state, email) {
        state.status = { sendRequest: true };
    },
    forgotSuccess(state, email) {
        state.status = {};
    },
    forgotFailure(state, email) {
        state.status = {};
    },
    recoveryRequest(state, user) {
        state.status = { recoveryRequest: true };
    },
    recoverySuccess(state, user) {
        state.status = {};
    },
    recoveryFailure(state, error) {
        state.status = {};
    },
    confirmRequest(state, token) {
        state.status = { confirmRequest: true };
    },
    confirmSuccess(state, token) {
        state.status = {};
    },
    confirmFailure(state, token) {
        state.status = {};
    },
};

const auth = {
    namespaced : true,
    state,
    actions,
    mutations
}

export default auth