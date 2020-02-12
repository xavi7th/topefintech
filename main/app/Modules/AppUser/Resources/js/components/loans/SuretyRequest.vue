<template>
  <div>SuretyRequest</div>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  export default {
    mixins: [mixins],
    name: "SuretyRequest",
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
