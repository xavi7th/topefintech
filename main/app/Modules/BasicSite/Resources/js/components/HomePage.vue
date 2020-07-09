<template>
  <layout title="Welcome to Smartcoop">
    <Hero />
    <Highlights />
    <!-- <InterestCalculator /> -->
    <LoanAdverts />
    <SaveSmartly />
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
  import LoanAdverts from "@basicsite-components/home/LoanAdverts";
  import SaveSmartly from "@basicsite-components/home/SaveSmartly";
  import RegistrationSteps from "@basicsite-components/home/RegistrationSteps";
  import SaverOfTheMonth from "@basicsite-components/home/SaverOfTheMonth";
  import StoriesSummary from "@basicsite-components/home/StoriesSummary";
  import Testimonials from "@basicsite-components/home/Testimonials";
  import Layout from "@basicsite-components/BasicSiteAppComponent";
  import { mixins } from "@basicsite-assets/js/misc";
  export default {
    name: "HomePage",
    mixins: [mixins],
    props: {
      app: Object
    },
    components: {
      Hero,
      Highlights,
      InterestCalculator,
      LoanAdverts,
      SaveSmartly,
      RegistrationSteps,
      SaverOfTheMonth,
      StoriesSummary,
      Testimonials,
      Layout
    }
  };
</script>
