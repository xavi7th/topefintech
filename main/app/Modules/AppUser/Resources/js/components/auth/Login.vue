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
          <h2 class="display-4 mb-10 text-center">Sign In</h2>
          <p>Login to SmartMonie</p>
        </div>
        <div class="col-12">
          <input
            type="text"
            class="form-control"
            :class="{'is-invalid': errors.phone, 'is-valid': !errors.phone}"
            id="form-mail"
            v-model="details.phone"
            name="phone"
            placeholder="Phone Number"
          />
          <div class="invalid-feedback" v-if="errors.phone">{{errors.phone[0]}}</div>
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
        <inertia-link :href="$route('app.register.show')" class="text-2">Get one fast</inertia-link>
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
      formSubmitted: false,
    }),
    mixins: [mixins],
    props: ["errors"],
    components: { Layout },
    methods: {
      loginUser() {
        BlockToast.fire({
          text: "Accessing your dashboard...",
        });

        this.$inertia
          .post(this.$route("appuser.login"), { ...this.details },{
            onSuccess: page => {
               if (page.props.flash.error === 416) {
                swalPreconfirm
                  .fire({
                    title: "Enter OTP",
                    html:
                      "Sorry buddy, <br> Your account has not been verified. <br> Enter your OTP.",
                    input: "text",
                    inputAttributes: {
                      autocapitalize: "off",
                    },
                    confirmButtonText: "Validate",
                    preConfirm: (otp) => {
                      return this.$inertia
                        .post(this.$route("appuser.otp.verify"), { otp },{
                          onFinish:()=>true
                        })

                        .catch((error) => {
                          if (error.response) {
                            swal.showValidationMessage(
                              `Error: ${error.response.data.message}`
                            );
                          } else {
                            swal.showValidationMessage(
                              `Request failed: ${error}`
                            );
                          }
                        });
                    },
                  })
                  .then((val) => {
                    if (val.isDismissed) {
                      Toast.fire({
                        title: "Canceled",
                        icon: "info",
                        position: "center",
                      });
                    }
                  });
              } else if (this.flash.error === 406) {
                swal
                  .fire({
                    title: "One more thing!",
                    text: `This seems to be your first login. You need to supply a password`,
                    icon: "info",
                  })
                  .then(() => {
                    swal
                      .fire({
                        title: "Enter a password",
                        input: "text",
                        inputAttributes: {
                          autocapitalize: "off",
                        },
                        showCancelButton: true,
                        confirmButtonText: "Set Password",
                        showLoaderOnConfirm: true,
                        preConfirm: (pw) => {
                          return this.$inertia
                            .post(this.$route("app.password.new"), {
                              pw,
                              phone: this.details.phone,
                            },{
                              OnSuccess:() => swal.close(),
                              OnFinish:() => { rsp: true },
                            })
                        },
                        allowOutsideClick: () => !swal.isLoading(),
                      })
                      .then((result) => {
                        console.log(result);

                        if (result.dismiss) {
                          swal.fire({
                            title: "Cancelled",
                            text: "You can´t login without setting a password",
                            icon: "info",
                          });
                        }
                      });
                  });
              }
            },
            onFinish:()=>{
              location.reload();
              this.$page.props.flash.error = null;
            },
            onError: () => {
              this.formSubmitted = true
            }
          })
      },
    },
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
