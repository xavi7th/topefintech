/*
 Theme Name: Payloan
 Theme URI:
 Author:
 Author URI:
 Description: Payloan - Banking & Business Loan HTML5 Responsive Template
 Version: 1.0
 License:
 License URI:
 */
/*=======================================================================
 [Table of contents]
 ========================================================================
 1. Revolution Slider
 2. Bact To Top
 3. Related Blog Post
 4. Customer Slider
 5. Image Full Width
 6. Portfolio Suffle js
 7. Related Folio Slider
 8. Google Map
 9. Team Slider
 10. Loan Calculation
 11. Fixed Header
 12. Preloder
 13. Contact From Submit
 14. Mobile Menu
 */


( function ( $ ) {
    'use strict';

    /*--------------------------------------------------------
     / 1. Revolution Slider
     /----------------------------------------------------------*/
    // var revapi = jQuery('#rev_slider_1').show().revolution({
    //     delay: 7000,
    //     responsiveLevels: [1400, 1200, 1140, 778, 480],
    //     gridwidth: [1140, 1140, 920, 700, 380],
    //     sliderLayout: 'fullscreen',
    //     navigation: {
    //         arrows: {
    //             enable: false
    //         },
    //         bullets: {
    //             enable: false
    //         }
    //     }
    // });

    /*--------------------------------------------------------
     / 2. Bact To Top
     /---------------------------------------------------------*/
    $( "body, html" ).on( "click", "#backTo", function ( e ) {
        e.preventDefault();
        $( 'html, body' ).animate( {
            scrollTop: 0
        }, 800 );
    } );

    /*--------------------------------------------------------
     / 3. Related Blog Post
     /---------------------------------------------------------*/
    if ( $( '.related_post_slide' ).length > 0 ) {
        $( '.related_post_slide' ).owlCarousel( {
            items: 2,
            margin: 60,
            autoplay: false,
            nav: true,
            navText: [ "<i class='flaticon-back'></i>", "<i class='flaticon-next'></i>" ],
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                991: {
                    items: 2
                }
            }
        } );
    }

    /*--------------------------------------------------------
     / 4. Customer Slider
     /---------------------------------------------------------*/
    if ( $( '.customer_area' ).length > 0 ) {
        $( '.customer_area' ).owlCarousel( {
            items: 1,
            margin: 0,
            autoplay: false,
            nav: true,
            navText: [ "<i class='flaticon-back'></i>", "<i class='flaticon-next'></i>" ],
            dots: false
        } );
    }

    /*--------------------------------------------------------
     / 5. Image Full Width
     /---------------------------------------------------------*/
    function tw_stretch() {
        var i = $( window ).width();
        $( ".row .tw-stretch-element-inside-column" ).each( function () {
            var $this = $( this ),
                row = $this.closest( ".row" ),
                cols = $this.closest( '[class^="col-"]' ),
                rect = this.getBoundingClientRect(),
                l = row[ 0 ].getBoundingClientRect(),
                s = cols[ 0 ].getBoundingClientRect(),
                r = rect.left,
                d = i - rect.right,
                c = l.left + ( parseFloat( row.css( "padding-left" ) ) || 0 ),
                u = i - l.right + ( parseFloat( row.css( "padding-right" ) ) || 0 ),
                p = s.left,
                f = i - s.right,
                styles = {
                    "margin-left": 0,
                    "margin-right": 0
                };
            if ( Math.round( c ) === Math.round( p ) ) {
                var h = parseFloat( $this.css( "margin-left" ) || 0 );
                styles[ "margin-left" ] = h - r
            }
            if ( Math.round( u ) === Math.round( f ) ) {
                var w = parseFloat( $this.css( "margin-right" ) || 0 );
                styles[ "margin-right" ] = w - d
            }
            $this.css( styles )
        } )
    }
    tw_stretch();

    /*--------------------------------------------------------
     / 6. Portfolio Suffle js
     /---------------------------------------------------------*/
    if ( $( "#grid_suffle" ).length > 0 ) {
        $( window ).load( function () {
            $( "#grid_suffle" ).shuffle( {
                itemSelector: ".item",
                gutterWidth: 0
            } );
        } );
    }

    /*--------------------------------------------------------
     / 7. Related Folio Slider
     /---------------------------------------------------------*/
    if ( $( '.related_slide' ).length > 0 ) {
        $( '.related_slide' ).owlCarousel( {
            items: 2,
            margin: 40,
            autoplay: true,
            nav: false,
            navText: false,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                }
            }
        } );
    }

    /*------------------------------------------------------------------------------
     / 9. Team Slider
     /------------------------------------------------------------------------------*/

    if ( $( '.team_slider' ).length > 0 ) {
        try {

            $( '.team_slider' ).slick( {
                autoplay: false,
                autoplaySpeed: 2000,
                slidesToShow: 1,
                dots: false,
                arrows: true,
                centerMode: true,
                asNavFor: '.slider-nav',
                centerPadding: '0'
            } );

            $( '.slider-nav' ).slick( {
                slidesToShow: 5,
                slidesToScroll: 5,
                asNavFor: '.team_slider',
                dots: true,
                centerMode: true,
                focusOnSelect: true
            } );
        } catch ( error ) {

        }

    }

    /*--------------------------------------------------------
     / 10. Loan Calculation
     /--------------------------------------------------------*/
    if ( $( '#price_range' ).length > 0 ) {
        $( "#price_range" ).slider( {
            range: "min",
            value: 90800,
            min: 1,
            max: 181600,
            slide: function ( event, ui ) {
                $( "#amount" ).val( "$" + ui.value );
            }
        } );
        $( "#amount" ).val( "$" + $( "#price_range" ).slider( "value" ) );
    }

    /*--------------------------------------------------------
     / 11. Fixed Header
     /--------------------------------------------------------*/
    $( window ).on( 'scroll', function () {
        if ( $( window ).scrollTop() > 40 ) {
            $( "#header" ).addClass( 'fixedHeader animated flipInX' );
        } else {
            $( "#header" ).removeClass( 'fixedHeader animated flipInX' );
        }
    } );

    /*--------------------------------------------------------
     / 12. Preloder
     /----------------------------------------------------------*/
    $( window ).load( function () {
        var preload = $( '.preloader' );
        if ( preload.length > 0 ) {
            preload.delay( 800 ).fadeOut( 'slow' );
        }
    } );

    /*--------------------------------------------------------
     / 14. Mobile Menu
     /----------------------------------------------------------*/
    if ( $( '.mobilemenu' ).length > 0 ) {
        $( '.mobilemenu' ).on( 'click', function ( e ) {
            var w = $( window ).width();
            $( this ).toggleClass( 'active' );
            $( '.mainmenu > ul' ).slideToggle( 'slow' );
        } );

        $( '.mainmenu ul li.menu-item-has-children' ).each( function () {
            var $this = $( this );
            $this.append( '<span class="submenu_toggler d-md-none d-lg-none d-xl-none"><i class="fa fa-angle-down"></i></span>' );
        } );

        $( '.mainmenu ul li.menu-item-has-children > span.submenu_toggler' ).on( 'click', function () {
            var $this = $( this );

            if ( $( this ).hasClass( 'active-span' ) ) {
                $( 'i', $this ).removeClass( 'fa-angle-up' ).addClass( 'fa-angle-down' );
            } else {
                $( 'i', $this ).addClass( 'fa-angle-up' ).removeClass( 'fa-angle-down' );
            }
            $( this ).prev( 'ul.sub-menu' ).slideToggle();
            $( this ).toggleClass( 'active-span' );
        } );
    }
} )( jQuery );
