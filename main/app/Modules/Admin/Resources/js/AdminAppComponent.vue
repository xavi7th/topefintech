<template>
  <div class="rui-main" v-if="isAuth">
    <transition name="fade" :duration="{ enter: 1300, leave: 200 }">
      <page-loader v-if="isLoading"></page-loader>
    </transition>

    <transition name="nav-transition" mode="out-in">
      <router-view @page-loaded="pageLoaded" />
    </transition>
  </div>
  <div class="wrapper" v-else>
    <user-nav></user-nav>
    <div class="rui-yaybar-bg"></div>
    <user-header v-on:logout-user="logoutUser()" v-if="!is404" :isHome="isHome"></user-header>
    <mobile-nav></mobile-nav>
    <div class="rui-navbar-bg"></div>

    <transition name="fade" :duration="{ enter: 1300, leave: 200 }">
      <page-loader v-if="isLoading"></page-loader>
    </transition>
    <transition name="nav-transition" mode="out-in" :duration="{ leave: 600, enter: 600 }">
      <router-view @page-loaded="pageLoaded" @is-loading="toggleLoadState" />
    </transition>

    <user-footer v-if="!is404"></user-footer>

    <modal-component></modal-component>

    <popup-search-modal></popup-search-modal>

    <popup-messenger-modal></popup-messenger-modal>

    <popup-toast></popup-toast>
  </div>
</template>

<script>
  import PageLoader from "@admin-components/misc/PageLoader";
  import UserNav from "@admin-components/partials/NavComponent";
  import MobileNav from "@admin-components/partials/MobileNavComponent";
  import UserHeader from "@admin-components/partials/HeaderComponent";
  import UserFooter from "@admin-components/partials/FooterComponent";
  import ModalComponent from "@admin-components/utilities/ModalComponent";
  import PopupSearchModal from "@admin-components/utilities/PopupSearchModalComponent";
  import PopupMessengerModal from "@admin-components/utilities/PopupMessengerModalComponent";
  import PopupToast from "@admin-components/utilities/PopupToastComponent";

  export default {
    name: "AdminDashboardApp",
    data: () => ({
      isLoading: true
    }),
    components: {
      PageLoader,
      UserHeader,
      UserFooter,
      UserNav,
      MobileNav,
      ModalComponent,
      PopupSearchModal,
      PopupMessengerModal,
      PopupToast
    },
    created() {
      let docBody = document.querySelector("body");
      docBody.setAttribute("data-spy", "scroll");
      docBody.setAttribute("data-target", ".rui-page-sidebar");
      docBody.setAttribute("data-offset", "140");
      docBody.setAttribute(
        "class",
        "rui-navbar-autohide rui-section-lines rui-navbar-show"
      );
    },
    computed: {
      isAuth() {
        return (
          this.$route.name === null ||
          this.$route.path.match("login") ||
          this.$route.path.match("register")
        );
      },
      is404() {
        return this.$route.name
          ? this.$route.name.match("site.error")
            ? true
            : false
          : false;
      },
      isHome() {
        return this.$route.name
          ? this.$route.name.match("site.root")
            ? true
            : false
          : false;
      }
    },
    methods: {
      logoutUser(msg = "Logging you out....") {
        BlockToast.fire({
          text: msg
        });
        axios.post("/admin-panel/logout").then(rsp => {
          location.reload();
        });
      },
      toggleLoadState() {
        this.isLoading = true;
      },
      pageLoaded() {
        this.$loadScript("/js/admin-main.js").then(() => {
          $(".preloader").fadeOut(600);
          this.isLoading = false;
        });
      }
    }
  };
</script>

<style lang="scss">
  @import "~@admin-assets/sass/main";
</style>
