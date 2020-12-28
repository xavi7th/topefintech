<template>
  <layout title="My Profile" :isAuth="false">
    <div class="container-fluid">
      <div class="rui-profile row vertical-gap">
        <div class="col-lg-5 col-xl-4 col-12">
          <div class="card">
            <div class="card-body">
              <div class="row vertical-gap">
                <div class="col-auto">
                  <div class="rui-profile-img">
                    <img
                      :src="$page.props.auth.user.id_card_thumb_url || `/img/avatar.png`"
                      alt="user id card"
                    />
                  </div>
                </div>
                <div class="col">
                  <div class="rui-profile-info">
                    <h3 class="rui-profile-info-title h4">
                      {{ $page.props.auth.user.full_name }}
                    </h3>
                    <small class="text-grey-6 mt-2 mb-15"
                      >Registered: {{ $page.props.auth.user.num_of_days_active }} days
                      ago</small
                    >
                    <a class="rui-profile-info-mail" href="#">{{
                      $page.props.auth.user.email
                    }}</a>
                    <a class="rui-profile-info-phone" href="#">{{
                      $page.props.auth.user.phone
                    }}</a>
                  </div>
                </div>
              </div>
              <div class="rui-profile-numbers">
                <div class="row justify-content-center">
                  <div class="col"></div>
                  <div class="col-auto">
                    <div class="rui-profile-number text-center">
                      <h4 class="rui-profile-number-title h2 text-capitalize">
                        {{ $page.props.auth.user.gender }}
                      </h4>
                      <small class="text-grey-6">Gender</small>
                    </div>
                  </div>
                  <div class="col p-0"></div>
                  <div class="col-auto">
                    <div class="rui-profile-number text-center">
                      <h4 class="rui-profile-number-title h2">
                        {{ $page.props.auth.user.date_of_birth }}
                      </h4>
                      <small class="text-grey-6">Date of Birth</small>
                    </div>
                  </div>
                  <div class="col"></div>
                </div>
              </div>
            </div>
          </div>

          <hr />
        </div>

        <div class="col-12 col-lg-7 col-xl-8">
          <ul class="nav nav-tabs rui-tabs-sliding" role="tablist">
            <li class="nav-item">
              <a
                class="nav-link rui-tabs-link active"
                id="editProfilePage-tab"
                data-toggle="tab"
                href="#editProfilePage"
                role="tab"
                aria-controls="editProfilePage"
                aria-selected="true"
              >
                <span
                  data-feather="user"
                  class="rui-icon rui-icon-stroke-1_5"
                ></span>
                <span>Personal information</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link rui-tabs-link"
                id="editAccountPage-tab"
                data-toggle="tab"
                href="#editAccountPage"
                role="tab"
                aria-controls="editAccountPage"
                ara-selected="false"
              >
                <span
                  data-feather="credit-card"
                  class="rui-icon rui-icon-stroke-1_5"
                ></span>
                <span>Account information</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link rui-tabs-link"
                id="changePasswordPage-tab"
                data-toggle="tab"
                href="#changePasswordPage"
                role="tab"
                aria-controls="changePasswordPage"
                aria-selected="false"
              >
                <span
                  data-feather="key"
                  class="rui-icon rui-icon-stroke-1_5"
                ></span>
                <span>Change Password</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a
                class="nav-link rui-tabs-link"
                id="verifyBVNPage-tab"
                data-toggle="tab"
                href="#verifyBVNPage"
                role="tab"
                aria-controls="verifyBVNPage"
                aria-selected="false"
              >
                <span
                  data-feather="trello"
                  class="rui-icon rui-icon-stroke-1_5"
                ></span>
                <span>BVN</span>
              </a>
            </li> -->
          </ul>
          <div class="tab-content">
            <div
              class="tab-pane fade show active"
              id="editProfilePage"
              role="tabpanel"
              aria-labelledby="editProfilePage-tab"
            >
              <div class="card">
                <div class="card-body">
                  <div
                    class="row vertical-gap sm-gap justify-content-end"
                    :class="{ 'was-validated': formSubmitted }"
                  >
                    <div class="col-8">
                      <label for="full_name">Full Name</label>
                      <input
                        class="form-control"
                        readonly
                        :class="{
                          'is-invalid': $page.props.errors.full_name,
                          'is-valid': !$page.props.errors.full_name,
                        }"
                        v-model="details.full_name"
                        id="full_name"
                        placeholder="Your Full Name"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.full_name"
                        :msg="$page.props.errors.full_name[0]"
                      />
                    </div>
                    <div class="col-4">
                      <label for="full_name">Gender</label>
                      <select
                        name="gender"
                        id="gender"
                        class="form-control"
                        v-model="details.gender"
                        :class="{
                          'is-invalid': $page.props.errors.gender,
                          'is-valid': !$page.props.errors.gender,
                        }"
                      >
                        <option :value="null">Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>

                      <FlashMessage
                        v-if="$page.props.errors.gender"
                        :msg="$page.props.errors.gender[0]"
                      />
                    </div>

                    <div class="col-6">
                      <label for="email">Email</label>
                      <input
                        type="email"
                        class="form-control"
                        :class="{
                          'is-invalid': $page.props.errors.email,
                          'is-valid': !$page.props.errors.email,
                        }"
                        v-model="details.email"
                        id="email"
                        placeholder="Your Email"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.email"
                        :msg="$page.props.errors.email[0]"
                      />
                    </div>

                    <div class="col-6">
                      <label for="phone">Phone Number</label>
                      <input
                        class="form-control"
                        readonly
                        v-model="details.phone"
                        id="phone"
                        placeholder="Your Phone"
                        :class="{
                          'is-invalid': $page.props.errors.phone,
                          'is-valid': !$page.props.errors.phone,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.phone"
                        :msg="$page.props.errors.phone[0]"
                      />
                    </div>

                    <div class="col-12">
                      <label for="address">Address</label>
                      <textarea
                        name="address"
                        id="address"
                        rows="1"
                        class="form-control"
                        :class="{
                          'is-invalid': $page.props.errors.address,
                          'is-valid': !$page.props.errors.address,
                        }"
                        v-model="details.address"
                      ></textarea>
                      <FlashMessage
                        v-if="$page.props.errors.address"
                        :msg="$page.props.errors.address[0]"
                      />
                    </div>

                    <div class="col-6">
                      <label for="city">City</label>
                      <input
                        class="form-control"
                        v-model="details.city"
                        id="city"
                        placeholder="Your city"
                        :class="{
                          'is-invalid': $page.props.errors.city,
                          'is-valid': !$page.props.errors.city,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.city"
                        :msg="$page.props.errors.city[0]"
                      />
                    </div>

                    <div class="col-6">
                      <label for="country">Country</label>
                      <input
                        class="form-control"
                        v-model="details.country"
                        id="country"
                        placeholder="Your country"
                        :class="{
                          'is-invalid': $page.props.errors.country,
                          'is-valid': !$page.props.errors.country,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.country"
                        :msg="$page.props.errors.country[0]"
                      />
                    </div>

                    <div class="col-md-6 col-12">
                      <label for="date_of_birth">Date of Birth</label>
                      <input
                        class="form-control"
                        type="date"
                        v-model="details.date_of_birth"
                        id="date_of_birth"
                        placeholder="Your date_of_birth"
                        :class="{
                          'is-invalid': $page.props.errors.date_of_birth,
                          'is-valid': !$page.props.errors.date_of_birth,
                        }"
                      />

                      <FlashMessage
                        v-if="$page.props.errors.date_of_birth"
                        :msg="$page.props.errors.date_of_birth[0]"
                      />
                    </div>

                    <div class="col-md-6 col-12">
                      <label for="id_card">{{
                        fileUploadName || "Profile Picture"
                      }}</label>
                      <input
                        type="file"
                        class="form-control"
                        @change="attachFile"
                        ref="id_card"
                        id="id_card"
                        placeholder="Your id_card"
                        :class="{
                          'is-invalid': $page.props.errors.id_card,
                          'is-valid': !$page.props.errors.id_card,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.id_card"
                        :msg="$page.props.errors.id_card[0]"
                      />
                    </div>

                    <div class="col-auto">
                      <button
                        class="btn btn-grey-2"
                        type="button"
                        @click="resetUserDetails"
                      >
                        Reset
                      </button>
                    </div>
                    <div class="col-auto">
                      <button
                        class="btn btn-brand"
                        type="button"
                        @click="updateUserProfile"
                      >
                        Update
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="editAccountPage"
              role="tabpanel"
              aria-labelledby="editAccountPage-tab"
            >
              <div class="card">
                <div class="card-body">
                  <div
                    class="row vertical-gap sm-gap justify-content-end"
                    :class="{ 'was-validated': formSubmitted }"
                  >
                    <div class="col-12">
                      <label for="acc_num">Account Name</label>
                      <input
                        v-if="!$page.props.auth.user.is_bank_verified"
                        class="form-control"
                        :value="details.acc_name"
                        id="acc_name"
                        disabled
                      />
                      <span v-else class="d-block form-control">{{
                        $page.props.auth.user.account_name
                      }}</span>

                      <FlashMessage
                        v-if="$page.props.errors.acc_name"
                        :msg="$page.props.errors.acc_name[0]"
                      />
                    </div>

                    <div class="col-12">
                      <label for="acc_num">Account Number</label>
                      <input
                        class="form-control"
                        v-if="!$page.props.auth.user.is_bank_verified"
                        :class="{
                          'is-invalid': $page.props.errors.acc_num,
                          'is-valid': !$page.props.errors.acc_num,
                        }"
                        v-model="details.acc_num"
                        id="acc_num"
                        placeholder="Account Number"
                      />
                      <span v-else class="d-block form-control">{{
                        $page.props.auth.user.account_number
                      }}</span>

                      <FlashMessage
                        v-if="$page.props.errors.acc_num"
                        :msg="$page.props.errors.acc_num[0]"
                      />
                    </div>

                    <div class="col-12">
                      <label for="acc_bank">Bank Name</label>
                      <select
                        v-if="!$page.props.auth.user.is_bank_verified"
                        class="form-control"
                        v-model="details.acc_bank"
                        id="acc_bank"
                        :class="{
                          'is-invalid': $page.props.errors.acc_bank,
                          'is-valid': !$page.props.errors.acc_bank,
                        }"
                      >
                        <option :value="null">Select</option>
                        <option v-for="(bank, idx) in banks" :key="idx">
                          {{ bank }}
                        </option>
                      </select>
                      <span v-else class="d-block form-control">{{
                        $page.props.auth.user.bank
                      }}</span>
                      <FlashMessage
                        v-if="$page.props.errors.acc_bank"
                        :msg="$page.props.errors.acc_bank[0]"
                      />
                    </div>

                    <div class="col-auto">
                      <button
                        class="btn btn-success"
                        type="button"
                        @click="validateBankName"
                        :disabled="!details.acc_num && !details.acc_bank"
                        v-if="!$page.props.auth.user.is_bank_verified"
                      >
                        Validate Account
                      </button>

                      <button
                        class="btn btn-brand"
                        type="button"
                        @click="updateUserProfile"
                        :disabled="!details.acc_num"
                        v-if="!$page.props.auth.user.is_bank_verified"
                      >
                        Update
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="tab-pane fade"
              id="changePasswordPage"
              role="tabpanel"
              aria-labelledby="changePasswordPage-tab"
            >
              <div class="card">
                <div class="card-body">
                  <div
                    class="row vertical-gap sm-gap justify-content-end"
                    :class="{ 'was-validated': formSubmitted }"
                  >
                    <div class="col-12">
                      <label for="current_password">Current Password</label>
                      <input
                        type="password"
                        class="form-control"
                        :class="{
                          'is-invalid': $page.props.errors.current_password,
                          'is-valid': !$page.props.errors.current_password,
                        }"
                        v-model="details.current_password"
                        id="current_password"
                        placeholder="Current Password"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.current_password"
                        :msg="$page.props.errors.current_password[0]"
                      />
                    </div>

                    <div class="col-6">
                      <label for="password">New Password</label>
                      <input
                        type="password"
                        class="form-control"
                        :class="{
                          'is-invalid': $page.props.errors.password,
                          'is-valid': !$page.props.errors.password,
                        }"
                        v-model="details.password"
                        id="password"
                        placeholder="Your password"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.password"
                        :msg="$page.props.errors.password[0]"
                      />
                    </div>

                    <div class="col-6">
                      <label for="password_confirmation"
                        >Confirm Password</label
                      >
                      <input
                        type="password"
                        class="form-control"
                        v-model="details.password_confirmation"
                        id="password_confirmation"
                        placeholder="Confirm Password"
                        :class="{
                          'is-invalid': $page.props.errors.password_confirmation,
                          'is-valid': !$page.props.errors.password_confirmation,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.password_confirmation"
                        :msg="$page.props.errors.password_confirmation[0]"
                      />
                    </div>

                    <div class="col-auto">
                      <button
                        class="btn btn-brand"
                        type="button"
                        @click="updateUserProfile"
                        :disabled="!details.password"
                      >
                        Update
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div
              class="tab-pane fade"
              id="verifyBVNPage"
              role="tabpanel"
              aria-labelledby="verifyBVNPage-tab"
            >
              <div class="card">
                <div class="card-body">
                  <div
                    class="row vertical-gap sm-gap justify-content-end"
                    :class="{ 'was-validated': formSubmitted }"
                    v-if="!$page.props.auth.user.is_bvn_verified"
                  >
                    <div class="col-12">
                      <label for="bvn">Enter BVN for Verification</label>
                      <input
                        type="text"
                        class="form-control"
                        :class="{
                          'is-invalid': $page.props.errors.bvn,
                          'is-valid': !$page.props.errors.bvn,
                        }"
                        v-model="details.bvn"
                        id="bvn"
                        placeholder="Enter your BVN Number"
                      />
                      <FlashMessage
                        v-if="$page.props.errors.bvn"
                        :msg="$page.props.errors.bvn[0]"
                      />
                      <img
                        src="/img/paystack_preview.png"
                        alt="secured by paystack"
                        class="paystack-logo"
                      />

                      <p class="bvn-msg">
                        <b>NOTE:</b> We do not store your BVN on our servers. We
                        only use it for verification purposes vis secure
                        channels.
                      </p>
                    </div>

                    <div class="col-auto">
                      <button
                        class="btn btn-brand"
                        type="button"
                        @click="updateUserProfile"
                        :disabled="!details.bvn"
                      >
                        Verify
                      </button>
                    </div>
                  </div>
                  <div class="bvn-verified" v-else>
                    <img
                      src="/img/bvn-verified.png"
                      alt="user's bvn verified"
                      class="img-responsive"
                    />
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { errorHandlers, mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "UserProfile",
    mixins: [mixins, errorHandlers],
    props: {
      banks: Array,
      account_name: String,
    },
    components: {
      Layout,
    },
    data() {
      return {
        details: {
          ..._.omit(this.$page.props.auth.user, ["id_card"]),
          acc_type: "savings",
        },
        formSubmitted: false,
        fileUploadName: null,
        datePick: {
          onSelect: function (dateText, inst) {
            alert(dateText);
          },
        },
      };
    },
    methods: {
      attachFile() {
        this.fileUploadName = this.$refs.id_card.files[0].name;

        this.details.id_card = this.$refs.id_card.files[0];
      },
      resetUserDetails() {
        this.$inertia.reload({
          method: "get",
          data: {},
          preserveState: false,
          preserveScroll: true,
          only: [],
        });
      },
      validateBankName() {
        this.formSubmitted = false;
        BlockToast.fire({
          text: "Validating bank account ...",
        });

        this.$inertia
          .post(
            this.$route("appuser.account.verify"),
            {
              acc_num: this.details.acc_num,
              acc_bank: this.details.acc_bank,
            },
            {
              replace: false,
              preserveState: true,
              preserveScroll: true,
              only: ["account_name", "flash", "errors"],
            }
          )
          .then((rsp) => {
            this.formSubmitted = true;
            this.details.acc_name = this.account_name;
            swal.close();
          });
      },
      updateUserProfile() {
        BlockToast.fire({
          text: "Updating profile ...",
        });
        this.formSubmitted = false;

        let formData = new FormData();

        this.details._method = "PUT";

        _.forEach(this.details, (val, key) => {
          formData.append(key, val);
        });

        this.$inertia
          .post(this.$route("appuser.profile.edit"), formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },

            replace: false,
            preserveState: true,
            preserveScroll: true,
          })
          .then((rsp) => {
            if (_.size(this.$page.props.errors) > 0) {
              this.formSubmitted = true;
            }
            else if (this.$page.props.flash.success) {
              this.formSubmitted = false;
            }

            this.displayResponse()
            this.displayErrors()
          });
      },
    },
  };
</script>

<style lang="scss" scoped>
  .card {
    &.rounded {
      border-radius: 5px;
    }
  }

  textarea.form-control {
    height: auto;
  }

  .invalid-feedback {
    display: block;
  }

  .rui-profile .rui-profile-img img {
    object-fit: cover;
    display: block;
    height: 100px;
    width: 100px;
  }

  .paystack-logo {
    width: 35%;
    margin: 15px auto 0;
    display: block;

    @media (max-width: 575px) {
      width: 70%;
    }
  }

  .bvn-verified {
    width: 100% !important;
    max-width: 250px;
    margin: 0 auto;
  }
</style>
