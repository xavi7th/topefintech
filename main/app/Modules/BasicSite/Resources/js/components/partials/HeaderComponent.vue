<template>
  <header class="header_1" id="header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-2">
          <div class="logo">
            <router-link :to="{name:'site.root'}">
              <img src="/img/logo.png" alt />
            </router-link>
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
                <router-link
                  :to="item.path"
                  v-if="item.name && !item.meta.navSkip"
                >{{item.meta.menuName}}</router-link>
                <a href="#" v-else-if="!item.meta.skip">{{item.meta.menuName}}</a>
                <ul class="sub-menu" v-if="item.children">
                  <li
                    v-for="childItem in item.children"
                    :key="childItem.name"
                    v-show="!childItem.meta.skip"
                  >
                    <router-link :to="childItem.path">{{childItem.meta.menuName}}</router-link>
                  </li>
                </ul>
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
    props: {
      isHome: {
        type: Boolean,
        default: false,
        required: true
      }
    },
    data() {
      return {};
    },
    computed: {
      routes() {
        return this.$router.options.routes;
      },
      breadcrumb() {
        return this.$route.meta.breadcrumb;
      },
      routes() {
        return this.$router.options.routes.filter(x => !x.meta.navSkip);
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
