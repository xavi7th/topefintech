<template>
  <layout title="My Savings Interests" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
       <interests-summary />
      </div>
      <div class="rui-gap-3"></div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  import InterestsSummary from '@dashboard-components/savings/partials/InterestsSummary';
  export default {
    name: "ViewInterests",
    mixins: [mixins],
    components: {
      Layout,
      InterestsSummary
    },
  };
</script>
