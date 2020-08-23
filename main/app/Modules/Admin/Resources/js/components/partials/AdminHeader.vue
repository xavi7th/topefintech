<template>
  <nav class="rui-navbar rui-navbar-top rui-navbar-sticky">
    <div class="rui-navbar-brand">
      <inertia-link
        :href="$urlExists('admin.dashboard') ? $route('admin.dashboard') : $route('agent.dashboard')"
        class="rui-navbar-logo"
      >
        <img
          src="/img/logo.png"
          data-src-night="/img/logo.png"
          data-src-day="/img/logo.png"
          alt="site logo"
          width="80%"
        />
      </inertia-link>
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
              <img src="/img/avatar.png" alt="admin avatar" />
            </a>
            <ul class="nav dropdown-menu">
              <li>
                <inertia-link
                  class="nav-link"
                  :href="$urlExists('admin.notifications') ? $route('admin.notifications') : $route('agent.notifications')"
                >
                  <span data-feather="bell" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Notifications</span>
                  <span
                    class="badge badge-circle badge-brand"
                    v-if="$page.auth.notification_count"
                  >{{ $page.auth.notification_count }}</span>
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
              <!--<li>
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
                <inertia-link method="post" href="/logout" class="nav-link">
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
    name: "AdminDashboardHeader",
  };
</script>

<style lang="scss" scoped>
</style>
