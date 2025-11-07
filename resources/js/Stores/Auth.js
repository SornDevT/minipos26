
import { defineStore } from 'pinia';
export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user')) || null,
        token: localStorage.getItem('token') || null,
        // token: "hshgu35365erhg4564er6g84re86ger",
    }),
    getters: {
        isAuthenticated: (state) => !!state.token, // ຖ້າມີ true, ບໍ່ມີ false
        getUser: (state) => state.user,
        getToken: (state) => state.token,
    },
    actions: {
        setToken(token) {
            this.token = token;
            localStorage.setItem('token', token);
        },
        setUser(user) {
            this.user = user;
            localStorage.setItem('user', JSON.stringify(user));
        },
        logout() {
            this.token = null;
            this.user = null;
            localStorage.removeItem('token');
            localStorage.removeItem('user');
        },
    },

});