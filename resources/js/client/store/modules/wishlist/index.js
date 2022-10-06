import mutations from './mutations';
import getters from './getters';
import actions from './actions';

function getState ( key ) {
    let initialState = {
        data: []
    };

    return ( localStorage.getItem( key ) && JSON.parse( localStorage.getItem( key ) ).wishlist ) ?
        JSON.parse( localStorage.getItem( key ) ).wishlist
        : initialState;
}

export default {
    namespaced: true,

    state: () => (
        getState( 'porto-single' )
    ),

    actions: actions,

    mutations: mutations,

    getters: getters,
}