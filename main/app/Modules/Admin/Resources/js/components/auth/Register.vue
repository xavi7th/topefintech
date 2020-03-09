<template>
  <div class="rui-sign align-items-center justify-content-center">
    <div class="bg-image">
      <div class="bg-grey-1"></div>
    </div>
    <div class="form rui-sign-form rui-sign-form-cloud">
      <div class="row vertical-gap sm-gap justify-content-center">
        <div class="col-12">
          <h1 class="display-4 mb-10 text-center">Sign Up</h1>
        </div>
        <div class="col-12">
          <input
            class="form-control"
            :class="{'has-error': errors.has('full_name')}"
            placeholder="Name"
            v-model="details.full_name"
            v-validate="'required|alpha_spaces'"
            data-vv-as="name"
            name="full_name"
          />
          <div class="invalid-feedback">{{ errors.first('full_name') }}.</div>
        </div>
        <div class="col-12">
          <input
            type="email"
            class="form-control"
            :class="{'has-error': errors.has('email')}"
            placeholder="Email"
            v-model="details.email"
            v-validate="'required|email'"
            name="email"
          />
          <div class="invalid-feedback">{{ errors.first('email') }}.</div>
        </div>
        <div class="col-12">
          <input
            type="password"
            class="form-control"
            :class="{'has-error': errors.has('password')}"
            placeholder="Password"
            v-model="details.password"
            v-validate="'required|alpha_dash|confirmed:password_confirmation'"
            name="password"
          />
          <div class="invalid-feedback">{{ errors.first('password') }}.</div>
        </div>
        <div class="col-12">
          <input
            type="password"
            class="form-control"
            :class="{'has-error': errors.has('password_confirmation')}"
            placeholder="Confirm Password"
            v-validate="'required|alpha_dash'"
            name="password_confirmation"
            ref="password_confirmation"
            data-vv-as="confirmation"
            v-model="details.password_confirmation"
          />
          <div class="invalid-feedback">{{ errors.first('password_confirmation') }}.</div>
        </div>
        <div class="col-12">
          <div class="custom-control custom-checkbox d-flex justify-content-start">
            <input
              type="checkbox"
              class="custom-control-input"
              id="acceptTerms"
              v-validate="'required'"
              name="terms"
              v-model="details.terms"
              data-vv-as="terms and conditions"
            />

            <label
              class="custom-control-label text-grey-5 fs-13"
              for="acceptTerms"
              :class="{'has-error': errors.has('terms')}"
            >
              I have read and
              agree to the
              <a
                href="#"
                class="text-2"
              >terms and conditions.</a>
            </label>
            <div class="invalid-feedback">{{ errors.first('terms') }}.</div>
          </div>
        </div>
        <div class="col-12">
          <button @click="registerUser" class="btn btn-brand btn-block text-center">
            Sign
            up
          </button>
        </div>
        <div class="col-12">
          <div class="rui-sign-or mt-2 mb-5">or</div>
        </div>
        <div class="col-12">
          <ul class="rui-social-links">
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
        </div>
      </div>
    </div>
    <div class="mt-20 text-grey-5">
      Already have an account?
      <router-link to="/login" class="text-2">
        Sign
        In
      </router-link>
    </div>
  </div>
</template>

<script>
  export default {
    name: "RegisterPage",
    data: () => ({
      details: {}
    }),
    mounted() {
      this.$emit("page-loaded");
    },
    methods: {
      registerUser() {
        this.$validator.validateAll().then(result => {
          if (!result) {
            Toast.fire({
              title: "Invalid data! Try again",
              position: "top",
              icon: "error"
            });
          } else {
            BlockToast.fire({
              text: "Accessing your dashboard..."
            });

            axios.post("/api/v1/auth/register", { ...this.details }).then(rsp => {
              if (undefined !== rsp && rsp.status == 201) {
                swal
                  .fire({
                    title: "Account Created",
                    text: "We will take you to your dashboard now",
                    icon: "success"
                  })
                  .then(() => {
                    location.reload();
                  });
              }
            });
          }
        });
      }
    }
  };
</script>

<style lang="scss" scoped>
  .has-error {
    background-color: #fef9fa;
    border-color: #fac6cc;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23ef5164'%3E%3Ccircle cx='6' cy='6' r='4.5'/%3E%3Cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3E%3Ccircle cx='6' cy='8.2' r='.6' fill='%23ef5164' stroke='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);

    & + .invalid-feedback {
      display: block;
      position: absolute;
      bottom: 9px;
      right: 15%;
      width: auto;
    }

    &:focus + .invalid-feedback {
      display: none;
    }

    &.custom-control-label {
      background: none;
      padding: 0;

      & + .invalid-feedback {
        bottom: -10px;
        right: auto;
        width: auto;
        left: 16%;
      }
      &::before {
        background-color: #fac6cc;
        border-color: #fac6cc;
      }
    }
  }
</style>
