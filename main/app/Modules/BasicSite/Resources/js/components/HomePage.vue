<template>
  <layout title="Hello Boss">
    <Hero />
    <Highlights />
    <!-- <InterestCalculator /> -->
    <LatestNews />
    <!-- <RegistrationSteps /> -->
    <!-- <SaverOfTheMonth /> -->
    <!-- <StoriesSummary /> -->
    <Testimonials />
  </layout>
</template>

<script>
  import Hero from "@basicsite-components/home/Hero";
  import Highlights from "@basicsite-components/home/Highlights";
  import InterestCalculator from "@basicsite-components/home/InterestCalculator";
  import LatestNews from "@basicsite-components/home/LatestNews";
  import RegistrationSteps from "@basicsite-components/home/RegistrationSteps";
  import SaverOfTheMonth from "@basicsite-components/home/SaverOfTheMonth";
  import StoriesSummary from "@basicsite-components/home/StoriesSummary";
  import Testimonials from "@basicsite-components/home/Testimonials";
  import Layout from "@basicsite-components/BasicSiteAppComponent";
  export default {
    name: "HomePage",
    components: {
      Hero,
      Highlights,
      InterestCalculator,
      LatestNews,
      RegistrationSteps,
      SaverOfTheMonth,
      StoriesSummary,
      Testimonials,
      Layout
    },
    data: () => ({
      details: {}
    }),
    mounted() {
      this.$loadScript("/js/main.js").then(() => {
        if (this.freshLoad) {
          this.freshLoad = false;
          $(".rd-dropdown-item").click(function() {
            $(".rd-nav-item").addClass(
              "rd-navbar--has-dropdown rd-navbar-submenu"
            );
          });
        }
      });
    },
    beforeDestroy() {
      this.$unloadScript("/js/main.js");
    }
  };
</script>

<style lang="scss" scoped>
</style>
