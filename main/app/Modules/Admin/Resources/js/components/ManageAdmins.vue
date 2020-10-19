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
                    <!-- <div class="col-12 text-right">
                      <button class="btn btn-sm btn-danger">Delete</button>
                    </div>-->
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <template v-slot:modals>
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
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@admin-assets/js/AdminAppComponent";
  export default {
    name: "ManageAdmins",
    props: {
      admins: Array,
    },
    components: { Layout },
    mixins: [mixins],
    data: () => ({
      users: [],
      details: {},
    }),

    methods: {
      createAdmin() {
        BlockToast.fire({
          text: "Creating admin...",
        });

        this.$inertia
          .post(this.$route("admin.create"), { ...this.details })
          .then(() => {
            if (this.flash.success) {
              ToastLarge.fire({
                title: "Success",
                html: `They will be required to set a password on their first login`,
                type: "success",
              });
            } else {
              swal.close();
            }
          });
      },
    },
  };
</script>

<style lang="scss" scoped>
  .invalid-feedback {
    display: block;
  }
</style>
