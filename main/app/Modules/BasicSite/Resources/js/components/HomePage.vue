<template>
  <layout title="Welcome to SmartMonie">
    <Hero />
    <Highlights />
    <AboutUs />
    <RegistrationSteps />
    <InterestCalculator />
    <SaveSmartly />
    <Testimonials />
    <CTA />
    <DailyNews />

    <!-- <SaverOfTheMonth /> -->
    <!-- <StoriesSummary /> -->
  </layout>
</template>

<script>
  import Hero from "@basicsite-components/home/Hero";
  import Highlights from "@basicsite-components/home/Highlights";
  import InterestCalculator from "@basicsite-components/home/InterestCalculator";
  import AboutUs from "@basicsite-components/home/AboutUs";
  import SaveSmartly from "@basicsite-components/home/SaveSmartly";
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
      app: Object
    },
    components: {
      Hero,
      Highlights,
      InterestCalculator,
      AboutUs,
      SaveSmartly,
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
