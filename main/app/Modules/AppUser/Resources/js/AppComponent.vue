<template>
  <div class="wrapper" v-if="isAuth">
    <transition name="fade">
      <pre-loader v-if="isLoading"></pre-loader>
    </transition>
    <transition name="slide-out-in" mode="out-in" :duration="{ enter: 1300, leave: 200 }">
      <router-view @page-loaded="pageLoaded" @is-leaving="isLoading = true"></router-view>
    </transition>
  </div>

  <div class="wrapper layout-side-menu" v-else>
    <transition name="fade">
      <pre-loader v-if="isLoading"></pre-loader>
    </transition>
    <dashboard-nav></dashboard-nav>
    <div class="wrapper-r">
      <dashboard-header @logout-user="logoutUser()"></dashboard-header>
      <transition name="slide-out-in" mode="out-in" :duration="{ enter: 1300, leave: 200 }">
        <router-view @page-loaded="pageLoaded" @is-leaving="isLoading = true"></router-view>
      </transition>
      <dashboard-footer></dashboard-footer>
    </div>
  </div>
</template>

<script>
  import PreLoader from "@dashboard-components/PreLoader";
  import DashboardHeader from "@dashboard-components/partials/DashboardHeader";
  import DashboardFooter from "@dashboard-components/partials/DashboardFooter";
  import DashboardNav from "@dashboard-components/partials/DashboardNav";
  import { logout } from "@dashboard-assets/js/config/endpoints";
  export default {
    name: "DashboardApp",
    components: {
      DashboardHeader,
      DashboardFooter,
      DashboardNav,
      PreLoader
    },
    data: () => ({
      isLoading: true
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
      }
    }
  };
</script>

<style lang="scss">
  @import "~@dashboard-assets/sass/main";
</style>
