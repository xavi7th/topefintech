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
          <h2 class="display-4 mb-10 text-center">Sign In</h2>
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
          <FlashMessage v-if="errors.email" :msg="errors.email[0]" />
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
          <FlashMessage v-if="errors.password" :msg="errors.password[0]" />
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
        <div class="col-12">
          <button type="submit" class="btn btn-brand btn-block text-center">Access Admin Panel</button>
        </div>
      </div>
    </form>
  </layout>
</template>

<script>
  import Layout from "@dashboard-assets/js/AppComponent";
  import { mixins } from "@dashboard-assets/js/config";
  export default {
    mixins: [mixins],
    // props: ["errors", "flash"],
    components: { Layout },
    data: () => ({
      details: {},
      formSubmitted: false
    }),

    methods: {
      loginUser() {
        BlockToast.fire({
          text: "Unlocking admin dashboard..."
        });

        this.$inertia
          .post(this.$route("admin.login"), { ...this.details })
          .then(rsp => {
            if (_.size(this.errors)) {
              this.formSubmitted = true;
              swal.close();
            } else if (this.flash.error) {
              if (this.flash.error.suspended) {
                swal.fire({
                  title: "Suspended Account",
                  text: this.flash.error.suspended,
                  icon: "warning"
                });
              } else if (this.flash.error.unverified) {
                swal
                  .fire({
                    title: "One more thing!",
                    text: `This seems to be your first login. You need to supply a password`,
                    icon: "info"
                  })
                  .then(() => {
                    swal
                      .fire({
                        title: "Enter a password",
                        input: "text",
                        inputAttributes: {
                          autocapitalize: "off"
                        },
                        showCancelButton: true,
                        confirmButtonText: "Set Password",
                        showLoaderOnConfirm: true,
                        preConfirm: pw => {
                          return this.$inertia
                            .post(this.$route("admin.password.new"), {
                              pw,
                              email: this.details.email
                            })
                            .then(() => {
                              swal.close();
                              return { rsp: true };
                            });
                        },
                        allowOutsideClick: () => !swal.isLoading()
                      })
                      .then(result => {
                        console.log(result);

                        if (result.value) {
                          swal.fire({
                            title: `Success`,
                            text: "Password set successfully!",
                            icon: "success"
                          });
                        } else if (result.dismiss) {
                          swal.fire({
                            title: "Cancelled",
                            text: "You can´t login without setting a password",
                            icon: "info"
                          });
                        }
                      });
                  });
              }
            } else {
              swal.close();
            }
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
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
