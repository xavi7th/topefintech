<template>
  <layout :isAuth="true" title="Login"></layout>
</template>

<script>
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "LoginPage",
    beforeCreate() {
      location.reload();
    },
    components: { Layout }
  };
</script>
