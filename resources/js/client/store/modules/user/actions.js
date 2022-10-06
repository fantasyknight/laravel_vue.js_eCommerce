import { SET_USER } from './mutation-types';
import { LOGOUT } from './mutation-types';

export default {
    login: async function ( { commit }, payload ) {
        window.Vue.$vToastify.removeToast();
        window.Vue.$vToastify.setSettings( {
            withBackdrop: true,
            position: "center-center",
        } );
        window.Vue.$vToastify.loader( "Please wait..." );
        let success = false;
        await window.axios
            .post( "/login", {
                email: payload.email,
                password: payload.password,
            } )
            .then( ( response ) => {
                window.location.reload();
            } )
            .catch( ( error ) => {
                window.Vue.$vToastify.stopLoader();
                window.Vue.$vToastify.setSettings( {
                    withBackdrop: false,
                    position: "top-right",
                    errorDuration: 1500,
                } );
                window.Vue.$vToastify.error( error.response.data.message );
            } );
        return success;
    },
    register: async function ( { commit }, payload ) {
        window.Vue.$vToastify.removeToast();
        window.Vue.$vToastify.setSettings( {
            withBackdrop: true,
            position: "center-center",
        } );
        window.Vue.$vToastify.loader( "Please wait..." );

        let success = false;
        await window.axios
            .post( "/register", {
                email: payload.email,
                password: payload.password,
                role: payload.role,
                first_name: payload.firstName,
                last_name: payload.lastName,
                country: payload.country,
                state: payload.state,
                store_name: payload.storeName,
                city: payload.city,
                paypal_email: payload.paypalEmail,
                street: payload.street,
                phone: payload.phone
            } )
            .then( ( response ) => {
                window.location.reload();
            } )
            .catch( ( error ) => {
                window.Vue.$vToastify.stopLoader();
                window.Vue.$vToastify.setSettings( {
                    withBackdrop: false,
                    position: "top-right",
                    errorDuration: 1500,
                } );
                window.Vue.$vToastify.error( error.response.data.message );
            } );
        return success;
    },
    logout: async function ( { commit }, ) {
        window.Vue.$vToastify.removeToast();
        window.Vue.$vToastify.setSettings( {
            withBackdrop: true,
            position: "center-center",
        } );
        window.Vue.$vToastify.loader( "Please wait..." );
        let success = false;
        await window.axios
            .post( "/logout" )
            .then( ( response ) => {
                commit( LOGOUT, {} );
                success = true;
            } )
            .catch( ( error ) => {
                window.Vue.$vToastify.stopLoader();
                window.Vue.$vToastify.setSettings( {
                    withBackdrop: false,
                    position: "top-right",
                    errorDuration: 1500,
                } );
                window.Vue.$vToastify.error( error.response.data.message );
            } );
        return success;
    },
    setUser: async function ( { commit }, payload ) {
        window.Vue.$vToastify.removeToast();
        window.Vue.$vToastify.setSettings( {
            withBackdrop: true,
            position: "center-center",
        } );
        window.Vue.$vToastify.loader( "Please wait..." );
        await window.axios
            .put( "/web/account-detail", {
                id: payload.id,
                first_name: payload.firstName,
                last_name: payload.lastName,
                email: payload.email,
                password: payload.pwdCurrent,
                new_password: payload.pwdNew,
                new_password_confirmation: payload.pwdConfirm,
            } )
            .then( ( response ) => {
                window.Vue.$vToastify.stopLoader();
                window.Vue.$vToastify.setSettings( {
                    withBackdrop: false,
                    position: "top-right",
                    successDuration: 1000,
                } );
                window.Vue.$vToastify.success( "Customer data saved" );
                commit( SET_USER, { user: response.data } );
            } )
            .catch( ( error ) => {
                window.Vue.$vToastify.stopLoader();
                window.Vue.$vToastify.setSettings( {
                    withBackdrop: false,
                    position: "top-right",
                    errorDuration: 1500,
                } );
                window.Vue.$vToastify.error( error.response.data.message );
            } );
    }
};