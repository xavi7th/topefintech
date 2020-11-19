<template>
  <layout title="User's Profile">
    <div class="container-fluid">
      <div class="rui-profile row vertical-gap">
        <div class="col-lg-5 col-xl-4 col-12">
          <div class="card">
            <div class="card-body">
              <div class="row vertical-gap">
                <div class="col-auto">
                  <div class="rui-profile-img">
                    <img
                      :src="user_details.id_card_thumb_url || `/img/avatar.png`"
                      alt="user id card"
                    />
                  </div>
                </div>
                <div class="col">
                  <div class="rui-profile-info">
                    <h3 class="rui-profile-info-title h4">
                      {{ user_details.full_name }}
                    </h3>
                    <small class="text-grey-6 mt-2 mb-15"
                      >Registered: {{ user_details.num_of_days_active }} days
                      ago</small
                    >
                    <a class="rui-profile-info-mail" href="#">{{
                      user_details.email
                    }}</a>
                    <a class="rui-profile-info-phone" href="#">{{
                      user_details.phone
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
                        {{ user_details.gender }}
                      </h4>
                      <small class="text-grey-6">Gender</small>
                    </div>
                  </div>
                  <div class="col p-0"></div>
                  <div class="col-auto">
                    <div class="rui-profile-number text-center">
                      <h4 class="rui-profile-number-title h2">
                        {{ user_details.date_of_birth }}
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
                        :class="{
                          'is-invalid': $page.errors.full_name,
                          'is-valid': !$page.errors.full_name,
                        }"
                        v-model="details.full_name"
                        id="full_name"
                        placeholder="Your Full Name"
                      />
                      <FlashMessage
                        v-if="$page.errors.full_name"
                        :msg="$page.errors.full_name[0]"
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
                          'is-invalid': $page.errors.gender,
                          'is-valid': !$page.errors.gender,
                        }"
                      >
                        <option :value="null">Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>

                      <FlashMessage
                        v-if="$page.errors.gender"
                        :msg="$page.errors.gender[0]"
                      />
                    </div>

                    <div class="col-6">
                      <label for="email">Email</label>
                      <input
                        type="email"
                        class="form-control"
                        :class="{
                          'is-invalid': $page.errors.email,
                          'is-valid': !$page.errors.email,
                        }"
                        v-model="details.email"
                        id="email"
                        placeholder="Your Email"
                      />
                      <FlashMessage
                        v-if="$page.errors.email"
                        :msg="$page.errors.email[0]"
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
                          'is-invalid': $page.errors.phone,
                          'is-valid': !$page.errors.phone,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.errors.phone"
                        :msg="$page.errors.phone[0]"
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
                          'is-invalid': $page.errors.address,
                          'is-valid': !$page.errors.address,
                        }"
                        v-model="details.address"
                      ></textarea>
                      <FlashMessage
                        v-if="$page.errors.address"
                        :msg="$page.errors.address[0]"
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
                          'is-invalid': $page.errors.city,
                          'is-valid': !$page.errors.city,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.errors.city"
                        :msg="$page.errors.city[0]"
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
                          'is-invalid': $page.errors.country,
                          'is-valid': !$page.errors.country,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.errors.country"
                        :msg="$page.errors.country[0]"
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
                          'is-invalid': $page.errors.date_of_birth,
                          'is-valid': !$page.errors.date_of_birth,
                        }"
                      />

                      <FlashMessage
                        v-if="$page.errors.date_of_birth"
                        :msg="$page.errors.date_of_birth[0]"
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
                          'is-invalid': $page.errors.id_card,
                          'is-valid': !$page.errors.id_card,
                        }"
                      />
                      <FlashMessage
                        v-if="$page.errors.id_card"
                        :msg="$page.errors.id_card[0]"
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

          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins, errorHandlers } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  export default {
    name: "ManageUserProfile",
    mixins: [mixins, errorHandlers],
    props: {
      banks: Array,
      user_details:Object
    },
    components: {
      Layout,
    },
    data() {
      return {
        details: {
          ..._.omit(this.user_details, ["id_card"]),
          acc_type: "savings",
        },
        formSubmitted: false,
        fileUploadName: null,
      };
    },
    methods: {
      attachFile() {
        this.fileUploadName = this.$refs.id_card.files[0].name;

        this.details.id_card = this.$refs.id_card.files[0];
      },
      resetUserDetails() {
         this.details = {
          ..._.omit(this.user_details, ["id_card"]),
          acc_type: "savings",
        }
      },
      updateUserProfile() {
        BlockToast.fire({
          text: "Updating user's details ...",
        });
        this.formSubmitted = false;

        let formData = new FormData();

        this.details._method = "PUT";

        _.forEach(this.details, (val, key) => {
          formData.append(key, val);
        });

        this.$inertia
          .post(this.$route("superadmin.user.profile.edit", this.user_details.phone), formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
            replace: false,
            preserveState: true,
            preserveScroll: true,
            only:['errors', 'flash', 'user_details']
          })
          .then((rsp) => {

            if (_.size(this.$page.errors) > 0) {
              this.formSubmitted = true;
            }

            this.displayResponse();
            this.displayErrors();
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
