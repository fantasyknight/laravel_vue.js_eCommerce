let elements = [];

function addCss ( item ) {
    let delay = 300;
    let duration = 1000;
    let keyframes = "fade-in";

    if ( item.getAttribute( 'data-animation-delay' ) ) delay = parseInt( item.getAttribute( 'data-animation-delay' ) );
    if ( item.getAttribute( 'data-animation-duration' ) ) duration = parseInt( item.getAttribute( 'data-animation-duration' ) );
    if ( item.getAttribute( 'data-animation-name' ) ) keyframes = item.getAttribute( 'data-animation-name' );

    item.classList.add( keyframes, 'animated', 'appear-animation-visible' );
    item.style.animationDelay = delay + 'ms';
    item.style.animationDuration = duration + 'ms';
}

function removeCss ( item ) {
    let keyframes = "fade-in";
    if ( item.getAttribute( 'data-animation-name' ) ) keyframes = item.getAttribute( 'data-animation-name' );

    item.classList.remove( keyframes, 'animated', 'appear-animation-visible' );
}

function addNormalCss () {
    for ( let i = 0; i < elements.length; i++ ) {
        let element = elements[ i ];

        let top = element.getBoundingClientRect().top;
        let bottom = element.getBoundingClientRect().bottom;

        if ( !element.classList.contains( 'appear-animation-visible' ) )
            if ( ( top > 0 && window.innerHeight > top ) || ( bottom > 0 && top < 0 ) ) {
                addCss( element );
            }
    }
}

function addSlideCss ( slideEl ) {
    let animateNodes = slideEl.querySelectorAll( '.appear-animate' );
    for ( let i = 0; i < animateNodes.length; i++ ) {
        addCss( animateNodes[ i ] );
    }
}

function removeSlideCss ( slideEl ) {
    let animateNodes = slideEl.querySelectorAll( '.appear-animate' );
    for ( let i = 0; i < animateNodes.length; i++ ) {
        removeCss( animateNodes[ i ] );
    }
}

export default {
    inserted: function ( el, binding, vnode ) {
        if ( el.classList.contains( 'slide-animate' ) ) {
            addSlideCss( el.querySelectorAll( '.owl-item' )[ 0 ] );

            $( '.slide-animate' ).on( 'translated.owl.carousel', function ( e ) {
                let activeIndex = e.item.index;
                addSlideCss( el.querySelectorAll( '.owl-item' )[ activeIndex ] );

                if ( el.querySelectorAll( '.owl-item' )[ activeIndex - 1 ] ) {
                    removeSlideCss( el.querySelectorAll( '.owl-item' )[ activeIndex - 1 ] );
                }

                if ( el.querySelectorAll( '.owl-item' )[ activeIndex + 1 ] ) {
                    removeSlideCss( el.querySelectorAll( '.owl-item' )[ activeIndex + 1 ] );
                }
            } )
        } else if ( !el.classList.contains( 'animated' ) && !el.closest( '.slide-animate' ) ) {
            if ( el.getBoundingClientRect().top >= 0 && window.innerHeight > el.getBoundingClientRect().top ) {
                addCss( el );
            } else {
                elements.push( el );
                window.addEventListener( 'scroll', addNormalCss, { passive: true } );
            }
        }
    },
    unbind: function () {
        window.removeEventListener( 'scroll', addNormalCss, { passive: true } );
    }
};