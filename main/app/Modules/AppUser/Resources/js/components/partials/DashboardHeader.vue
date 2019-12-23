<template>
  <!-- header -->
  <header class="header">
    <div class="header-top">
      <div class="container">
        <!-- header left -->
        <div class="header-left">
          <a href class="side-menu-toggle mr-30">
            <span></span>
            <span></span>
            <span></span>
          </a>
          <div class="header-searchbox d-none d-sm-block">
            <form>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search ..." />
                <button>
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
        <!-- header left #end -->

        <!-- header right -->
        <div class="header-right">
          <!-- dropdown -->
          <div class="dropdown-message dropdown d-none d-sm-block">
            <a href data-toggle="dropdown" class="dropdown-toggle">
              <i class="far fa-envelope"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header">
                <div class="dropdown-title">
                  <h5>Last Mails</h5>
                </div>
                <a href>Show All</a>
              </div>
              <ul class="media-list">
                <li class="dropdown-item">
                  <a href="#">
                    <div class="media-item">
                      <div class="media-circle bg-success">
                        <img src="/img/avatar1.jpg" class="img-responsive" alt="..." />
                      </div>
                      <div class="media-item-text">
                        <span>2018 income-expense report</span>
                        <small>CARL SUCKS</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-item">
                  <a href="#">
                    <div class="media-item">
                      <div class="media-circle bg-success">
                        <img src="/img/avatar2.jpg" class="img-responsive" alt="..." />
                      </div>
                      <div class="media-item-text">
                        <span>Order notification #1344763</span>
                        <small>LISA DEEP</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-item">
                  <a href="#">
                    <div class="media-item">
                      <div class="media-circle bg-success">
                        <img src="/img/avatar3.jpg" class="img-responsive" alt="..." />
                      </div>
                      <div class="media-item-text">
                        <span>About the latest update</span>
                        <small>KEVIN BELL</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-item">
                  <a href="#">
                    <div class="media-item">
                      <div class="media-circle bg-success">
                        <img src="/img/avatar4.jpg" class="img-responsive" alt="..." />
                      </div>
                      <div class="media-item-text">
                        <span>Security settings</span>
                        <small>BETSA MINTHOW</small>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- dropdown #end -->

          <!-- dropdown -->
          <div class="dropdown-notification dropdown">
            <a href data-toggle="dropdown" class="dropdown-toggle">
              <i class="far fa-bell"></i>
              <span class="notification-dot"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header">
                <div class="dropdown-title">
                  <h5>Notifications</h5>
                </div>
                <a href>Show All</a>
              </div>
              <ul class="media-list">
                <li class="dropdown-item">
                  <a href="#">
                    <div class="media-item">
                      <div class="media-circle bg-success">
                        <i class="fas fa-bell"></i>
                      </div>
                      <div class="media-item-text">
                        <span>Carl Jakson added a new product.</span>
                        <small>A Day ago</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-item">
                  <a href="#">
                    <div class="media-item">
                      <div class="media-circle bg-danger">
                        <i class="fas fa-times"></i>
                      </div>
                      <div class="media-item-text">
                        <span>Sales transaction canceled.</span>
                        <small>A Day ago</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-item">
                  <a href="#">
                    <div class="media-item">
                      <div class="media-circle bg-info">
                        <i class="fas fa-user"></i>
                      </div>
                      <div class="media-item-text">
                        <span>Today we have 17 orders</span>
                        <small>A Day ago</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-item">
                  <a href="#">
                    <div class="media-item">
                      <div class="media-circle bg-info">
                        <i class="fas fa-plus"></i>
                      </div>
                      <div class="media-item-text">
                        <span>20+ new products added.</span>
                        <small>A Day ago</small>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- dropdown #end -->

          <!-- dropdown  -->
          <div class="dropdown-logged-user dropdown">
            <a href data-toggle="dropdown" class="avatar dropdown-toggle">
              <img src="/img/avatar1.jpg" class="img-responsive" alt="..." />
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <ul>
                <li>
                  <a href class="dropdown-item">
                    <i class="fas fa-envelope"></i> Inbox
                  </a>
                </li>
                <li>
                  <a href class="dropdown-item">
                    <i class="fas fa-user-circle"></i> My Profile
                  </a>
                </li>
                <li>
                  <a href class="dropdown-item">
                    <i class="fas fa-cog"></i> Profile Settings
                  </a>
                </li>
                <li>
                  <a href class="dropdown-item">
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
  </header>
  <!-- header #end -->
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
