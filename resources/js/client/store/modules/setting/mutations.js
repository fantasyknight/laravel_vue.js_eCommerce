import * as types from './mutation-types';

export default {
    [ types.NEWSLETTER_NOT_SHOW ] ( state ) {
        state.newsletterShow = false;
    },

    [ types.SET_SETTINGS ] ( state, payload ) {
        state.data = payload.settings;
    },

    [ types.SET_THEME_SETTINGS ] ( state, payload ) {
        state.data = Object.assign( {}, state.data, payload.settings );
    }
}