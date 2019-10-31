import PostAPI from "../api/post";

const CREATING_POST = "CREATING_POST",
  CREATING_POST_SUCCESS = "CREATING_POST_SUCCESS",
  CREATING_POST_ERROR = "CREATING_POST_ERROR",
  FETCHING_POSTS = "FETCHING_POSTS",
  FETCHING_POSTS_SUCCESS = "FETCHING_POSTS_SUCCESS",
  FETCHING_POSTS_ERROR = "FETCHING_POSTS_ERROR";

export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    posts: [],
    backend_host: '',
    backend_build_time: '',
    web_host: ''
  },
  getters: {
    isLoading(state) {
      return state.isLoading;
    },
    hasError(state) {
      return state.error !== null;
    },
    error(state) {
      return state.error;
    },
    hasPosts(state) {
      return state.posts.length > 0;
    },
    posts(state) {
      return state.posts;
    },
    backend_host(state) {
      return state.backend_host;
    },
    backend_build_time(state) {
      return state.backend_build_time;
    },
    web_host(state) {
      return state.web_host;
    }
  },
  mutations: {
    [CREATING_POST](state) {
      state.isLoading = true;
      state.error = null;
    },
    [CREATING_POST_SUCCESS](state, post) {
      state.isLoading = false;
      state.error = null;
      state.posts.unshift(post);
    },
    [CREATING_POST_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.posts = [];
    },
    [FETCHING_POSTS](state) {
      state.isLoading = true;
      state.error = null;
      state.posts = [];
    },
    [FETCHING_POSTS_SUCCESS](state, data) {
      state.isLoading = false;
      state.error = null;
      state.posts = data.posts;
      state.backend_host = data.backend_host;
      state.backend_build_time=data.backend_build_time;
      state.web_host = data.web_host;
    },
    [FETCHING_POSTS_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.posts = [];
    }
  },
  actions: {
    async create({ commit }, message) {
      commit(CREATING_POST);
      try {
        let response = await PostAPI.create(message);
        commit(CREATING_POST_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(CREATING_POST_ERROR, error);
        return null;
      }
    },
    async findAll({ commit }) {
      commit(FETCHING_POSTS);
      try {
        let response = await PostAPI.findAll();
        commit(FETCHING_POSTS_SUCCESS, response.data);
        return response.data.posts;
      } catch (error) {
        commit(FETCHING_POSTS_ERROR, error);
        return null;
      }
    }
  }
};
