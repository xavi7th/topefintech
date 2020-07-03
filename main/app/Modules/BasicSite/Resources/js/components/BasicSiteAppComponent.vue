<template>
  <transition name="nav-transition" mode="out-in">
    <div class="page">
      <site-header></site-header>

      <slot></slot>

      <site-footer></site-footer>
    </div>
  </transition>
</template>

<script>
  import SiteHeader from "@basicsite-components/partials/HeaderComponent";
  import SiteFooter from "@basicsite-components/partials/FooterComponent";

  export default {
    name: "Layout",
    components: {
      SiteHeader,
      SiteFooter
    },
    props: {
      title: String,
      app: Object
    },
    watch: {
      title: {
        immediate: true,
        handler(title) {
          document.title = `${title} - ${this.$page.app.name}`;
        }
      }
    }
  };
</script>

<style lang="scss">
  @import "~@basicsite-assets/sass/app";
</style>
