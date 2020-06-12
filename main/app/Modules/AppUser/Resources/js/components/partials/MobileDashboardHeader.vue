<template>
  <div class="rui-navbar rui-navbar-mobile">
    <div class="rui-navbar-head">
      <button
        class="rui-yaybar-toggle rui-yaybar-toggle-inverse yay-toggle"
        type="button"
        aria-label="Toggle side navigation"
      >
        <span></span>
      </button>
      <a class="rui-navbar-logo mr-auto" href="dashboard.html">
        <img
          src="/img/logo.svg"
          data-src-night="/img/logo-white.svg"
          data-src-day="/img/logo.svg"
          alt
          width="45"
        />
      </a>
      <div class="dropdown dropdown-triangle">
        <a
          class="dropdown-item rui-navbar-avatar"
          href="#"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <img src="/img/avatar-1.png" alt />
        </a>
        <ul class="dropdown-menu nav">
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
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: "UserMobileDashboardHeader",
    computed: {},
    mounted() {}
  };
</script>

<style lang="scss" scoped>
</style>
