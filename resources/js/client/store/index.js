import Vue from 'vue';
import Vuex from 'vuex';
import cartModule from './modules/cart';
import wishlistModule from './modules/wishlist';
import userModule from './modules/user';
import settingModule from './modules/setting';
import plugins from './plugins/storage';

Vue.use( Vuex );

export default new Vuex.Store( {
    modules: {
        cart: cartModule,
        wishlist: wishlistModule,
        user: userModule,
        setting: settingModule
    },
    plugins
} );
