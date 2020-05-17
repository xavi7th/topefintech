export const mixins = {
    mounted() {
        console.log( 'mounted' );

        this.$loadScript( "/js/main.js" );
    },
    beforeDestroy() {
        this.$unloadScript( "/js/main.js" );
        console.log( 'destroying' );

    }
}
