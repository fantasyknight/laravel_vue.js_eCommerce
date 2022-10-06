import * as types from './mutation-types';

export default {
    [ types.ADD_TO_CART ] ( state, payload ) {
        var findIndex = state.data.findIndex( item => item.id === payload.product.id )
        if ( findIndex !== -1 && payload.product.parent !== 0 ) {
            findIndex = state.data.findIndex( item => {
                return item.id == payload.product.id && JSON.stringify( item.excerpts ) == JSON.stringify( payload.product.excerpts );
            } );
        }
        if ( findIndex !== -1 ) {
            state.data = state.data.reduce( ( acc, product, index ) => {
                if ( findIndex == index ) {
                    acc.push( {
                        ...product,
                        qty: product.qty + payload.qty,
                        sum: product.min_max_price[ 0 ] * ( product.qty + payload.qty )
                    } );
                } else {
                    acc.push( product );
                }
                return acc;
            }, [] );
        } else {
            state.data = [
                ...state.data,
                {
                    type: payload.product.type,
                    id: payload.product.id,
                    name: payload.product.name,
                    slug: payload.product.slug,
                    min_max_price: payload.product.min_max_price,
                    manage_stock: payload.product.manage_stock,
                    stock_quantity: payload.product.stock_quantity,
                    stock_status: payload.product.stock_status,
                    parent_id: payload.product.parent_id ? payload.product.parent_id : payload.product.parent == 0 ? payload.product.id : payload.product.parent,
                    excerpts: payload.product.excerpts,
                    media: payload.product.media,
                    qty: payload.qty,
                    sum: payload.product.min_max_price[ 0 ] * payload.qty,
                    coupon_amount: 0,
                    tax_amount: 0,
                    shipping_amount: 0,
                    shipping_tax_amount: 0
                }
            ];
        }
    },

    [ types.REMOVE_FROM_CART ] ( state, payload ) {
        state.data = state.data.filter( item => {
            if ( item.id !== payload.product.id ) return true;
            if ( JSON.stringify( item.excerpts ) !== JSON.stringify( payload.product.excerpts ) ) return true;
            return false;
        } );
    },

    [ types.UPDATE_CART ] ( state, payload ) {
        state.data = payload.cartItems;
    },

    [ types.CLEAR_CART ] ( state ) {
        state.data = [];
        state.coupons = [];
    },

    [ types.SET_COUPONS ] ( state, payload ) {
        state.coupons = payload.coupons ? payload.coupons : [];
    },

    [ types.ADD_COUPON ] ( state, payload ) {
        state.coupons.push( payload.coupon );
    },

    [ types.REMOVE_COUPON ] ( state, payload ) {
        state.coupons = state.coupons.reduce( ( acc, cur ) => {
            if ( cur.code !== payload.coupon ) {
                acc.push( cur );
            }
            return acc;
        }, [] );
    },

    [ types.UPDATE_CART_WITH_CALC ] ( state, payload ) {
        state.data = state.data.reduce( ( acc, cur, index ) => {
            acc.push( {
                ...cur,
                sum: payload.items[ index ].sum,
                coupon_amount: payload.items[ index ].coupon_amount,
                tax_amount: payload.items[ index ].tax_amount
            } );
            return acc;
        }, [] );
    },

    [ types.UPDATE_SHIPPING_ADDRESS ] ( state, payload ) {
        state.shipping = {
            ...state.shipping,
            city: payload.shippingInfo.city,
            country: payload.shippingInfo.country,
            state: payload.shippingInfo.state,
            zip: payload.shippingInfo.zip
        };
    },

    [ types.UPDATE_BILLING_ADDRESS ] ( state, payload ) {
        state.billing = {
            streetAddress1: payload.billingInfo.streetAddress1,
            streetAddress2: payload.billingInfo.streetAddress2,
            city: payload.billingInfo.city,
            country: payload.billingInfo.country,
            state: payload.billingInfo.state,
            zip: payload.billingInfo.zip,
            email: payload.billingInfo.email
        };
    }
}