import * as types from './mutation-types';

export default {
    addToWishlist: function ( { commit }, payload ) {
        commit( types.ADD_TO_WISHLIST, payload );
        window.Vue.$vToastify.setSettings( {
            withBackdrop: false,
            position: "top-right",
            successDuration: 1500,
        } );
        window.Vue.$vToastify.success( "Product added to wishlist" );
    },
    removeFromWishlist: function ( { commit }, payload ) {
        commit( types.REMOVE_FROM_WISHLIST, payload );
        window.Vue.$vToastify.setSettings( {
            withBackdrop: false,
            position: "top-right",
            successDuration: 1500,
        } );
        window.Vue.$vToastify.success( "Product removed from wishlist" );
    },
}