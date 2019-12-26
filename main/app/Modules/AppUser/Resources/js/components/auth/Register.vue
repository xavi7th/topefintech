<template>
  <div class="plyenz-main bg-primary">
    <div class="auth-box card-animation">
      <div class="auth-logo">
        <div class="header-logo logo-type no-margin">
          <a href="/">SampleSite</a>
        </div>
      </div>
      <div class="auth-desc">
        <p class="mb-0">
          <span>Welcome,</span> register now.
        </p>
      </div>
      <form @submit.prevent="createAccount">
        <div class="form-group mb-20">
          <label for="form-name">
            <strong>Full Name</strong>
          </label>
          <input
            type="text"
            class="form-control form-control-pill"
            id="form-name"
            v-model="details.name"
            v-validate="'required'"
            name="name"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-mail">
            <strong>E-Mail</strong>
          </label>
          <input
            type="email"
            class="form-control form-control-pill"
            id="form-mail"
            v-model="details.email"
            v-validate="'required|email'"
            name="email"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-pass">
            <strong>Password</strong>
          </label>
          <input
            type="password"
            class="form-control form-control-pill"
            id="form-pass"
            v-model="details.password"
            v-validate="'required|min:6'"
            name="password"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-pass2">
            <strong>Confirm Password</strong>
          </label>
          <input
            type="password"
            class="form-control form-control-pill"
            id="form-pass2"
            v-model="details.password_confirmation"
            v-validate="'required'"
            name="password_confirmation"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-phone">
            <strong>Phone</strong>
          </label>
          <input
            type="text"
            class="form-control form-control-pill"
            id="form-phone"
            v-model="details.phone"
            v-validate="'required'"
            name="phone"
          />
        </div>
        <div class="form-group mb-20">
          <label for="form-id-card">
            <strong>Upload your ID Card</strong>
          </label>
          <input
            type="file"
            id="form-id-card"
            v-validate="'required'"
            name="id_card"
            ref="id_card"
            @change="attachFile"
            accept="image/*, application/pdf"
          />
          <label for="form-id-card">{{ details.fileUploadName }}</label>
        </div>
        <!-- <div class="form-group mb-20">
          <label for="form-country">
            <strong>Country</strong>
          </label>
          <select
            name="country"
            id="country"
            v-model="details.country"
            class="form-control form-control-pill select-css"
            :class="{'filled': details.country}"
            v-validate="'required'"
          >
            <option :value="null">Select Country</option>
            <option v-for="country in countriesList" :key="country">{{ country }}</option>
          </select>
        </div>-->
        <!-- <div class="form-group mb-20">
          <label for="form-currency">
            <strong>Currency</strong>
          </label>
          <select
            name="currency"
            id="currency"
            v-model="details.currency"
            class="form-control form-control-pill select-css"
            :class="{'filled': details.currency}"
            v-validate="'required'"
          >
            <option :value="null">Select Currency</option>
            <option v-for="currency in basicCurrencies" :key="currency">{{ currency }}</option>
          </select>
        </div>-->

        <div class="form-group">
          <label class="control control-checkbox">
            <span class="text-light">Accept terms and conditions</span>
            <input type="checkbox" v-model="details.agreement" />
            <span class="control-icon"></span>
          </label>
        </div>
        <div class="form-group mt-25">
          <button class="btn btn-primary btn-shadow btn-round btn-block">Register</button>
        </div>
        <div>
          <hr />
          <p class="fs-12 text-center text-light">
            Do you have an account?
            <router-link :to="{name:'dashboard.login'}" class="text-primary">Log In</router-link>
          </p>
        </div>
      </form>
    </div>
  </div>
  <!-- main content #end -->
</template>

<script>
  import { siteRegister } from "@dashboard-assets/js/config";
  import { mixins } from "@dashboard-assets/js/config";
  // import countriesList from "@basicsite-assets/js/CountriesList";
  // import { basicCurrencies } from "@basicsite-assets/js/CurrenciesList";
  export default {
    mixins: [mixins],
    data: () => ({
      details: {
        country: null,
        fileUploadName: "Upload your ID Card",
        currency: null
      }
      // basicCurrencies
      // countriesList
    }),
    mounted() {
      this.$emit("page-loaded");
    },
    methods: {
      attachFile() {
        this.details.fileUploadName = this.$refs.id_card.files[0].name;

        this.details.id_card = this.$refs.id_card.files[0];
      },
      createAccount() {
        BlockToast.fire({
          text: "Setting up user account..."
        });
        let formData = new FormData();

        _.forEach(this.details, (val, key) => {
          formData.append(key, val);
        });

        axios
          .post(siteRegister, formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(rsp => {
            if (rsp && rsp.status == 201) {
              swal
                .fire({
                  title: "Success",
                  text: `Check your email for a verification email link.`,
                  icon: "success"
                })
                .then(() => {
                  // location.replace("/login");
                  // swal.close();
                  this.$router.push({ name: "dashboard.login" });
                });
            }
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
  .form-control,
  .btn-round {
    padding: 12px;
  }

  [type="file"] {
    height: 0;
    overflow: hidden;
    width: 0;

    &#file {
      border: none;
      border-radius: 0;
      padding: 0;
    }
  }

  [type="file"] + label {
    // background: #f15d22;
    border: 1px solid #c0c0c0;
    border-radius: 40px;
    color: #686565;
    cursor: pointer;
    display: block;
    font-family: "Poppins", sans-serif;
    font-size: inherit;
    font-weight: 600;
    margin-bottom: 1rem;
    outline: none;
    padding: 0.8rem 20px;
    position: relative;
    transition: all 0.3s;
    vertical-align: middle;
    &:hover {
      background-color: darken(#fff, 5%);
    }
  }

  .select-css {
    height: auto !important;
    display: block;
    font-size: 16px;
    font-family: sans-serif;
    font-weight: 700;
    color: #888;
    line-height: 1.3;
    padding: 12px 12px 12px 20px;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    margin: 0;
    border: 1px solid #ebebeb;
    border-radius: 1.5em;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    background-color: #fff;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
    background-repeat: no-repeat, repeat;
    background-position: right 0.7em top 50%, 0 0;
    background-size: 0.65em auto, 100%;
  }
  .select-css::-ms-expand {
    display: none;
  }
  .select-css:hover {
    border-color: darken(#ebebeb, 10%);
  }
  .select-css:focus {
    border-color: darken(#ebebeb, 5%);
    color: darken(#222, 10%);
  }
  .select-css option {
    font-weight: normal;
  }
</style>
