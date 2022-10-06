import { ADD_TO_CART, REMOVE_FROM_CART, REMOVE_COUPON, SET_COUPONS, UPDATE_CART_WITH_CALC } from './mutation-types';

export default {
    addToCart: function ( { commit, getters, rootGetters }, payload ) {
        if ( !getters.canAddToCart( payload.product, payload.qty ) ) {
            window.Vue.$vToastify.removeToast();
            window.Vue.$vToastify.setSettings( {
                withBackdrop: false,
                position: "top-right",
                errorDuration: 2000
            } );
            window.Vue.$vToastify.error( "Sorry, you can't add that amount to the cart. You already have enough stock in the cart or amount is too large." );
            return;
        }

        commit( ADD_TO_CART, payload );

        if ( rootGetters[ 'setting/getAllSetting' ].cart_popup_type === 'CartModalOneComponent' ) {
            window.Vue.$vToastify.setSettings( {
                withBackdrop: false,
                position: "top-right",
                successDuration: 1500,
            } );
            window.Vue.$vToastify.success( "Product added to cart" );
        } else {
            this._vm.$notify( {
                group: 'addCartSuccess',
                text: `has been added to your cart!`,
                data: payload.product
            } );
        }
    },
    removeFromCart: function ( { commit }, payload ) {
        commit( REMOVE_FROM_CART, payload );
        window.Vue.$vToastify.setSettings( {
            withBackdrop: false,
            position: "top-right",
            successDuration: 1500,
        } );
        window.Vue.$vToastify.success( "Product removed from cart" );
    },
    addCoupon: async function ( { dispatch, getters }, coupon ) {
        if ( getters.couponAlreadyApplied( coupon ) ) {
            window.Vue.$vToastify.removeToast();
            window.Vue.$vToastify.setSettings( {
                withBackdrop: false,
                position: "top-right",
                errorDuration: 2000
            } );
            window.Vue.$vToastify.error( "This coupon has already been applied." );
            return false;
        }

        const results = await dispatch( 'calcCartItems', coupon );
        return results;
    },
    removeCoupon: async function ( { commit, dispatch }, coupon ) {
        commit( REMOVE_COUPON, {
            coupon: coupon
        } );
        const results = await dispatch( 'calcCartItems' );
        return results;
    },
    calcCartItems: async function ( { commit, getters, rootGetters }, coupon = null ) {
        let shippingMethods = [];
        let paymentMethods = [];
        let errorMsg = [];

        await window.axios.post( '/web/shipping-tax-info', {
            items: getters.cartlistIdQtyName,
            applied_coupons: getters.appliedCouponCodes,
            new_coupon: coupon,
            customer: rootGetters[ 'user/isCustomer' ] ? rootGetters[ 'user/getUser' ].email : null,
            shipping: getters.shippingAddress,
            billing: getters.billingAddress
        } ).then( response => {
            shippingMethods = response.data.shipping_methods;
            paymentMethods = response.data.pay_tms;
            errorMsg = JSON.parse( response.data.error_msg );
            commit( SET_COUPONS, {
                coupons: response.data.coupons
            } );
            commit( UPDATE_CART_WITH_CALC, {
                items: response.data.items
            } );
        } ).catch( error => {
            errorMsg = error.response.data.message.split( '/Product-Error/' );
        } );
        return {
            shipping: shippingMethods,
            payment: paymentMethods,
            errorMsg: errorMsg
        };
    }
}