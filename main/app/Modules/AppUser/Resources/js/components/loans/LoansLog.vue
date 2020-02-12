<template>
  <div>LoansLog</div>
</template>


<script>
  import { mixins } from "@dashboard-assets/js/config";
  export default {
    mixins: [mixins],
    name: "LoansLog",
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
