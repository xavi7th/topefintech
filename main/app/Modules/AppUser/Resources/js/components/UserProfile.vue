<template>
  <layout title="My Profile" :isAuth="false">
    <div class="container-fluid">
      <div class="rui-profile row vertical-gap">
        <div class="col-lg-6 col-xl-5">
          <div class="card">
            <div class="card-body">
              <div class="row vertical-gap">
                <div class="col-auto">
                  <div class="rui-profile-img">
                    <img src="/img/avatar-1-profile.png" alt />
                  </div>
                </div>
                <div class="col">
                  <div class="rui-profile-info">
                    <h3 class="rui-profile-info-title h4">Jack Boyd</h3>
                    <small class="text-grey-6 mt-2 mb-15">i love beans and dodo</small>
                    <a class="rui-profile-info-mail" href="#">jackboyd@smartscoop.com</a>
                    <a class="rui-profile-info-phone" href="#">+44 987 065 909</a>
                  </div>
                </div>
              </div>
              <div class="rui-profile-numbers">
                <div class="row justify-content-center">
                  <div class="col"></div>
                  <div class="col-auto">
                    <div class="rui-profile-number text-center">
                      <h4 class="rui-profile-number-title h2">Male</h4>
                      <small class="text-grey-6">Gender</small>
                    </div>
                  </div>
                  <div class="col p-0"></div>
                  <div class="col-auto">
                    <div class="rui-profile-number text-center">
                      <h4 class="rui-profile-number-title h2">05, May 1995</h4>
                      <small class="text-grey-6">Date of Birth</small>
                    </div>
                  </div>
                  <div class="col"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "UserProfile",
    mixins: [mixins],
    components: {
      Layout
    },
    data: () => {
      return {};
    }
  };
</script>

<style lang="scss" scoped>
  .card {
    &.rounded {
      border-radius: 5px;
    }
  }
</style>
