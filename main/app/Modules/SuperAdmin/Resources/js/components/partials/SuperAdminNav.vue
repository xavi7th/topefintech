<template>
  <div class="yaybar yay-hide-to-small yay-shrink yay-gestures rui-yaybar">
    <div class="yay-wrap-menu">
      <div class="yaybar-wrap">
        <ul>
          <li class="yay-label">Super Admin Menu</li>

          <template v-for="(route_cont, route_name) in routes">

            <template v-if="route_cont.length == 1">
              <li :class="{'yay-item-active' : $isCurrentUrl(route_cont[0].name)}" :key="route_cont[0].name">
                <inertia-link
                  :href="$route(route_cont[0].name)"
                  class="yay-sub-toggle">
                  <span class="yay-icon">
                    <span :class="route_cont[0].icon"></span>
                  </span>
                  <span>{{ route_cont[0].menu_name }}</span>
                  <span class="rui-yaybar-circle" />
                </inertia-link>
              </li>
            </template>

            <template v-else-if="route_cont.length > 1">
              <li :key="route_cont[0].name">
                <a href class="yay-sub-toggle">
                  <span class="yay-icon">
                    <span :class="route_cont[0].icon"></span>
                  </span>
                  <span>{{ route_name }}</span>
                  <span class="rui-yaybar-circle" />
                  <span class="yay-icon-collapse">
                    <span
                      data-feather="chevron-right"
                      class="rui-icon rui-icon-collapse rui-icon-stroke-1_5" />
                  </span>
                </a>
                <ul class="yay-submenu dropdown-triangle">
                  <li v-for="elem in route_cont" :class="{'yay-tiem-active' : $isCurrentUrl(elem.name)}" :key="elem.name">
                    <inertia-link :href="$route(elem.name)">
                      {{ elem.menu_name }}
                    </inertia-link>
                  </li>
                </ul>
              </li>
            </template>
          </template>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "SuperAdminNav",
    computed: {
      routes() {
        return this.$page.props.routes;
        return _.filter(this.$page.props.routes, x => {
          console.log(x);
          // return !x.nav_skip
        });
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
