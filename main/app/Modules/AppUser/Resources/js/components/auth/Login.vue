<template>
  <layout :isAuth="true" title="Login">
    <form @submit.prevent="loginUser" :class="{'was-validated': formSubmitted}" novalidate>
      <div class="row vertical-gap sm-gap justify-content-center">
        <div class="header-logo logo-type no-margin col-12 display-3 text-center">
          <a :href="$route('app.home')">
            <img src="/img/logo.png" :alt="`${$page.app.name} logo`" width="50%" />
          </a>
        </div>
        <div class="col-12">
          <h2 class="display-4 mb-10 text-center">Create Account</h2>
          <p>Login to your dashboard to access your smartcoop features</p>
          <FlashMessage />
        </div>
        <div class="col-12">
          <input
            type="email"
            class="form-control"
            :class="{'is-invalid': errors.email, 'is-valid': !errors.email}"
            id="form-mail"
            v-model="details.email"
            name="email"
            placeholder="Email"
          />
          <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
        </div>
        <div class="col-12">
          <input
            type="password"
            class="form-control"
            :class="{'is-invalid': errors.password, 'is-valid': !errors.password}"
            id="form-pass"
            v-model="details.password"
            name="password"
            placeholder="Password"
          />
          <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
        </div>
        <div class="col-sm-6">
          <div class="custom-control custom-checkbox d-flex justify-content-start">
            <input
              type="checkbox"
              class="custom-control-input"
              v-model="details.remember"
              id="rememberMe"
            />
            <label class="custom-control-label fs-13" for="rememberMe">Remember me</label>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <inertia-link
              :href="$route('appuser.password_reset.request')"
              class="fs-13"
            >Forgot password?</inertia-link>
          </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-brand btn-block text-center">Sign in</button>
        </div>
        <!-- <div class="col-12">
          <div class="rui-sign-or mt-2 mb-5">or</div>
        </div>
        <div class="col-12">
          <ul class="rui-social-links text-center">
            <li>
              <a href="#" class="rui-social-github">
                <span class="fab fa-github"></span> Github
              </a>
            </li>
            <li>
              <a href="#" class="rui-social-facebook">
                <span class="fab fa-facebook-f"></span> Facebook
              </a>
            </li>
            <li>
              <a href="#" class="rui-social-google">
                <span class="fab fa-google"></span> Google
              </a>
            </li>
          </ul>
        </div>-->
      </div>
      <div class="mt-20 text-grey-5 text-center">
        Don't have an account?
        <inertia-link :href="$route('app.create_account')" class="text-2">Get one fast</inertia-link>
      </div>
    </form>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "LoginPage",
    remember: ["details"],
    data: () => ({
      details: {},
      formSubmitted: false
    }),
    mixins: [mixins],
    props: ["errors"],
    components: { Layout },
    methods: {
      loginUser() {
        BlockToast.fire({
          text: "Accessing your dashboard..."
        });

        this.$inertia
          .post(this.$route("appuser.login"), { ...this.details })
          .then(rsp => {
            if (_.size(this.errors)) {
              this.formSubmitted = true;
            }

            if (this.$page.flash.error) {
              ToastLarge.fire({
                title: "Oops!",
                html: this.$page.flash.error,
                icon: "error",
                timer: 10000,
                footer: `Our email: &nbsp;&nbsp;&nbsp; <a target="_blank" href="mailto:hello@smartcoophq.org">hello@smartcoophq.org</a>`
              }).then(() => {});
            } else {
              swal.close();
            }
            this.$page.flash.error = null;
          });
      }
    }
  };
</script>

<style lang="scss">
  .rui-sign .rui-sign-form-cloud {
    max-width: 450px;
  }
  .was-validated {
    .form-control.is-invalid {
      background-color: #fef9fa !important;
      border-color: #fac6cc !important;
    }
  }
</style>
