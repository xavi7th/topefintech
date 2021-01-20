<template>
  <layout title="Manage Admins">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12">
          <button
            class="btn btn-success btn-lg"
            data-toggle="modal"
            data-target="#createAdminModal"
          >Create Admin</button>
        </div>
        <div class="col-12 col-lg-8 offset-lg-2">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable" data-order="[]">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">List of Admins</th>
                </tr>
              </thead>
              <tbody class="list-group list-group-flush rui-project-releases-list m-0">
                <tr class="list-group-item p-0" v-for="(admin, idx) in admins" :key="idx">
                  <td class="rui-changelog d-block">
                    <h3 class="rui-changelog-title">{{ admin.full_name }}</h3>
                     <h4
                      class="rui-changelog-title"
                    >Wallet Balance: {{ admin.wallet_balance | Naira }}</h4>
                    <div class="rui-changelog-subtitle">
                      <a href="#">Created On:</a>
                      {{ new Date(admin.created_at).toDateString() }} {{ new Date(admin.created_at).toLocaleTimeString() }}
                    </div>
                    <ul class="list-unstyled">
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[admin.is_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">{{ admin.email }}</span>
                        </div>
                      </li>
                    </ul>
                    <div class="col-12 text-right">
                      <!-- <button class="btn btn-sm btn-danger">Delete</button> -->
                      <button
                        class="btn btn-danger btn-xs"
                        v-if="admin.is_active"
                        @click="toggleAdminAccountStatus(admin)"
                      >Suspend Admin</button>

                        <button
                        class="btn btn-warning btn-xs"
                        v-else
                        @click="toggleAdminAccountStatus(admin)"
                      >Unlock Account</button>

                      <button
                        class="btn btn-xs btn-brand"
                        data-toggle="modal"
                        data-target="#fundAdminModal"
                        @click="adminToFund = admin"
                      >Fund Admin</button>

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
     <modal modalId="fundAdminModal" :modalTitle="`Fund Admin's wallet`">
        <form class="m-25">
          <FlashMessage />

          <div class="form-group mb-5" :class="{'has-error': errors.amount}">
            <label for="form-amount">
              <strong>Amount</strong>
            </label>
            <input
              type="text"
              class="form-control form-control-pill"
              id="form-amount"
              v-model="details.amount"
              name="amount"
            />
            <FlashMessage v-if="errors.amount" :msg="errors.amount[0]" />
          </div>

          <div class="form-group mt-20 text-center">
            <button type="button" class="btn btn-brand" @click="fundAdmin">Fund Admin's Account</button>
          </div>
        </form>
      </modal>
      <modal modalId="createAdminModal" :modalTitle="`Create a new admin account`">
        <form class="m-25">
          <FlashMessage />
          <div class="form-group mb-5" :class="{'has-error': errors.full_name}">
            <label for="form-full-name">
              <strong>Full Name</strong>
            </label>
            <input
              type="text"
              class="form-control form-control-pill"
              id="form-full-name"
              v-model="details.full_name"
              name="full_name"
            />
            <FlashMessage v-if="errors.full_name" :msg="errors.full_name[0]" />
          </div>
          <div class="form-group mb-5" :class="{'has-error': errors.email}">
            <label for="form-mail">
              <strong>E-Mail</strong>
            </label>
            <input
              type="text"
              class="form-control form-control-pill"
              id="form-mail"
              v-model="details.email"
              name="email"
            />
            <FlashMessage v-if="errors.email" :msg="errors.email[0]" />
          </div>
          <div class="form-group mb-5" :class="{'has-error': errors.phone}">
            <label for="form-phone">
              <strong>Phone</strong>
            </label>
            <input
              type="text"
              class="form-control form-control-pill"
              id="form-phone"
              v-model="details.phone"
              name="phone"
            />
            <FlashMessage v-if="errors.phone" :msg="errors.phone[0]" />
          </div>

          <div class="form-group mt-20 text-center">
            <button type="button" class="btn btn-brand" @click="createAdmin">Create Admin Account</button>
          </div>
        </form>
      </modal>
    </template>
  </layout>
</template>

<script>
  import { mixins, errorHandlers } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  export default {
    name: "ManageAdmins",
    props: {
      admins: Array,
    },
    components: { Layout },
    mixins: [mixins, errorHandlers],
    data: () => ({
      users: [],
      details: {},
      adminToFund: null,
    }),

    methods: {
      createAdmin() {
        BlockToast.fire({
          text: "Creating admin...",
        });

        this.$inertia
          .post(this.$route("superadmin.admins.create"), { ...this.details },{
            onFinish:() => this.details={}
          })

      },
      toggleAdminAccountStatus(admin) {
        BlockToast.fire({
          text: "Suspending Admin Account ...",
        });
        this.$inertia
          .put(this.$route("superadmin.admins.toggle_active_status", admin.id))
      },

       fundAdmin() {
        BlockToast.fire({
          text: "Funding admin...",
        });

        this.$inertia
          .post(this.$route("superadmin.admins.fund", this.adminToFund.id), {
            amount: this.details.amount,
          },{
            onSuccess:() => this.details.amount = null
          })
      },
    },
  };
</script>

<style lang="scss" scoped>
  .invalid-feedback {
    display: block;
  }
</style>
