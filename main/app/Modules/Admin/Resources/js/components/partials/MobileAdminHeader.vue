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
      <inertia-link
        :href="$urlExists('admin.dashboard') ? $route('admin.dashboard') : $route('agent.dashboard')"
        class="rui-navbar-logo d-block text-center"
      >
        <img
          src="/img/logo.png"
          data-src-night="/img/logo.png"
          data-src-day="/img/logo.png"
          alt
          width="60%"
        />
      </inertia-link>
      <div class="dropdown dropdown-triangle">
        <a
          class="dropdown-item rui-navbar-avatar"
          href="#"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <img src="/img/avatar.png" alt="admin avatar" />
        </a>
        <ul class="dropdown-menu nav">
          <li>
            <inertia-link
              class="nav-link"
              :href="$urlExists('admin.notifications') ? $route('admin.notifications') : $route('agent.notifications')"
            >
              <span data-feather="bell" class="rui-icon rui-icon-stroke-1_5"></span>
              <span>Notifications</span>
              <span
                class="badge badge-circle badge-brand"
                v-if="$page.props.auth.notification_count"
              >{{ $page.props.auth.notification_count }}</span>
              <span class="rui-nav-circle"></span>
            </inertia-link>
          </li>
          <!-- <li>
            <inertia-link class="nav-link" :href="$route('admin.my_profile')">
              <span data-feather="user" class="rui-icon rui-icon-stroke-1_5"></span>
              <span>Profile</span>
              <span class="rui-nav-circle"></span>
            </inertia-link>
          </li>-->
          <!-- <li>
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
          </li>-->
          <li>
            <inertia-link method="post" :href="$urlExists('admin.logout') ? $route('admin.logout') : '/logout'" class="nav-link">
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
    name: "MobileAdminHeader",
  };
</script>

<style lang="scss" scoped>
  .rui-navbar-logo {
    img {
      max-width: 300px;
    }
  }
</style>
