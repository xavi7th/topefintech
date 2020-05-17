<template>
  <header class="header_1" id="header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-2">
          <div class="logo">
            <inertia-link href="{name:'site.root'}">
              <img src="/img/logo.png" alt />
            </inertia-link>
          </div>
        </div>
        <div class="col-md-8">
          <nav class="mainmenu MenuInRight text-right">
            <a href="javascript:void(0);" class="mobilemenu d-md-none d-lg-none d-xl-none">
              <span></span>
              <span></span>
              <span></span>
            </a>
            <ul>
              <li v-for="(item, index) in routes" :key="index">
                <inertia-link :href="$route(item.name)">{{item.menu_name}}</inertia-link>
              </li>
              <li>
                <a href="/login">Login</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-lg-2 col-md-2 hidden-xs">
          <div class="navigator_btn btn_bg text-right">
            <a class="common_btn" href="/register ">Create Account</a>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
  export default {
    name: "Header",
    data() {
      return {};
    },
    mounted() {},
    computed: {
      routes() {
        return [];
      },
      breadcrumb() {
        return "breadcrumb";
      },
      routes() {
        console.log(this.$page.routes);

        return _.filter(this.$page.routes, x => !x.nav_skip);
      }
    }
  };
</script>

<style lang="scss">
  .mainmenu.MenuInRight.text-right {
    li {
      @media (max-width: 1100px) {
        font-size: 90%;
      }
      @media (max-width: 768px) {
        font-size: 0.6rem;
        padding: 15px 10px;
      }
    }
  }
</style>
