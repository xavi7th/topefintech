<template>
  <div class="yaybar yay-hide-to-small yay-shrink yay-gestures rui-yaybar">
    <div class="yay-wrap-menu">
      <div class="yaybar-wrap">
        <ul>
          <li class="yay-label">Components</li>

          <li v-for="(item, index) in routes.filter(x => x.path !== '*')" :key="index">
            <router-link :to="item.path" v-if="item.name && !item.meta.skip">
              <span class="yay-icon">
                <span
                  data-feather="menu"
                  class="rui-icon rui-icon-stroke-1_5"
                  :class="item.meta.iconClass"
                ></span>
              </span>
              {{item.meta.menuName}}
              <span class="rui-yaybar-circle"></span>
            </router-link>
            <a href="#" v-else-if="!item.meta.skip" class="yay-sub-toggle">
              <span class="yay-icon">
                <span
                  data-feather="layers"
                  class="rui-icon rui-icon-stroke-1_5"
                  :class="item.meta.iconClass"
                ></span>
              </span>
              <span>{{item.meta.menuName}}</span>
              <span class="yay-icon-collapse">
                <span
                  data-feather="chevron-right"
                  class="rui-icon rui-icon-collapse rui-icon-stroke-1_5"
                ></span>
              </span>
            </a>
            <ul class="yay-submenu dropdown-triangle" v-if="item.children">
              <li
                v-for="childItem in item.children"
                :key="childItem.name"
                v-show="!childItem.meta.skip"
              >
                <router-link :to="childItem.path">{{childItem.meta.menuName}}</router-link>
              </li>
            </ul>
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
        return this.$router.options.routes;
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
