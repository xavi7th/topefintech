<template>
  <display-error :status="status"></display-error>
</template>

<script>
  import DisplayError from "@basicsite-components/DisplayError";
  export default {
    name: `AdminError`,
    components: {
      DisplayError
    },
    props: ["status"]
  };
</script>
