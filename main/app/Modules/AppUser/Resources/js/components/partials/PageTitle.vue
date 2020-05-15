<template>
  <div class="rui-page-title">
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.html">Smartcoop</a>
          </li>
        </ol>
      </nav>
      <h1>{{title}}</h1>
    </div>
  </div>
</template>
<script>
  export default {
    name: "PageTitle",
    props: ["title"],
    computed: {},
    mounted() {}
  };
</script>

<style lang="scss" scoped>
</style>
