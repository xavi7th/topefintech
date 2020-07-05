/**
 * @author leinad
 */

import dayjs from 'dayjs';

const InvalidReturn = '';
const LangSet = {
    en: {
        Y: ' year',
        M: ' month',
        Ms: ' months',
        D: ' day',
        Ds: ' days',
        h: ' hour',
        hs: ' hours',
        m: ' minute',
        ms: ' minutes',
        s: ' second',
        ago: ' ago',
        just: ' just now'
    }
};
const wrapZero = function ( n ) {
    return n < 10 ? '0' + n : n;
};

// target
let timer = {};

export default {
    /**
     * Vue
     * @param {Vue} Vue
     * @param {object} options
     */
    install( Vue, options = {} ) {
        const lang = LangSet[ options.lang || 'en' ];

        const debug = options.debug || false;

        const filters = options.filters || {
            ago: 'ago'
        };

        const directives = options.directives || {
            countdown: 'countdown'
        };

        //  dayjs
        Vue.prototype.$dayjs = dayjs;

        'countdown' in directives &&
            Vue.directive( directives[ 'countdown' ], ( el, binding ) => {
                let from, target, dArray, offset, str, format;

                if ( !binding.value || !binding.value.target ) {
                    return ( el.innerText = InvalidReturn );
                }
                format = binding.value.format || 'HH:mm:ss';
                target = dayjs( binding.value.target );
                if ( !target.isValid() ) {
                    return ( el.innerText = InvalidReturn );
                }
                timer[ target.valueOf() ] && clearTimeout( timer[ target.valueOf() ] );
                const count = () => {
                    from = dayjs();
                    dArray =
                        from.valueOf() <= target.valueOf() ? [ target, from ] : [ target, target ];
                    let diffD = dArray[ 0 ].diff( dArray[ 1 ], 'day' );
                    let diffh, diffm, diffs;
                    offset = dArray[ 0 ];
                    str = format;
                    if ( diffD > 0 && format.match( 'DD' ) ) {
                        str = str.replace( 'DD', diffD );
                        offset = offset.subtract( diffD, 'day' );
                    }
                    diffh = offset.diff( dArray[ 1 ], 'hour' );
                    str = str.replace( 'HH', wrapZero( diffh ) );
                    offset = offset.subtract( diffh, 'hour' );
                    diffm = offset.diff( dArray[ 1 ], 'minute' );
                    str = str.replace( 'mm', wrapZero( diffm ) );
                    offset = offset.subtract( diffm, 'minute' );
                    diffs = offset.diff( dArray[ 1 ], 'second' );
                    str = str.replace( 'ss', wrapZero( diffs ) );
                    el.innerText = str;
                    timer[ target.valueOf() ] = setTimeout( count, 1000 );
                };
                count();
            } );

        /**
         * dayjs
         */
        Vue.filter( 'dayjs', ( value, method, ...params ) => {
            let d = dayjs( value );
            if ( !d.isValid() ) return InvalidReturn;
            if ( params.length ) {
                return d[ method ].apply( d, params );
            } else {
                return d.format( method )
            }
        } );

        'ago' in filters &&
            Vue.filter( filters[ 'ago' ], value => {
                const p = dayjs( value );
                const d = dayjs();
                let str = '';

                if ( !p.isValid() ) return InvalidReturn;
                let diffY = d.diff( p, 'year' );
                let diffM = d.diff( p, 'month' );
                let diffD = d.diff( p, 'day' );
                let diffh = d.diff( p, 'hour' );
                let diffm = d.diff( p, 'minute' );
                let diffs = 0;
                let offset = null;

                if ( diffY > 0 ) {
                    return p.format( 'YYYY-MM-DD' );
                }

                if ( diffM > 0 ) {
                    str = diffM + lang.M;
                    return str + lang.ago;
                } else if ( diffM > 0 ) {
                    str = diffM + lang.Ms;
                    return str + lang.ago;
                }

                if ( diffD > 0 ) {
                    str += diffD + lang.D;
                    return str + lang.ago;
                } else if ( diffD > 0 ) {
                    str += diffD + lang.Ds;
                    return str + lang.ago;
                }

                if ( diffh > 0 ) {
                    str += diffh + lang.h;
                    return str + lang.ago;
                } else if ( diffh > 0 ) {
                    str += diffh + lang.hs;
                    return str + lang.ago;
                }

                if ( diffm === 1 ) {
                    str = diffM + lang.m;
                    return str + lang.ago;
                } else if ( diffm > 0 ) {
                    str += diffm + lang.ms;
                    return str + lang.ago;
                }

                if ( diffs > 0 ) {
                    if ( diffs < 30 ) {
                        return lang.just;
                    }
                    str += diffs + lang.s;
                }

                return str + lang.ago;
            } );
    }
};
