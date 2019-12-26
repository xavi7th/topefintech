<template>
  <aside class="side-menu">
    <div class="side-menu-head">
      <div class="header-logo logo-type no-margin">
        <a href="index.html">SmartScoop</a>
      </div>
    </div>
    <nav data-simplebar>
      <ul class="menu">
        <li class="menu-title">ADMIN</li>

        <li v-for="(item, index) in routes" :key="index" :class="{'sub-item':item.children}">
          <router-link :to="item.path" v-if="item.name && !item.meta.skip">
            <i class="icon" :class="item.meta.iconClass"></i>
            <span>{{item.meta.menuName}}</span>
          </router-link>
          <a href="#" v-else-if="!item.meta.skip" class="sub-item-toggle">
            <i class="icon" v-bind:class="item.meta.iconClass"></i>
            <span>{{item.meta.menuName}}</span>
          </a>
          <div class="sub-menu" v-if="item.children">
            <ul>
              <li
                v-for="childItem in item.children"
                :key="childItem.name"
                v-show="!childItem.meta.skip"
              >
                <router-link :to="childItem.path">{{childItem.meta.menuName}}</router-link>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>
  </aside>
</template>

</template>

<script>
  export default {
    name: "UserDashboardNav",
    mounted() {
      this.$loadScript("/js/user-dashboard-nav.js").then(() => {
        this.isLoading = false;
      });
    },
    computed: {
      routes() {
        return this.$router.options.routes
          .filter(x => x.path !== "*")
          .filter(x => !x.meta.skip);
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
