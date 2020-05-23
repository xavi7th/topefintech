<template>
  <div class="yaybar yay-hide-to-small yay-shrink yay-gestures rui-yaybar">
    <div class="yay-wrap-menu">
      <div class="yaybar-wrap">
        <ul>
          <li class="yay-label">Menu</li>
          <li v-for="(item, index) in routes" :key="index">
            <inertia-link :href="$route(item.name)">
              <span class="yay-icon">
                <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span>
              </span>
              <span>{{item.menu_name}}</span>
              <span class="rui-yaybar-circle"></span>
            </inertia-link>
          </li>
        </ul>
      </div>
    </div>
    <div class="rui-yaybar-icons">
      <div class="row no-gutters justify-content-around">
        <div class="col-auto">
          <a class="btn btn-custom-round" href="#">
            <span data-feather="settings" class="rui-icon"></span>
          </a>
        </div>
        <div class="col-auto">
          <a class="btn btn-custom-round" href="#">
            <span data-feather="bell" class="rui-icon"></span>
          </a>
        </div>
        <div class="col-auto d-flex">
          <div class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open dropup">
            <a
              class="btn btn-custom-round dropdown-item"
              href="#"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              data-offset="-30"
            >
              <span data-feather="plus-circle" class="rui-icon rui-icon-stroke-1_5"></span>
            </a>
            <ul class="dropdown-menu nav">
              <li>
                <a href="#" class="nav-link">
                  <span data-feather="plus-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Create new Post</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link">
                  <span data-feather="book" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Project</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link">
                  <span data-feather="message-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Message</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link">
                  <span data-feather="mail" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Mail</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-auto">
          <a class="btn btn-custom-round" href="#">
            <span data-feather="clock" class="rui-icon rui-icon-stroke-1_5"></span>
          </a>
        </div>
        <div class="col-auto">
          <a class="btn btn-custom-round" href="#">
            <span data-feather="heart" class="rui-icon rui-icon-stroke-1_5"></span>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    computed: {
      routes() {
        return _.filter(this.$page.routes, x => !x.nav_skip);
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
