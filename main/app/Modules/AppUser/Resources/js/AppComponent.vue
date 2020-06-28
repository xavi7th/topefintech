<template>
  <div class="rui-main" v-if="isAuth">
    <div class="rui-sign align-items-center justify-content-center">
      <div class="bg-image">
        <div class="bg-grey-1"></div>
      </div>
      <div class="form rui-sign-form rui-sign-form-cloud">
        <transition name="slide-out-in" mode="out-in" :duration="{ enter: 1300, leave: 200 }">
          <slot></slot>
        </transition>
      </div>
    </div>
  </div>

  <div
    v-else
    data-spy="scroll"
    data-target=".rui-page-sidebar"
    data-offset="140"
    class="rui-no-transition rui-navbar-autohide rui-section-lines body-wrap"
  >
    <dashboard-nav></dashboard-nav>
    <div class="rui-yaybar-bg"></div>

    <dashboard-header></dashboard-header>
    <mobile-dashboard-header></mobile-dashboard-header>
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
  import DashboardHeader from "@dashboard-components/partials/DashboardHeader";
  import MobileDashboardHeader from "@dashboard-components/partials/MobileDashboardHeader";
  import DashboardFooter from "@dashboard-components/partials/DashboardFooter";
  import DashboardNav from "@dashboard-components/partials/DashboardNav";
  import PageTitle from "@dashboard-components/partials/PageTitle";
  import { logout } from "@dashboard-assets/js/config";
  export default {
    name: "DashboardAppLayout",
    components: {
      DashboardHeader,
      DashboardFooter,
      DashboardNav,
      MobileDashboardHeader,
      PageTitle
    },
    props: {
      title: String,
      app: Object,
      isAuth: {
        type: Boolean,
        default: true
      }
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
