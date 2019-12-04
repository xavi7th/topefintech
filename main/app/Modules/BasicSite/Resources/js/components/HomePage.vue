<template>
  <div>
    <Hero />
    <Highlights />
    <InterestCalculator />
    <LatestNews />
    <RegistrationSteps />
    <SaverOfTheMonth />
    <StoriesSummary />
    <Testimonials />
  </div>
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
      Testimonials
    },
    mounted() {
      this.$emit("page-loaded");
    },
    data: () => ({
      details: {}
    })
  };
</script>

<style lang="scss" scoped>
</style>
