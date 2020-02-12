<template>
  <div>
    PaymentOptions for {{ amount }}
    <router-link :to="{name: 'savings.payment-success', params:{amount}}">Payment Success</router-link>
  </div>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  export default {
    mixins: [mixins],
    props: ["amount"],
    name: "PaymentOptions",
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
