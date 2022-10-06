import * as types from './mutation-types';

export default {
    [ types.SET_USER ] ( state, payload ) {
        state.data = { ...payload.user }
    },

    [ types.LOGOUT ] ( state ) {
        state.data = {};
    }
}