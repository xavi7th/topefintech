<template>
  <div
    data-spy="scroll"
    data-target=".rui-page-sidebar"
    data-offset="140"
    class="rui-no-transition rui-navbar-autohide rui-section-lines body-wrap"
  >
    <admin-nav></admin-nav>
    <div class="rui-yaybar-bg"></div>

    <admin-header></admin-header>
    <mobile-admin-header></mobile-admin-header>
    <div class="rui-navbar-bg"></div>

    <div class="rui-page content-wrap">
      <page-title :title="title"></page-title>

      <div class="rui-page-content">
        <transition name="slide-out-in" mode="out-in" :duration="{ enter: 1300, leave: 200 }">
          <slot></slot>
        </transition>
      </div>

      <dashboard-footer></dashboard-footer>
    </div>
    <slot name="modals"></slot>
  </div>
</template>

<script>
  import AdminHeader from "@admin-components/partials/AdminHeader";
  import MobileAdminHeader from "@admin-components/partials/MobileAdminHeader";
  import DashboardFooter from "@dashboard-components/partials/DashboardFooter";
  import AdminNav from "@admin-components/partials/AdminNav";
  import PageTitle from "@admin-components/partials/PageTitle";

  export default {
    name: "AdminDashboardApp",
    props: {
      title: String,
      isAuth: {
        type: Boolean,
        default: true
      }
    },
    components: {
      AdminHeader,
      MobileAdminHeader,
      DashboardFooter,
      AdminNav,
      PageTitle
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

<style lang="scss">
  // @import "~@dashboard-assets/sass/app";
</style>
