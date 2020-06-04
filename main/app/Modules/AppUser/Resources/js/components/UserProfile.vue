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
                    <img :src="auth.user.id_card" alt="user id card" />
                  </div>
                </div>
                <div class="col">
                  <div class="rui-profile-info">
                    <h3 class="rui-profile-info-title h4">{{auth.user.full_name}}</h3>
                    <small
                      class="text-grey-6 mt-2 mb-15"
                    >Registered: {{auth.user.num_of_days_active}} days ago</small>
                    <a class="rui-profile-info-mail" href="#">{{auth.user.email}}</a>
                    <a class="rui-profile-info-phone" href="#">{{auth.user.phone}}</a>
                  </div>
                </div>
              </div>
              <div class="rui-profile-numbers">
                <div class="row justify-content-center">
                  <div class="col"></div>
                  <div class="col-auto">
                    <div class="rui-profile-number text-center">
                      <h4 class="rui-profile-number-title h2">Male</h4>
                      <small class="text-grey-6">Gender</small>
                    </div>
                  </div>
                  <div class="col p-0"></div>
                  <div class="col-auto">
                    <div class="rui-profile-number text-center">
                      <h4 class="rui-profile-number-title h2">{{auth.user.date_of_birth}}</h4>
                      <small class="text-grey-6">Date of Birth</small>
                    </div>
                  </div>
                  <div class="col"></div>
                </div>
              </div>
            </div>
          </div>

          <hr />

          <div class="card">
            <div class="card-body pt-20 pr-10 pb-20 pl-10">
              <ul class="nav flex-column mnt-3">
                <li>
                  <a class="nav-link active" href="#">
                    <span data-feather="user" class="rui-icon rui-icon-stroke-1_5"></span>
                    <span>Personal information</span>
                  </a>
                </li>
                <li>
                  <a class="nav-link" href="#">
                    <span data-feather="key" class="rui-icon rui-icon-stroke-1_5"></span>
                    <span>Change Password</span>
                  </a>
                </li>
                <li>
                  <a class="nav-link" href="#">
                    <span data-feather="credit-card" class="rui-icon rui-icon-stroke-1_5"></span>
                    <span>Account information</span>
                  </a>
                </li>
                <!-- <li>
                  <a class="nav-link" href="#">
                    <span data-feather="shopping-cart" class="rui-icon rui-icon-stroke-1_5"></span>
                    <span>Purchases</span>
                  </a>
                </li>-->
              </ul>
            </div>
          </div>
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
                <span data-feather="user" class="rui-icon rui-icon-stroke-1_5"></span>
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
                <span data-feather="credit-card" class="rui-icon rui-icon-stroke-1_5"></span>
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
                <span data-feather="key" class="rui-icon rui-icon-stroke-1_5"></span>
                <span>Change Password</span>
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
                    :class="{'was-validated': formSubmitted}"
                  >
                    <div class="col-12">
                      <label for="full_name">Full Name</label>
                      <input
                        class="form-control"
                        :class="{'is-invalid': errors.full_name, 'is-valid': !errors.full_name}"
                        v-model="details.full_name"
                        id="full_name"
                        placeholder="Your Full Name"
                      />
                      <FlashMessage v-if="errors.full_name" :msg="errors.full_name[0]" />
                    </div>

                    <div class="col-6">
                      <label for="email">Email</label>
                      <input
                        type="email"
                        class="form-control"
                        :class="{'is-invalid': errors.email, 'is-valid': !errors.email}"
                        v-model="details.email"
                        id="email"
                        placeholder="Your Email"
                      />
                      <FlashMessage v-if="errors.email" :msg="errors.email[0]" />
                    </div>

                    <div class="col-6">
                      <label for="phone">Phone Number</label>
                      <input
                        class="form-control"
                        v-model="details.phone"
                        id="phone"
                        placeholder="Your Phone"
                        :class="{'is-invalid': errors.phone, 'is-valid': !errors.phone}"
                      />
                      <FlashMessage v-if="errors.phone" :msg="errors.phone[0]" />
                    </div>

                    <div class="col-12">
                      <label for="address">Address</label>
                      <textarea
                        name="address"
                        id="address"
                        rows="1"
                        class="form-control"
                        :class="{'is-invalid': errors.address, 'is-valid': !errors.address}"
                        v-model="details.address"
                      ></textarea>
                      <FlashMessage v-if="errors.address" :msg="errors.address[0]" />
                    </div>

                    <div class="col-6">
                      <label for="city">City</label>
                      <input
                        class="form-control"
                        v-model="details.city"
                        id="city"
                        placeholder="Your city"
                        :class="{'is-invalid': errors.city, 'is-valid': !errors.city}"
                      />
                      <FlashMessage v-if="errors.city" :msg="errors.city[0]" />
                    </div>

                    <div class="col-6">
                      <label for="country">Country</label>
                      <input
                        class="form-control"
                        v-model="details.country"
                        id="country"
                        placeholder="Your country"
                        :class="{'is-invalid': errors.country, 'is-valid': !errors.country}"
                      />
                      <FlashMessage v-if="errors.country" :msg="errors.country[0]" />
                    </div>

                    <div class="col-6">
                      <label for="date_of_birth">Date of Birth</label>
                      <input
                        class="form-control"
                        type="date"
                        v-model="details.date_of_birth"
                        id="date_of_birth"
                        placeholder="Your date_of_birth"
                        :class="{'is-invalid': errors.date_of_birth, 'is-valid': !errors.date_of_birth}"
                      />

                      <FlashMessage v-if="errors.date_of_birth" :msg="errors.date_of_birth[0]" />
                    </div>

                    <div class="col-6">
                      <label for="id_card">{{fileUploadName || 'ID Card'}}</label>
                      <input
                        type="file"
                        class="form-control"
                        @change="attachFile"
                        ref="id_card"
                        id="id_card"
                        placeholder="Your id_card"
                        :class="{'is-invalid': errors.id_card, 'is-valid': !errors.id_card}"
                      />
                      <FlashMessage v-if="errors.id_card" :msg="errors.id_card[0]" />
                    </div>

                    <div class="col-12">
                      <FlashMessage />
                    </div>

                    <div class="col-auto">
                      <button class="btn btn-grey-2" type="button" @click="resetUserDetails">Reset</button>
                    </div>
                    <div class="col-auto">
                      <button class="btn btn-brand" type="button" @click="updateUserProfile">Update</button>
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
              <p
                class="mnb-4"
              >Kind third day saw set itself fowl after whales upon can't sixth of days let fill Replenish waters make. Dry gathering winged land they're you'll above green was she'd moving.</p>
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
                    :class="{'was-validated': formSubmitted}"
                  >
                    <div class="col-12">
                      <FlashMessage />
                    </div>

                    <div class="col-12">
                      <label for="current_password">Current Password</label>
                      <input
                        type="password"
                        class="form-control"
                        :class="{'is-invalid': errors.current_password, 'is-valid': !errors.current_password}"
                        v-model="details.current_password"
                        id="current_password"
                        placeholder="Current Password"
                      />
                      <FlashMessage
                        v-if="errors.current_password"
                        :msg="errors.current_password[0]"
                      />
                    </div>

                    <div class="col-6">
                      <label for="password">New Password</label>
                      <input
                        type="password"
                        class="form-control"
                        :class="{'is-invalid': errors.password, 'is-valid': !errors.password}"
                        v-model="details.password"
                        id="password"
                        placeholder="Your password"
                      />
                      <FlashMessage v-if="errors.password" :msg="errors.password[0]" />
                    </div>

                    <div class="col-6">
                      <label for="password_confirmation">Confirm Password</label>
                      <input
                        type="password"
                        class="form-control"
                        v-model="details.password_confirmation"
                        id="password_confirmation"
                        placeholder="Confirm Password"
                        :class="{'is-invalid': errors.password_confirmation, 'is-valid': !errors.password_confirmation}"
                      />
                      <FlashMessage
                        v-if="errors.password_confirmation"
                        :msg="errors.password_confirmation[0]"
                      />
                    </div>

                    <div class="col-auto">
                      <button
                        class="btn btn-brand"
                        type="button"
                        @click="updateUserProfile"
                        :disabled="!details.password"
                      >Update</button>
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
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "UserProfile",
    mixins: [mixins],
    components: {
      Layout
    },
    data() {
      return {
        details: _.omit(this.auth.user, ["id_card"]),
        formSubmitted: false,
        fileUploadName: null,
        datePick: {
          onSelect: function(dateText, inst) {
            alert(dateText);
          }
        }
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
          only: []
        });
      },
      updateUserProfile() {
        BlockToast.fire({
          text: "Updating profile ..."
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
              "Content-Type": "multipart/form-data"
            },

            replace: false,
            preserveState: true,
            preserveScroll: true
          })
          .then(rsp => {
            if (_.size(this.errors)) {
              this.formSubmitted = true;
            }
            swal.close();
          });
      }
    }
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

  .rui-profile .rui-profile-img img {
    object-fit: cover;
    display: block;
    height: 100px;
    width: 100px;
  }
</style>
