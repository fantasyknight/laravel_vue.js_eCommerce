<template>
    <div class="page-wrapper">
        <transition
            name="fade"
            mode="out-in"
        >
            <keep-alive>
                <component
                    :is="header"
                    v-bind="{ categories: categories }"
                ></component>
            </keep-alive>
        </transition>
        <router-view></router-view>
        <transition
            name="fade"
            mode="out-in"
        >
            <keep-alive>
                <component
                    :is="footer"
                    v-bind="{ tags: tags }"
                ></component>
            </keep-alive>
        </transition>
        <div
            class="mobile-menu-overlay"
            @click.prevent="hideMobileMenu"
        ></div>
        <mobile-menu-component></mobile-menu-component>
        <sticky-navbar-component :class="{ fixed: showStickyNavbar }"></sticky-navbar-component>

        <cart-modal-two-component></cart-modal-two-component>

        <a
            :class="{ fixed: showScrollTop }"
            id="scroll-top"
            href="#top"
            title="Top"
            role="button"
            @click.prevent="scrollTop"
        >
            <i class="icon-angle-up"></i>
        </a>
    </div>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";

import MobileMenuComponent from "./components/shared/MobileMenuComponent";
import StickyNavbarComponent from "./components/shared/StickyNavbarComponent";
import HeaderOneComponent from "./components/shared/headers/HeaderOneComponent";
import CartModalTwoComponent from "./components/shared/modals/CartModalTwoComponent";

function loadHeader ( name ) {
    return () =>
        import( `./components/shared/headers/${ name }.vue` ).then(
            ( m ) => m.default || m
        );
}

function loadFooter ( name ) {
    return () =>
        import( `./components/shared/footers/${ name }.vue` ).then(
            ( m ) => m.default || m
        );
}

function getRGBValue ( value ) {
    value = value.slice( 1 );
    let result = [];
    let length = value.length;
    let unit = length / 3;
    let valueStr;

    for ( let i = 0; i < 4 && i * unit < length; i++ ) {
        valueStr = value.substr( i * unit, unit ).repeat( 2 / unit );
        if ( i < 3 ) {
            result.push( parseInt( valueStr, 16 ) );
        } else {
            result.push( ( parseInt( valueStr, 16 ) / 255 ).toFixed( 2 ) );
        }
    }
    return result;
}

function _color_rgb2hsl ( $rgb ) {
    let $r = $rgb[ 0 ] / 255;
    let $g = $rgb[ 1 ] / 255;
    let $b = $rgb[ 2 ] / 255;
    let $min = Math.min( $r, $g, $b );
    let $max = Math.max( $r, $g, $b );
    let $delta = $max - $min;
    let $l = ( $min + $max ) / 2;
    let $s = 0;
    let $h = 0;
    if ( $l > 0 && $l < 1 ) {
        $s = $delta / ( $l < 0.5 ? 2 * $l : 2 - 2 * $l );
    }
    if ( $delta > 0 ) {
        if ( $max == $r && $max != $g ) $h += ( $g - $b ) / $delta;
        if ( $max == $g && $max != $b ) $h += 2 + ( $b - $r ) / $delta;
        if ( $max == $b && $max != $r ) $h += 4 + ( $r - $g ) / $delta;
        $h /= 6;
    }
    return [ $h * 360, $s * 100, $l * 100 ];
}

function getChangedColor ( color, offset ) {
    var hsl = _color_rgb2hsl( color );
    return "hsl(" + hsl[ 0 ] + ", " + hsl[ 1 ] + "%, " + ( hsl[ 2 ] + offset ) + "%)";
}

export default {
    components: {
        MobileMenuComponent,
        StickyNavbarComponent,
        CartModalTwoComponent
    },
    data () {
        return {
            tags: [],
            categories: [],
            showScrollTop: false,
            showStickyNavbar: false,
        };
    },
    computed: {
        header: function () {
            if ( this.getSetting( "header_type" ) ) {
                return loadHeader( this.getSetting( "header_type" ) );
            } else {
                return HeaderOneComponent;
            }
        },
        footer: function () {
            return (
                this.getSetting( "footer_type" ) &&
                loadFooter( this.getSetting( "footer_type" ) )
            );
        },
        ...mapGetters( "setting", [ "getSetting", "getColorSettings", "getTypographySettings" ] ),
    },
    watch: {
        getColorSettings: function () {
            this.changeCssVariables();
        },
        getTypographySettings: function () {
            this.changeTypographyStyle();
        },
        $route: function () {
            document.querySelector( 'body' ).classList.remove( 'cart-opened' );
        }
    },
    created: async function () {
        await window.axios.get( "/web/initial-data" ).then( ( response ) => {
            this.tags = response.data.tags;
            this.categories = response.data.categories;
            this.setSettings( { settings: response.data.settings } );
        } );

        this.changeCssVariables();
        this.changeTypographyStyle();

        window.addEventListener( "scroll", this.scrollEvent, { passive: true } );
    },
    beforeDestroy: function () {
        window.removeEventListener( "scroll", this.scrollEvent );
    },
    methods: {
        ...mapMutations( "setting", {
            setSettings: "SET_SETTINGS",
        } ),
        hideMobileMenu: function () {
            document.querySelector( "body" ).classList.remove( "mmenu-active" );
        },
        scrollEvent: function () {
            if ( window.pageYOffset >= 400 && window.innerWidth >= 576 )
                this.showScrollTop = true;
            else this.showScrollTop = false;
            if ( window.pageYOffset > 0 && window.innerWidth < 576 ) {
                this.showStickyNavbar = true;
            } else {
                this.showStickyNavbar = false;
            }
        },
        scrollTop: function () {
            window.scrollTo( {
                top: 0,
                behavior: "smooth",
            } );
        },
        changeCssVariables: function () {
            let body = document.querySelector( "body" );
            let primaryColor = getRGBValue( this.getColorSettings.primary );
            let primaryColorDark = getRGBValue(
                this.getColorSettings.primaryDark
            );

            body.style.setProperty(
                "--primary-color",
                this.getColorSettings.primary
            );
            body.style.setProperty(
                "--primary-color-dark",
                this.getColorSettings.primaryDark
            );
            body.style.setProperty(
                "--secondary-color",
                this.getColorSettings.secondary
            );
            body.style.setProperty(
                "--secondary-color-dark",
                this.getColorSettings.secondaryDark
            );
            body.style.setProperty( "--body-text", this.getColorSettings.body );
            body.style.setProperty(
                "--headings-text",
                this.getColorSettings.headings
            );
            body.style.setProperty(
                "--hot-label-color",
                this.getColorSettings.hotLabel
            );
            body.style.setProperty(
                "--new-label-color",
                this.getColorSettings.newLabel
            );
            body.style.setProperty(
                "--sale-label-color",
                this.getColorSettings.saleLabel
            );

            // Generate Lighten and darken colors for buttons and author link.
            body.style.setProperty(
                "--btn-primary-hover",
                getChangedColor( primaryColor, 8 )
            );
            body.style.setProperty(
                "--btn-primary-active-bg",
                getChangedColor( primaryColor, -10 )
            );
            body.style.setProperty(
                "--btn-primary-active-border",
                getChangedColor( primaryColor, -12.5 )
            );
            body.style.setProperty(
                "--btn-dark-hover",
                getChangedColor( primaryColorDark, 8 )
            );
            body.style.setProperty(
                "--btn-dark-active-bg",
                getChangedColor( primaryColorDark, -10 )
            );
            body.style.setProperty(
                "--btn-dark-active-border",
                getChangedColor( primaryColorDark, -12.5 )
            );
            body.style.setProperty(
                "--post-author-hover-color",
                getChangedColor( primaryColor, 5 )
            );
        },
        changeTypographyStyle: function () {
            var css = '';
            css += 'h1 {' + this.addTypography( 'font-family', this.getTypographySettings.h1FontFamily )
                + this.addTypography( 'font-weight', this.getTypographySettings.h1FontWeight )
                + this.addTypography( 'color', this.getTypographySettings.h1Color )
                + this.addTypography( 'padding-top', this.getTypographySettings.h1PaddingTop )
                + this.addTypography( 'padding-right', this.getTypographySettings.h1PaddingRight )
                + this.addTypography( 'padding-left', this.getTypographySettings.h1PaddingLeft )
                + this.addTypography( 'padding-bottom', this.getTypographySettings.h1PaddingBottom )
                + this.addTypography( 'margin-top', this.getTypographySettings.h1MarginTop )
                + this.addTypography( 'margin-right', this.getTypographySettings.h1MarginRight )
                + this.addTypography( 'margin-left', this.getTypographySettings.h1MarginLeft )
                + this.addTypography( 'margin-bottom', this.getTypographySettings.h1MarginBottom )
                + this.addTypography( 'line-height', this.getTypographySettings.h1LineHeight )
                + this.addTypography( 'letter-spacing', this.getTypographySettings.h1LetterSpacing )
                + '}';

            css += 'h2 {' + this.addTypography( 'font-family', this.getTypographySettings.h2FontFamily )
                + this.addTypography( 'font-weight', this.getTypographySettings.h2FontWeight )
                + this.addTypography( 'color', this.getTypographySettings.h2Color )
                + this.addTypography( 'padding-top', this.getTypographySettings.h2PaddingTop )
                + this.addTypography( 'padding-right', this.getTypographySettings.h2PaddingRight )
                + this.addTypography( 'padding-left', this.getTypographySettings.h2PaddingLeft )
                + this.addTypography( 'padding-bottom', this.getTypographySettings.h2PaddingBottom )
                + this.addTypography( 'margin-top', this.getTypographySettings.h2MarginTop )
                + this.addTypography( 'margin-right', this.getTypographySettings.h2MarginRight )
                + this.addTypography( 'margin-left', this.getTypographySettings.h2MarginLeft )
                + this.addTypography( 'margin-bottom', this.getTypographySettings.h2MarginBottom )
                + this.addTypography( 'line-height', this.getTypographySettings.h2LineHeight )
                + this.addTypography( 'letter-spacing', this.getTypographySettings.h2LetterSpacing )
                + '}';

            css += 'h3 {' + this.addTypography( 'font-family', this.getTypographySettings.h3FontFamily )
                + this.addTypography( 'font-weight', this.getTypographySettings.h3FontWeight )
                + this.addTypography( 'color', this.getTypographySettings.h3Color )
                + this.addTypography( 'padding-top', this.getTypographySettings.h3PaddingTop )
                + this.addTypography( 'padding-right', this.getTypographySettings.h3PaddingRight )
                + this.addTypography( 'padding-left', this.getTypographySettings.h3PaddingLeft )
                + this.addTypography( 'padding-bottom', this.getTypographySettings.h3PaddingBottom )
                + this.addTypography( 'margin-top', this.getTypographySettings.h3MarginTop )
                + this.addTypography( 'margin-right', this.getTypographySettings.h3MarginRight )
                + this.addTypography( 'margin-left', this.getTypographySettings.h3MarginLeft )
                + this.addTypography( 'margin-bottom', this.getTypographySettings.h3MarginBottom )
                + this.addTypography( 'line-height', this.getTypographySettings.h3LineHeight )
                + this.addTypography( 'letter-spacing', this.getTypographySettings.h3LetterSpacing )
                + '}';

            css += 'h4 {' + this.addTypography( 'font-family', this.getTypographySettings.h4FontFamily )
                + this.addTypography( 'font-weight', this.getTypographySettings.h4FontWeight )
                + this.addTypography( 'color', this.getTypographySettings.h4Color )
                + this.addTypography( 'padding-top', this.getTypographySettings.h4PaddingTop )
                + this.addTypography( 'padding-right', this.getTypographySettings.h4PaddingRight )
                + this.addTypography( 'padding-left', this.getTypographySettings.h4PaddingLeft )
                + this.addTypography( 'padding-bottom', this.getTypographySettings.h4PaddingBottom )
                + this.addTypography( 'margin-top', this.getTypographySettings.h4MarginTop )
                + this.addTypography( 'margin-right', this.getTypographySettings.h4MarginRight )
                + this.addTypography( 'margin-left', this.getTypographySettings.h4MarginLeft )
                + this.addTypography( 'margin-bottom', this.getTypographySettings.h4MarginBottom )
                + this.addTypography( 'line-height', this.getTypographySettings.h4LineHeight )
                + this.addTypography( 'letter-spacing', this.getTypographySettings.h4LetterSpacing )
                + '}';

            css += 'h5 {' + this.addTypography( 'font-family', this.getTypographySettings.h5FontFamily )
                + this.addTypography( 'font-weight', this.getTypographySettings.h5FontWeight )
                + this.addTypography( 'color', this.getTypographySettings.h5Color )
                + this.addTypography( 'padding-top', this.getTypographySettings.h5PaddingTop )
                + this.addTypography( 'padding-right', this.getTypographySettings.h5PaddingRight )
                + this.addTypography( 'padding-left', this.getTypographySettings.h5PaddingLeft )
                + this.addTypography( 'padding-bottom', this.getTypographySettings.h5PaddingBottom )
                + this.addTypography( 'margin-top', this.getTypographySettings.h5MarginTop )
                + this.addTypography( 'margin-right', this.getTypographySettings.h5MarginRight )
                + this.addTypography( 'margin-left', this.getTypographySettings.h5MarginLeft )
                + this.addTypography( 'margin-bottom', this.getTypographySettings.h5MarginBottom )
                + this.addTypography( 'line-height', this.getTypographySettings.h5LineHeight )
                + this.addTypography( 'letter-spacing', this.getTypographySettings.h5LetterSpacing )
                + '}';

            css += 'h6 {' + this.addTypography( 'font-family', this.getTypographySettings.h6FontFamily )
                + this.addTypography( 'font-weight', this.getTypographySettings.h6FontWeight )
                + this.addTypography( 'color', this.getTypographySettings.h6Color )
                + this.addTypography( 'padding-top', this.getTypographySettings.h6PaddingTop )
                + this.addTypography( 'padding-right', this.getTypographySettings.h6PaddingRight )
                + this.addTypography( 'padding-left', this.getTypographySettings.h6PaddingLeft )
                + this.addTypography( 'padding-bottom', this.getTypographySettings.h6PaddingBottom )
                + this.addTypography( 'margin-top', this.getTypographySettings.h6MarginTop )
                + this.addTypography( 'margin-right', this.getTypographySettings.h6MarginRight )
                + this.addTypography( 'margin-left', this.getTypographySettings.h6MarginLeft )
                + this.addTypography( 'margin-bottom', this.getTypographySettings.h6MarginBottom )
                + this.addTypography( 'line-height', this.getTypographySettings.h6LineHeight )
                + this.addTypography( 'letter-spacing', this.getTypographySettings.h6LetterSpacing )
                + '}';

            var node = document.querySelector( "#custom-typography-css" );
            if ( node ) {
                node.innerHTML = css;
            }

        },
        addTypography: function ( key, value ) {
            if ( value ) {
                return key + ': ' + value + ';';
            } else return '';
        }
    },
};
</script>