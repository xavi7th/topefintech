<template>
  <!-- header -->
  <header class="header layout-top-menu-dark">
    <div class="header-top">
      <div class="container">
        <!-- header left -->
        <div class="header-left">
          <div class="header-logo logo-type">
            <router-link :to="{name:'dashboard.root'}">24fxMining</router-link>
          </div>
        </div>
        <!-- header left #end -->

        <!-- header right -->
        <div class="header-right">
          <!-- dropdown  -->
          <div class="dropdown-logged-user dropdown">
            <a href data-toggle="dropdown" class="avatar dropdown-toggle">
              <img :src="userDetails.id_card" class="img-responsive" alt="..." />
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <ul>
                <!-- <li>
                  <router-link :to="{name:'dashboard.profile'}" class="dropdown-item">
                    <i class="fas fa-user-circle"></i> My Profile
                  </router-link>
                </li>-->

                <li>
                  <a href="#" class="dropdown-item" @click.prevent="$emit('logout-user')">
                    <i class="fas fa-sign-out-alt"></i> Logout
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- dropdown #end -->
        </div>
        <!-- header right #end -->
      </div>
    </div>
    <div class="header-menu">
      <div class="container">
        <nav class="nav">
          <ul>
            <router-link :to="{name:'dashboard.root'}" tag="li">
              <a>
                <i class="fas fa-th-large icon"></i>
                <span>Dashboard</span>
              </a>
            </router-link>
            <!-- <router-link :to="{name:'dashboard.invest'}" tag="li">
              <a>
                <i class="fab fa-gg icon"></i>
                <span>Make Investment</span>
              </a>
            </router-link>-->
            <router-link :to="{name:'dashboard.withdraw'}" tag="li">
              <a>
                <i class="fas fa-money-bill-wave icon"></i>
                <span>Make Withdrawal</span>
              </a>
            </router-link>
          </ul>
        </nav>
      </div>
    </div>
  </header>
  <!-- header #end -->
</template>

<script>
  export default {
    computed: {
      userDetails() {
        return JSON.parse(sessionStorage.getItem("userDetails")) || {};
      }
    }
  };
</script>

<style lang="scss" scoped>
  .header-menu {
    .nav {
      > ul {
        justify-content: space-evenly;

        li {
          padding: 0 25px;
          transition: 300ms ease background-color;

          &:hover,
          &.active {
            background-color: #2b1e93;
          }
        }
      }
    }
  }
</style>
