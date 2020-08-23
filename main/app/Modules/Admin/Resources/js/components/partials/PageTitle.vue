<template>
  <div class="rui-page-title">
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <inertia-link
              :href="$urlExists('admin.dashboard') ? $route('admin.dashboard') : $route('agent.dashboard')"
            >Smart Monie</inertia-link>
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
    props: {
      title: {
        type: String,
        required: true,
      },
    },
  };
</script>

<style lang="scss" scoped>
</style>
