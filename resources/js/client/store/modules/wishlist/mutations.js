import * as types from './mutation-types';

export default {
    [ types.ADD_TO_WISHLIST ] ( state, payload ) {
        var findIndex = state.data.findIndex( item => item.id === payload.product.id );
        if ( findIndex == -1 ) {
            state.data = [
                ...state.data,
                payload.product
            ];
        }
    },

    [ types.REMOVE_FROM_WISHLIST ] ( state, payload ) {
        state.data = state.data.filter( item => item.id !== payload.product.id );
    }
}