<template>
  <nav class="rui-navbar rui-navbar-top rui-navbar-sticky">
    <div class="rui-navbar-brand">
      <a href="dashboard.html" class="rui-navbar-logo">
        <img
          src="/img/logo.svg"
          data-src-night="/img/logo-white.svg"
          data-src-day="/img/logo.svg"
          alt
          width="45"
        />
      </a>
      <button class="yay-toggle rui-yaybar-toggle" type="button">
        <span></span>
      </button>
    </div>
    <div class="container-fluid">
      <div class="rui-navbar-content">
        <ul class="nav"></ul>
        <ul class="nav rui-navbar-right">
          <li class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open">
            <a
              class="dropdown-item rui-navbar-avatar mnr-6"
              href="#"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img src="/img/avatar-1.png" alt />
            </a>
            <ul class="nav dropdown-menu">
              <li>
                <a href="profile.html" class="nav-link">
                  <span data-feather="plus-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Create new Post</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <a href="profile.html" class="nav-link">
                  <span data-feather="users" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Manage Users</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <a href="profile.html" class="nav-link">
                  <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Check Updates</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <inertia-link method="post" :href="$route('appuser.logout')" class="nav-link">
                  <span data-feather="log-out" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Logout</span>
                  <span class="rui-nav-circle"></span>
                </inertia-link>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
  export default {
    name: "UserDashboardHeader",
    computed: {},
    mounted() {}
  };
</script>

<style lang="scss" scoped>
</style>
