import User from '@/util/User';

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
        setUser: (state, user) => (state.user = new User(user)),
        removeUser: (state) => (state.user = null),
        setToken: (state, token) => window.store.set('auth.token', token),
        removeToken: () => window.store.remove('auth.token')
    },
    actions: {
        login ({ commit }, payload) {
            commit('setUser', payload.user);
            commit('setToken', payload.token);
        },
        logout ({ commit }) {
            commit('removeUser');
            commit('removeToken');
        }
    }
};
