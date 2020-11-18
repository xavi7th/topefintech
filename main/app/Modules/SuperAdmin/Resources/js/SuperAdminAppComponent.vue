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
    <super-admin-mobile-header></super-admin-mobile-header>
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
  import SuperAdminHeader from "@superadmin-components/partials/SuperAdminHeader";
  import SuperAdminMobileHeader from "@superadmin-components/partials/SuperAdminMobileHeader";
  import DashboardFooter from "@dashboard-components/partials/DashboardFooter";
  import SuperAdminNav from "@superadmin-components/partials/SuperAdminNav";
  import PageTitle from "@superadmin-components/partials/PageTitle";

  export default {
    name: "SuperAdminDashboardApp",
    props: {
      title: String,
      isAuth: {
        type: Boolean,
        default: true
      }
    },
    components: {
      SuperAdminHeader,
      SuperAdminMobileHeader,
      DashboardFooter,
      SuperAdminNav,
      PageTitle
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
  @import "~@dashboard-assets/sass/app";
</style>
