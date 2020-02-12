<template>
  <div>SavingsLog</div>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  export default {
    mixins: [mixins],
    name: "SavingsLog",
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
