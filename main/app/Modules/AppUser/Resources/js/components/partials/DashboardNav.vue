<template>
  <div class="yaybar yay-hide-to-small yay-shrink yay-gestures rui-yaybar">
    <div class="yay-wrap-menu">
      <div class="yaybar-wrap">
        <ul>
          <li class="yay-label">Get Started</li>

          <li
            v-for="(rt, index) in routes"
            :key="index"
            :class="{'yay-item-active': $isCurrentUrl(rt.name)}"
          >
            <inertia-link :href="$route(rt.name)">
              <span class="yay-icon">
                <span :class="rt.icon"></span>
              </span>

              <span>{{ rt.menu_name }}</span>
              <span class="rui-yaybar-circle"></span>
            </inertia-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "UserDashboardNav",
    computed: {
      routes() {
        return _.filter(this.$page.props.routes, x => !x.nav_skip);
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
