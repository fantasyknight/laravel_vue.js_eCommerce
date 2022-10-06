/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require( './bootstrap' );

window.Vue = require( 'vue' );

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// importing vue modules
import VueToastify from 'vue-toastify';
import { Tabs, Tab } from 'vue-tabs-component';
import VModal from 'vue-js-modal';
import VueLazyLoad from 'vue-lazyload';
import VueRouter from 'vue-router';
import VueNouislider from 'vue-nouislider'
import AnimatedVue from 'animated-vue';
import Notifications from 'vue-notification';

// import store
import store from './store';

// import App
import App from './App.vue';

// import router
import router from './router';

import animate from './animate';

Vue.use( VueToastify );
Vue.use( VModal );
Vue.use( VueLazyLoad, {
    lazyComponent: true,
    adapter: {
        loaded ( { bindType, el } ) {
            if ( el.nodeName == 'IMG' ) {
                // el.addEventListener( 'load', function () {

                el.style.paddingTop = '0';
                let children = el.parentElement.children;
                for ( let i = 0; i < children.length; i++ ) {
                    if ( el == children[ i ] && i == 1 ) return;
                }
                el.classList.add( 'fade-in' );
                // }, { once: true } )
            }
        },
        loading ( listener, Init ) {
            if ( !listener.el.style.paddingTop ) {
                var padding = 100;
                var ratio = listener.el.getAttribute( 'ratio' );

                if ( ratio ) {
                    padding = ratio;
                } else if ( listener.el.getAttribute( 'width' ) && listener.el.getAttribute( 'height' ) )
                    padding = listener.el.getAttribute( 'height' ) / listener.el.getAttribute( 'width' ) * 100;
                if ( listener.el.nodeName == 'IMG' && !listener.el.classList.contains( 'vue-lb-modal-image' ) )
                    listener.el.style.paddingTop = padding + '%';
            }
        },
    }
} );

Vue.use( VueRouter );
Vue.use( Notifications );
Vue.use( VueNouislider );
Vue.use( AnimatedVue );

Vue.component( 'tabs', Tabs );
Vue.component( 'tab', Tab );

Vue.directive( 'animate', animate );

window.VueApp = new Vue( {
    methods: {
        getUrl: function ( url, flag = false, size = 0 ) {
            if ( flag ) {
                if ( size == 0 )
                    return window.baseUrl + '/storage/' + url;
                else {
                    var splits = url.split( '.' );
                    return window.baseUrl + '/storage/' + splits[ 0 ] + '-' + size + 'x' + size + '.' + splits[ 1 ];
                }
            }

            return window.baseUrl + '/' + url;
        }
    },
    router,
    store,
    render: h => h( App ),
} ).$mount( '#app' );