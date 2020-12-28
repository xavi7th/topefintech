<template>
  <transition name="nav-transition" mode="out-in">
    <div class="page" :class="{'other-pages': !isHome}">
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
    name: "BasicsiteAppComponent",
    components: {
      SiteHeader,
      SiteFooter
    },
    props: {
      title: String,
      isHome:{
        type:Boolean,
        default:false
      }
    },
    created() {
      // console.log();
      // if (this.$isCurrentUrl("app.home")) {
      //   let bodyElem = document.querySelector("body");
      //   bodyElem.classList.remove("bg_right");
      // } else {
      //   let bodyElem = document.querySelector("body");
      //   bodyElem.classList.add("bg_right");
      // }
    },
    watch: {
      title: {
        immediate: true,
        handler(title) {
          document.title = `${title} - ${this.$page.props.app.name}`;
        }
      }
    }
  };
</script>
