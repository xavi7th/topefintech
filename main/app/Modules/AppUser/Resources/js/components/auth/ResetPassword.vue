<template>
  <layout :isAuth="true" title="Login">
    <form @submit.prevent="loginUser" :class="{'was-validated': formSubmitted}" novalidate>
      <div class="row vertical-gap sm-gap justify-content-center">
        <div class="header-logo logo-type no-margin col-12 display-3 text-center">
          <a :href="$route('app.home')">
            <img src="/img/logo.png" :alt="`${$page.props.app.name} logo`" width="50%" />
          </a>
        </div>
        <div class="col-12">
          <h2 class="display-4 mb-10 text-center">Reset Password</h2>
          <p>Enter a new password to reset your password</p>
          <FlashMessage />
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

        <div class="col-12">
          <input
            type="password"
            class="form-control"
            :class="{'is-invalid': errors.password, 'is-valid': !errors.password_confirmation}"
            id="form-pass"
            v-model="details.password_confirmation"
            name="password_confirmation"
            placeholder="Confirm Password"
          />
          <div
            class="invalid-feedback"
            v-if="errors.password_confirmation"
          >{{errors.password_confirmation[0]}}</div>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-brand btn-block text-center">Reset Password</button>
        </div>
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
    props: ["errors", "token"],
    components: { Layout },
    methods: {
      loginUser() {
        BlockToast.fire({
          text: "resetting your password..."
        });

        this.$inertia
          .put(this.$route("auth.password_reset.change_password"), {
            ...this.details,
            token: this.token
          },{
            onError:() => this.formSubmitted = true
          })
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
