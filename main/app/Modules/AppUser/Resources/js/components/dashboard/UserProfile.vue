<template>
  <div></div>
</template>

<script>
  import mixins from "@dashboard-assets/js/config/mixins";
  export default {
    name: "UserProfile",
    mixins: [mixins],
    mounted() {
      this.$emit("page-loaded");
    }
  };
</script>

<style lang="scss" scoped>
</style>
