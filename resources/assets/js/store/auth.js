import axios from 'axios';

export default {
    state: {
        user: null
    },
    getters: {
        auth (state) {
            const user = state.user;
            return {
                id: (user ? user.id : null),
                user,
                check: (user !== null),
                guest: (user === null)
            };
        }
    },
    mutations: {
        setUser: (state, user) => (state.user = user),
        removeUser: (state) => (state.user = null),
        setToken: (state, token) => window.storage.set('auth.token', token),
        removeToken: () => window.storage.remove('auth.token')
    },
    actions: {
        login ({ commit }, payload) {
            commit('setUser', payload.user);
            commit('setToken', payload.token);
        },
        logout ({ commit }) {
            commit('removeUser');
            commit('removeToken');
        },
        fetchAuthUser ({ commit }) {
            return window.storage.has('auth.token')
                ? axios.get('/user').then(({ data }) => commit('setUser', data))
                : Promise.resolve();
        }
    }
};
