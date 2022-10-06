export default {
    cartList: state => {
        return state.data;
    },
    priceTotal: state => {
        return state.data.reduce( ( acc, cur ) => {
            return acc + cur.sum;
        }, 0 );
    },
    taxTotal: state => {
        return state.data.reduce( ( acc, cur ) => {
            return acc + cur.tax_amount;
        }, 0 )
    },
    qtyTotal: state => {
        return state.data.reduce( ( acc, cur ) => {
            return acc + parseInt( cur.qty, 10 );
        }, 0 );
    },
    isInCart: state => ( product ) => {
        return state.data.find( item => item.id == product.id ) ? true : false;
    },
    appliedCoupons: state => {
        return state.coupons;
    },
    appliedCartCoupons: state => {
        return state.coupons.filter( item => item.cart );
    },
    appliedCouponCodes: state => {
        return state.coupons.reduce( ( acc, cur ) => {
            acc.push( cur.code );
            return acc;
        }, [] );
    },
    cartlistOnlyIdQty: state => {
        return state.data.reduce( ( acc, cur ) => {
            acc.push( {
                id: cur.id,
                qty: cur.qty
            } );
            return acc;
        }, [] );
    },
    cartlistIdQtyName: state => {
        return state.data.reduce( ( acc, cur ) => {
            acc.push( {
                id: cur.id,
                qty: cur.qty,
                name: cur.name,
                parent_id: cur.parent_id
            } );
            return acc;
        }, [] );
    },
    couponAlreadyApplied: state => ( coupon ) => {
        return state.coupons.find( item => item.code === coupon ) ? true : false;
    },
    couponAmount: state => {
        return state.coupons.reduce( ( acc, cur ) => {
            return acc + cur.amount;
        }, 0 );
    },
    couponTax: state => {
        return state.coupons.reduce( ( acc, cur ) => {
            return acc + cur.tax;
        }, 0 );
    },
    shippingAddress: state => {
        return state.shipping;
    },
    billingAddress: state => {
        return state.billing;
    },
    shippingAddressExists: state => {
        return Object.values( state.shipping ).findIndex( value => value !== '' ) > -1;
    },
    getCartById: state => ( id ) => {
        return state.data.find( product => product.id == id );
    },
    canAddToCart: state => ( product, qty = 1 ) => {
        if ( product.stock_status == 'on-backorder' ) return true;
        var find = state.data.find( item => item.id == product.id );

        if ( find ) {
            if ( ( product.manage_stock && product.stock_quantity < ( find.qty + qty ) ) || ( !product.manage_stock && product.stock_status == 'out-of-stock' ) )
                return false;
            else if ( product.sold_individually && ( find.qty >= 1 || qty > 1 ) ) {
                return false;
            } else return true;
        } else {
            if ( ( product.manage_stock && ( product.stock_quantity <= 0 || qty > product.stock_quantity ) ) || ( !product.manage_stock && product.stock_status == 'out-of-stock' ) || ( product.sold_individually && qty > 1 ) )
                return false;
            else return true;
        }
    }
}