<template>
  <layout :title="`Interest Records for ${month}`" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <interests-break-down :interestSummary="interestSummary" :month="month"/>
      </div>
      <div class="rui-gap-3"></div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent.vue";
  import InterestsBreakDown from '@dashboard-components/savings/partials/InterestsBreakDown.vue';

  export default {
    name: "ViewInterestBreakdown",
    mixins: [mixins],
    components: {
      Layout,
      InterestsBreakDown
    },
    data: function() {
      return {
        interestSummary: this.$page.props.interests_summary,
        month: this.$page.props.month
      };
    }
  };
</script>

<style lang="scss" scoped>
  .rui-timeline {
    width: 100%;
  }
</style>
