<template>
  <div class="wrapper">
    <admin-nav></admin-nav>
    <div class="rui-yaybar-bg"></div>
    <admin-header v-if="!is404" :isHome="isHome"></admin-header>
    <mobile-nav></mobile-nav>
    <div class="rui-navbar-bg"></div>

    <transition name="nav-transition" mode="out-in" :duration="{ leave: 600, enter: 600 }">
      <slot></slot>
    </transition>

    <admin-footer v-if="!is404"></admin-footer>

    <modal-component></modal-component>

    <popup-search-modal></popup-search-modal>

    <popup-messenger-modal></popup-messenger-modal>

    <popup-toast></popup-toast>
  </div>
</template>

<script>
  import PageLoader from "@admin-components/misc/PageLoader";
  import AdminNav from "@admin-components/partials/NavComponent";
  import MobileNav from "@admin-components/partials/MobileNavComponent";
  import AdminHeader from "@admin-components/partials/HeaderComponent";
  import AdminFooter from "@admin-components/partials/FooterComponent";
  import ModalComponent from "@admin-components/utilities/ModalComponent";
  import PopupSearchModal from "@admin-components/utilities/PopupSearchModalComponent";
  import PopupMessengerModal from "@admin-components/utilities/PopupMessengerModalComponent";
  import PopupToast from "@admin-components/utilities/PopupToastComponent";

  export default {
    name: "AdminDashboardApp",
    props: {
      is404: {
        type: Boolean,
        default: false
      },
      isHome: {
        type: Boolean,
        default: false
      },
      title: String
    },
    data: () => ({
      isLoading: true
    }),
    components: {
      PageLoader,
      AdminHeader,
      AdminFooter,
      AdminNav,
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
  // @import "~@dashboard-assets/sass/app";
</style>
