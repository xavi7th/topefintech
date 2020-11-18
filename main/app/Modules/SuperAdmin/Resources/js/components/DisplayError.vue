<template>
  <display-error :status="status"></display-error>
</template>

<script>
  import DisplayError from "@basicsite-components/DisplayError";
  export default {
    name: `SuperAdminError`,
    components: {
      DisplayError
    },
    props: ["status"]
  };
</script>
