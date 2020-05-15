<template>
  <div class="yaybar yay-hide-to-small yay-shrink yay-gestures rui-yaybar">
    <div class="yay-wrap-menu">
      <div class="yaybar-wrap">
        <ul>
          <li class="yay-label">Get Started</li>
          <li class="yay-item-active">
            <a href="dashboard.html">
              <span class="yay-icon">
                <!-- <span class="fa fa-home"></span> -->
                <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span>
              </span>
              <span>Dashboard</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="savings.html">
              <span class="yay-icon">
                <span class="fas fa-wallet"></span>
                <!-- <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span> -->
              </span>

              <span>Savings</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="statement.html">
              <span class="yay-icon">
                <span data-feather="file-text" class="rui-icon rui-icon-stroke-1_5"></span>
              </span>
              <span>Statement</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="smartloan.html">
              <span class="yay-icon">
                <span class="fas fa-money-check"></span>
                <!-- <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span> -->
              </span>
              <span>SmartLoan</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="withdraw.html">
              <span class="yay-icon">
                <span class="fas fa-money-bill-wave"></span>
                <!-- <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span> -->
              </span>
              <span>Withdraw</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="smartinterest.html">
              <span class="yay-icon">
                <span class="fas fa-money-check-alt"></span>
                <!-- <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span> -->
              </span>
              <span>SmartInterest</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="bank_account.html">
              <span class="yay-icon">
                <span class="fa fa-suitcase"></span>
                <!-- <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span> -->
              </span>
              <span>Bank Account</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="my_cards.html">
              <span class="yay-icon">
                <span class="far fa-credit-card"></span>
                <!-- <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span> -->
              </span>
              <span>My Cards</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="bvn.html">
              <span class="yay-icon">
                <span class="fa fa-qrcode"></span>
                <!-- <span data-feather="home" class="rui-icon rui-icon-stroke-1_5"></span> -->
              </span>
              <span>BVN Validation</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li class="yay-label">Personal</li>
          <li>
            <a href="profile.html">
              <span class="yay-icon">
                <span class="fa fa-user"></span>
                <!-- <span data-feather="user" class="rui-icon rui-icon-stroke-1_5"></span> -->
              </span>
              <span>Profile</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="messages.html">
              <span class="yay-icon">
                <span data-feather="mail" class="rui-icon rui-icon-stroke-1_5"></span>
              </span>
              <span>Messages</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
          <li>
            <a href="gos_plans.html">
              <span class="yay-icon">
                <span class="far fa-folder"></span>
              </span>
              <span>GOS Plans</span>
              <span class="rui-yaybar-circle"></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "UserDashboardNav",
    mounted() {
      // this.$loadScript("/js/user-dashboard-nav.js").then(() => {
      //   this.isLoading = false;
      // });
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
