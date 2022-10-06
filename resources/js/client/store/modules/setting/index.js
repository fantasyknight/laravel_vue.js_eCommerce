import mutations from './mutations';
import getters from './getters';

function getState ( key ) {
    let initialState = {
        data: {},
        newsletterShow: true,
    };

    return ( localStorage.getItem( key ) && JSON.parse( localStorage.getItem( key ) ).setting ) ?
        JSON.parse( localStorage.getItem( key ) ).setting
        : initialState;
}

export default {
    namespaced: true,

    state: () => (
        getState( 'porto-single' )
    ),

    mutations: mutations,

    getters: getters
}