<template>
  <layout :isAuth="true" title="Login">
    <form
      @submit.prevent="requestPasswordResetLink"
      :class="{'was-validated': formSubmitted}"
      novalidate
    >
      <div class="row vertical-gap sm-gap justify-content-center">
        <div class="header-logo logo-type no-margin col-12 display-3 text-center">
          <a :href="$route('app.home')">
            <img src="/img/logo.png" :alt="`${$page.app.name} logo`" width="50%" />
          </a>
        </div>
        <div class="col-12">
          <h2 class="display-4 mb-10 text-center">Forgot Login Password</h2>
          <p>Enter your login email to request a password reset link</p>
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
          <button type="submit" class="btn btn-brand btn-block text-center">Request Password Reset</button>
        </div>
      </div>
      <div class="mt-20 text-grey-5 text-center">
        Don't have an account?
        <inertia-link :href="$route('app.create_account')" class="text-2">Get started easily</inertia-link>
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
      requestPasswordResetLink() {
        BlockToast.fire({
          text: "Sending password link ..."
        });

        this.$inertia
          .post(this.$route("appuser.password_reset.request"), {
            ...this.details
          })
          .then(rsp => {
            if (_.size(this.errors)) {
              this.formSubmitted = true;
            } else if (this.$page.flash.success) {
              ToastLarge.fire({
                title: "Done",
                icon: "info",
                html: this.$page.flash.success,
                timer: 10000
              }).then(() => {
                this.$page.flash.success = null;
              });
            } else {
              swal.close();
            }
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
