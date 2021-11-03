import Vue from "vue";
import Vuex from "vuex";
import Axios from "axios";

Axios.defaults.withCredentials = true;

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: ''
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
    },
    mutations: {
        auth_request(state) {
          state.status = 'success'
        },
        logout(state) {
            state.status = ''
            state.token = ''
        },
        ser_user(state, user) {
            state.user = user;
        }
    },
    actions: {
        //
        async login({ dispatch }, user) {
            await Axios.post("/api/oauth/tokenweb",{
                    username: user.email,
                    password: user.password,
                    client_secret: "gRkm3DmM8DNwhDS5l7UYkUMkJiFa4tgRYgviMRVf",
                    client_id: "90ef3f03-b692-496e-9240-c6486e4c8c51",
                    grant_type: "password",
            }).then((response) => {
                /*if(response.message){
                    return dispatch(response);
                }
                else {*/
                    localStorage.setItem(
                        'token',
                        response.data.access_token,
                    )
                    return dispatch("getUser");
                //}
                
            })
        },
        /*async loginweb({ dispatch }, user) {
            await Axios.post("/api/oauth/tokenweb",{
                    username: user.email,
                    password: user.password,
                    client_secret: "gRkm3DmM8DNwhDS5l7UYkUMkJiFa4tgRYgviMRVf",
                    client_id: "90ef3f03-b692-496e-9240-c6486e4c8c51",
                    grant_type: "password",
            }).then((response) => {
                localStorage.setItem(
                    'token',
                    response.data.access_token,
                )
                return dispatch("getUser");
            })
        },*/
        async getUser({ commit }) {
            await Axios
                .get("/api/user", {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(res => {
                    console.log(res.data.roles.opcmenu);
                    sessionStorage.setItem('opcmenu',res.data.roles.opcmenu);
                    commit("ser_user", res.data);
                })
                .catch(() => {
                    commit("ser_user", null);
                });
        },
        logout({commit}) {
            return new Promise((resolve) => {
                commit('logout')
                localStorage.removeItem('token')
                delete Axios.defaults.headers.common['Authorization']
                resolve()
            })
        }
    },
    modules: {},
});
