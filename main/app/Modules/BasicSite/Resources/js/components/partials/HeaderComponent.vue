<template>
  <header class="header_1" id="header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-2">
          <div class="logo">
            <inertia-link :href="$route('app.home')">
              <img class="hidden-xs" src="/img/logo.png" alt width="120" />
              <img
                class="d-block d-md-none"
                src="/img/logo.png"
                alt
                width="120"
                v-if="$isCurrentUrl('app.home')"
              />
              <img class="d-block d-md-none" src="/img/logo-white.png" alt width="120" v-else />
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
              <li class="d-block d-sm-none">
                <a href="/register">Register</a>
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
    name: "HeaderComponent",
    computed: {
      routes() {
        return _.filter(this.$page.props.routes, x => !x.nav_skip);
      }
    }
  };
</script>

<style lang="scss" scoped>
  .mainmenu.MenuInRight.text-right {
    li {
      @media (max-width: 1100px) {
        font-size: 90%;
      }
      @media (max-width: 768px) {
        font-size: 0.6rem;
      }
    }
  }

  .mainmenu > ul {
    @media (max-width: 767px) and (min-width: 320px) {
      height: auto;
    }
  }

  .navigator_btn a {
    @media (max-width: 991px) and (min-width: 768px) {
      font-size: 13px;
    }
  }

  .animated.flipInX {
    padding-bottom: 0 !important;
    img.d-block {
      display: none !important;
    }

    img.hidden-xs {
      display: block !important;
    }

    li {
      a {
        color: #222;
      }
    }
  }
</style>
