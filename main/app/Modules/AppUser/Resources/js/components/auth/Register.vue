<template>
  <layout :isAuth="true" title="Register Account">
    <form @submit.prevent="createAccount" :class="{'was-validated': formSubmitted}" novalidate>
      <div class="row vertical-gap sm-gap justify-content-center">
        <div class="header-logo logo-type no-margin col-12 display-3 text-center">
          <a :href="$route('app.home')">
            <img src="/img/logo.png" :alt="`${$page.app.name} logo`" width="50%" />
          </a>
        </div>
        <div class="col-12">
          <h2 class="display-4 mb-10 text-center">Create Account</h2>
          <p>Invest specific Projects and the your returns in 6 to 12 months</p>
        </div>
        <div class="col-12">
          <input
            type="text"
            class="form-control"
            :class="{'is-invalid': errors.first_name, 'is-valid': !errors.first_name}"
            id="form-first_name"
            v-model="details.first_name"
            name="first_name"
            placeholder="First Name"
          />
          <div class="invalid-feedback" v-if="errors.first_name">{{errors.first_name[0]}}</div>
        </div>
        <div class="col-12">
          <input
            type="text"
            class="form-control"
            :class="{'is-invalid': errors.middle_name, 'is-valid': !errors.middle_name}"
            id="form-middle_name"
            v-model="details.middle_name"
            name="middle_name"
            placeholder="Middle Name"
          />
          <div class="invalid-feedback" v-if="errors.middle_name">{{errors.middle_name[0]}}</div>
        </div>
        <div class="col-12">
          <input
            type="text"
            class="form-control"
            :class="{'is-invalid': errors.last_name, 'is-valid': !errors.last_name}"
            id="form-last_name"
            v-model="details.last_name"
            name="last_name"
            placeholder="Last Name"
          />
          <div class="invalid-feedback" v-if="errors.last_name">{{errors.last_name[0]}}</div>
        </div>
        <div class="col-12">
          <input
            type="text"
            class="form-control"
            :class="{'is-invalid': errors.phone, 'is-valid': !errors.phone}"
            id="form-phone"
            v-model="details.phone"
            name="phone"
            placeholder="Phone"
          />
          <div class="invalid-feedback" v-if="errors.phone">{{errors.phone[0]}}</div>
        </div>
        <div class="col-12">
          <input
            type="email"
            class="form-control"
            :class="{'is-invalid': errors.email, 'is-valid': !errors.email}"
            id="form-email"
            v-model="details.email"
            name="name"
            placeholder="Email (optional)"
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

        <div class="col-12">
          <input
            type="password"
            class="form-control"
            :class="{'is-invalid': errors.password_confirmation, 'is-valid': !errors.password_confirmation}"
            id="form-pass-confirm"
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
          <input
            type="ref-code"
            class="form-control"
            :class="{'is-invalid': errors.ref_code, 'is-valid': !errors.ref_code}"
            id="form-pass-confirm"
            v-model="details.ref_code"
            name="ref_code"
            placeholder="Smart Collector Code"
          />
          <div class="invalid-feedback" v-if="errors.ref_code">{{errors.ref_code[0]}}</div>
        </div>

        <div class="col-sm-12">
          <div class="custom-control custom-checkbox d-flex justify-content-start flex-wrap">
            <input
              type="checkbox"
              class="custom-control-input"
              :class="{'is-invalid': errors.agreement, 'is-valid': !errors.agreement}"
              v-model="details.agreement"
              id="agreement"
            />
            <label class="custom-control-label fs-13" for="agreement">
              I have read and accepted the
              <a :href="$route('app.terms')">terms and conditions</a>
            </label>
            <div class="invalid-feedback" v-if="errors.agreement">{{errors.agreement[0]}}</div>
          </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-brand btn-block text-center">Sign Up</button>
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
        Do you have an account?
        <inertia-link :href="$route('app.login')" class="text-2">Sign In</inertia-link>
      </div>
    </form>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    mixins: [mixins],
    props: ["errors"],
    components: { Layout },
    remember: ["details"],
    data: () => ({
      formSubmitted: false,
      details: {},
    }),
    methods: {
      createAccount() {
        this.formSubmitted == false;
        BlockToast.fire({
          text: "Setting up your account...",
        });
        let formData = new FormData();

        _.forEach(this.details, (val, key) => {
          formData.append(key, val);
        });

        this.$inertia
          .post(this.$route("appuser.register"), formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((rsp) => {
            if (_.size(this.errors) == 0) {
              console.log("cuccess");

              ToastLarge.fire({
                title: "Congrats",
                html:
                  "Your account has been created. A verification mail has been sent to your email.",
                timer: 20000,
              });
            } else {
              swal.close();
            }
            this.formSubmitted = true;
          });
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
