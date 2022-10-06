import mutations from './mutations';
import getters from './getters';
import actions from './actions';

function getCookieAttr ( attribute ) {
    var attr = attribute + "="; // create an attribute string
    var parts = document.cookie.split( ';' ); // split the cookie into parts
    for ( var i = 0; i < parts.length; i++ ) { // loop through the parts for each item
        var item = parts[ i ];
        while ( item.charAt( 0 ) == ' ' ) { // account for spaces in the cookie
            item = item.substring( 1 ); // set the item
        }
        if ( item.indexOf( attr ) == 0 ) { // if the item matches the attribute
            return item.substring( attr.length, item.length ); // return the value
        }
    }
    return "";
}

function getState ( key ) {
    let initialState = {
        data: {},
        token: null
    };

    let user = JSON.parse( getCookieAttr( key ) );

    return user && user.id ?
        {
            data: user,
            token: null
        }
        : initialState;
}

export default {
    namespaced: true,

    state: () => (
        getState( 'porto-single-user' )
    ),

    mutations: mutations,

    getters: getters,

    actions: actions
}