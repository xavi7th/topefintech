<template>
  <div class="rui-sign align-items-center justify-content-center">
    <div class="bg-image">
      <div class="bg-grey-1"></div>
    </div>
    <div class="form rui-sign-form rui-sign-form-cloud">
      <div class="row vertical-gap sm-gap justify-content-center">
        <div class="col-12">
          <h1 class="display-4 mb-10 text-center">Sign In</h1>
        </div>
        <div class="col-12">
          <input
            type="email"
            class="form-control"
            id="email"
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
            id="password"
            :class="{'has-error': errors.has('password')}"
            placeholder="Password"
            v-model="details.password"
            v-validate="'required'"
            name="password"
          />
          <div class="invalid-feedback">{{ errors.first('password') }}.</div>
        </div>
        <div class="col-sm-6">
          <div class="custom-control custom-checkbox d-flex justify-content-start">
            <input
              type="checkbox"
              class="custom-control-input"
              id="rememberMe"
              v-model="details.remember"
            />
            <label class="custom-control-label fs-13" for="rememberMe">Remember me</label>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-end">
            <a href="#" class="fs-13">Forgot password?</a>
          </div>
        </div>
        <div class="col-12">
          <button @click="loginUser" class="btn btn-brand btn-block text-center">
            Sign
            in
          </button>
        </div>
        <div class="col-12">
          <div class="rui-sign-or mt-2 mb-5">or</div>
        </div>
        <div class="col-12">
          <ul class="rui-social-links">
            <li>
              <a href="dashboard.html" class="rui-social-github">
                <span class="fab fa-github"></span> Github
              </a>
            </li>
            <li>
              <a href="dashboard.html" class="rui-social-facebook">
                <span class="fab fa-facebook-f"></span> Facebook
              </a>
            </li>
            <li>
              <a href="dashboard.html" class="rui-social-google">
                <span class="fab fa-google"></span> Google
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="mt-20 text-grey-5">
      Don't you have an account?
      <router-link to="/register" class="text-2">
        Sign
        Up
      </router-link>
    </div>
  </div>
</template>

<script>
  export default {
    mounted() {
      this.$emit("page-loaded");
      sessionStorage.removeItem("token");
    },
    data: () => ({
      details: {}
    }),
    methods: {
      loginUser() {
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

            axios
              .post("/api/v1/auth/login", { ...this.details })
              .then(({ status, data: { access_token } }) => {
                if (undefined !== status && status == 202) {
                  // swal.close();
                  sessionStorage.setItem("token", access_token);
                  location.reload();
                } else if (undefined !== status && status == 205) {
                  swal
                    .fire({
                      title: "Suspended Account",
                      text: rsp.data.msg,
                      icon: "warning"
                    })
                    .then(() => {
                      location.reload();
                    });
                }
              })
              .catch(err => {
                if (undefined !== err.response && err.response.status == 416) {
                  swal
                    .fire({
                      title: "Unverified",
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
                            return axios
                              .post("first-time", {
                                pw,
                                email: this.details.email
                              })
                              .then(response => {
                                if (response.status !== 204) {
                                  throw new Error(response.statusText);
                                }
                                return { rsp: true };
                              })
                              .catch(error => {
                                swal.showValidationMessage(
                                  `Request failed: ${error}`
                                );
                              });
                          },
                          allowOutsideClick: () => !swal.isLoading()
                        })
                        .then(result => {
                          if (result.value) {
                            swal
                              .fire({
                                title: `Success`,
                                text: "Password set successfully!",
                                icon: "success"
                              })
                              .then(() => {
                                location.reload();
                              });
                          }
                        });
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
  }
</style>
