export default {
    wishlist: state => {
        return state.data;
    },
    wishlistQty: state => {
        return state.data.length;
    },
    isInWishlist: state => ( product ) => {
        return state.data.find( item => item.id == product.id ) ? true : false
    }
}