<template>
  <layout title="Manage Users">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12 col-lg-8 offset-lg-2">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable" data-order="[]">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">List of Users</th>
                </tr>
              </thead>
              <tbody class="list-group list-group-flush rui-project-releases-list m-0">
                <tr class="list-group-item p-0" v-for="(user, idx) in users" :key="idx">
                  <td class="rui-changelog d-block">
                    <div class="row vertical-gap">
                      <div class="col-auto">
                        <div class="rui-profile-img">
                          <img :src=" user.id_card_thumb_url || '/img/avatar.png'" alt />
                        </div>
                      </div>
                      <div class="col">
                        <div class="rui-profile-info">
                          <h3 class="rui-profile-info-title h4">{{user.full_name}}</h3>
                          <small
                            class="text-grey-6 mt-2 mb-15"
                          >Verified On: {{ new Date(user.verified_at).toDateString() }}</small>
                          <br />
                          <small
                            class="text-grey-6 mt-2 mb-15"
                          >Registered On{{ new Date(user.created_at).toDateString() }} {{ new Date(user.created_at).toLocaleTimeString() }}</small>
                          <a class="rui-profile-info-mail" href="#">
                            <span>{{ user.email }}</span>
                          </a>
                          <a class="rui-profile-info-phone" href="#">{{ user.phone }}</a>
                        </div>
                      </div>
                    </div>
                    <h3 class="rui-changelog-title">Account Number: {{ user.acc_num }}</h3>
                    <div class="rui-changelog-subtitle">
                      <a href="#">Bank Verified:</a>
                      {{ user.is_bank_verified ? 'Yes' : 'No' }}
                      <br />
                      <a href="#">BVN Verified:</a>
                      {{ user.is_bvn_verified? 'Yes' : 'No' }}
                    </div>
                    <ul class="list-unstyled">
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[user.is_email_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">
                            <b>Bank:</b>
                            {{ user.acc_bank }}
                          </span>
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[user.is_email_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">
                            <b>Address:</b>
                            {{ user.address }}
                          </span>
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[user.is_email_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">
                            <b>Date of Birth:</b>
                            {{ user.date_of_birth }}
                          </span>
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[user.is_email_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">
                            <b>City:</b>
                            {{ user.city }}
                          </span>
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[user.is_email_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">
                            <b>Country:</b>
                            {{ user.country }}
                          </span>
                        </div>
                      </li>
                    </ul>
                    <div class="col-12 text-right">
                      <button
                        class="btn btn-sm btn-warning"
                        @click="veryfyUser(user.id)"
                        v-if="!user.verified_at"
                      >Verify</button>
                      <button
                        class="btn btn-sm btn-warning"
                        @click="toggleActiveState(user.id)"
                        v-if="user.verified_at && user.is_active"
                      >Suspend</button>
                      <button
                        class="btn btn-sm btn-warning"
                        @click="toggleActiveState(user.id)"
                        v-if="!user.is_active"
                      >Unsuspend</button>
                      <inertia-link
                        v-if="user.verified_at"
                        :href="$route('superadmin.user.profile', user.phone)"
                        class="btn btn-primary btn-sm"
                      >Profile</inertia-link>
                      <inertia-link
                        v-if="user.verified_at"
                        :href="$route('superadmin.user_savings', user.id)"
                        class="btn btn-success btn-sm"
                      >Savings</inertia-link>
                      <inertia-link
                        v-if="user.verified_at"
                        :href="$route('superadmin.user.interest', user.id)"
                        class="btn btn-brand btn-sm"
                      >Interests</inertia-link>
                      <inertia-link
                        v-if="user.verified_at"
                        :href="$route('superadmin.user.statement', user.id)"
                        class="btn btn-dark btn-sm text-nowrap"
                      >Transaction History</inertia-link>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <template v-slot:modals>
      <modal modalId="savingsPlans" :modalTitle="`I can't remember what I wanted to do here`"></modal>
    </template>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  export default {
    name: "ManageUsers",
    props: {
      users: Array
    },
    components: { Layout },
    mixins: [mixins],
    data: () => ({
      userDetails: {},
      details: {}
    }),
    methods: {
      veryfyUser(id) {
        BlockToast.fire({
          text: "Manually verifying user ..."
        });

        this.$inertia
          .put(this.$route("superadmin.user.verify", id), null, {
            preserveState: false,
            preserveScroll: true,
            only: ["errors", "flash", "users"]
          })
      },
      toggleActiveState(id) {
        BlockToast.fire({
          text: "Reversing user account status ..."
        });

        this.$inertia
          .put(this.$route("superadmin.user.toggle_active_status", id), null, {
            preserveState: false,
            preserveScroll: true,
            only: ["errors", "flash", "users"]
          })
      }
    }
  };
</script>

<style lang="scss" scoped>
  .invalid-feedback {
    display: block;
  }

  .rui-profile-info-mail,
  .rui-profile-info-phone {
    display: block;
    color: #4b515b;
  }

  .rui-profile-info-phone {
    margin-top: 3px;
  }

  .rui-profile-img {
    max-width: 100px;
    overflow: hidden;
    border-radius: 100%;

    img {
      object-fit: cover;
      display: block;
      height: 100px;
      width: 100px;
    }
  }
</style>
