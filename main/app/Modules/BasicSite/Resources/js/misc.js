export const mixins = {
    mounted() {
        this.$loadScript( "/js/main.js" );
    },
    beforeDestroy() {
        this.$unloadScript( "/js/main.js" ).catch( ( err ) => {
            console.log( err );
            debugger;

        } )
    }
}
