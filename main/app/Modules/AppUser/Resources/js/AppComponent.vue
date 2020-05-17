<template>
  <div class="wrapper" v-if="isAuth">
    <transition name="fade">
      <pre-loader v-if="isLoading"></pre-loader>
    </transition>
    <transition name="slide-out-in" mode="out-in" :duration="{ enter: 1300, leave: 200 }">
      <router-view @page-loaded="pageLoaded" @is-leaving="isLoading = true"></router-view>
    </transition>
  </div>

  <div v-else>
    <transition name="fade">
      <pre-loader v-if="isLoading"></pre-loader>
    </transition>

    <dashboard-nav></dashboard-nav>
    <div class="rui-yaybar-bg"></div>

    <dashboard-header @logout-user="logoutUser()"></dashboard-header>
    <mobile-dashboard-header @logout-user="logoutUser()"></mobile-dashboard-header>
    <div class="rui-navbar-bg"></div>

    <div class="rui-page content-wrap">
      <page-title :title="title"></page-title>

      <div class="rui-page-content">
        <transition name="slide-out-in" mode="out-in" :duration="{ enter: 1300, leave: 200 }">
          <router-view
            @page-loaded="pageLoaded"
            @is-leaving="isLoading = true"
            @title="setPageTitle"
          ></router-view>
        </transition>
      </div>

      <dashboard-footer></dashboard-footer>
    </div>
  </div>
</template>

<script>
  import PreLoader from "@dashboard-components/PreLoader";
  import DashboardHeader from "@dashboard-components/partials/DashboardHeader";
  import MobileDashboardHeader from "@dashboard-components/partials/MobileDashboardHeader";
  import DashboardFooter from "@dashboard-components/partials/DashboardFooter";
  import DashboardNav from "@dashboard-components/partials/DashboardNav";
  import PageTitle from "@dashboard-components/partials/PageTitle";
  import { logout } from "@dashboard-assets/js/config";
  export default {
    name: "DashboardApp",
    components: {
      DashboardHeader,
      DashboardFooter,
      DashboardNav,
      PreLoader,
      MobileDashboardHeader,
      PageTitle
    },
    data: () => ({
      isLoading: true,
      title: "loading"
    }),
    computed: {
      isAuth() {
        return (
          this.$route.path.match("login") || this.$route.path.match("register")
        );
      }
    },
    methods: {
      logoutUser() {
        logout("Securing your account and logging you out.");
      },
      pageLoaded() {
        this.$loadScript("/js/user-dashboard-main.js").then(() => {
          this.isLoading = false;
        });
      },
      setPageTitle(e) {
        this.title = e;
      }
    }
  };
</script>

<style lang="scss">
  // @import "~@dashboard-assets/sass/app";
</style>
