import mutations from './mutations';
import getters from './getters';
import actions from './actions';

function getState ( key ) {
    let initialState = {
        data: [],
        coupons: [],
        shipping: {
            streetAddress1: '',
            streetAddress2: '',
            city: '',
            country: '',
            state: '',
            zip: ''
        },
        billing: {
            streetAddress1: '',
            streetAddress2: '',
            city: '',
            country: '',
            state: '',
            zip: '',
            email: ''
        }
    };

    return ( localStorage.getItem( key ) && JSON.parse( localStorage.getItem( key ) ).cart ) ?
        JSON.parse( localStorage.getItem( key ) ).cart
        : initialState;
}

export default {
    namespaced: true,

    state: () => (
        getState( 'porto-single' )
    ),

    mutations: mutations,

    getters: getters,

    actions: actions
}