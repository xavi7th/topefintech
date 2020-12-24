<template>
  <layout title="Welcome to SmartMonie" :isHome="true">
    <Hero />
    <!-- <AboutUs /> -->
    <RegistrationSteps />
    <FinancialFreedom />
    <!-- <InterestCalculator /> -->
    <Testimonials :testimonials=testimonials />
    <SaveSecurely />
    <CTA />
    <!-- <DailyNews /> -->

    <!-- <SaverOfTheMonth /> -->
    <!-- <StoriesSummary /> -->
  </layout>
</template>

<script>
  import Hero from "@basicsite-components/home/Hero";
  import FinancialFreedom from "@basicsite-components/home/FinancialFreedom";
  import InterestCalculator from "@basicsite-components/home/InterestCalculator";
  import AboutUs from "@basicsite-components/home/AboutUs";
  import SaveSecurely from "@basicsite-components/home/SaveSecurely";
  import RegistrationSteps from "@basicsite-components/home/RegistrationSteps";
  import SaverOfTheMonth from "@basicsite-components/home/SaverOfTheMonth";
  import StoriesSummary from "@basicsite-components/home/StoriesSummary";
  import Testimonials from "@basicsite-components/home/Testimonials";
  import CTA from "@basicsite-components/home/CTA";
  import DailyNews from "@basicsite-components/home/DailyNews";
  import Layout from "@basicsite-components/BasicSiteAppComponent";
  import { mixins } from "@basicsite-assets/js/misc";
  export default {
    name: "HomePage",
    mixins: [mixins],
    props: {
      app: Object,
      testimonials:Array
    },
    components: {
      Hero,
      FinancialFreedom,
      InterestCalculator,
      AboutUs,
      SaveSecurely,
      RegistrationSteps,
      SaverOfTheMonth,
      StoriesSummary,
      Testimonials,
      CTA,
      DailyNews,
      Layout
    }
  };
</script>
