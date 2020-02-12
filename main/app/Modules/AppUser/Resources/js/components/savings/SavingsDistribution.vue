<template>
  <div>
    SavingsDistribution for {{ amount }}
    <router-link :to="{name: 'savings.payment-options', params:{amount}}">Payment options</router-link>
  </div>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  export default {
    mixins: [mixins],
    props: ["amount"],
    name: "SavingsDistribution",
    data: () => {
      return {};
    },
    components: {},
    created() {},

    mounted() {
      this.$emit("page-loaded");
    },
    methods: {}
  };
</script>
