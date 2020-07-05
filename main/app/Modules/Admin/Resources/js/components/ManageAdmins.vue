<template>
  <layout title="Manage Admins">
    <main v-if="false">
      <div class="content">
        <!-- table basic -->
        <div class="card">
          <div class="card-title">
            <button
              type="button"
              class="btn btn-bold btn-pure btn-twitter btn-shadow"
              data-toggle="modal"
              data-target="#modal-admin"
            >Create Admin</button>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.full_name }}</td>
                  <td>{{ user.phone }}</td>
                  <td>{{ user.is_verified ? 'Account Verified' : 'Unverified Account' }}</td>
                  <td>
                    <div
                      class="badge badge-success badge-shadow pointer"
                      data-toggle="modal"
                      data-target="#modal-right"
                      @click="showModal(user)"
                    >View Full Details</div>
                    <div
                      class="badge badge-purple pointer"
                      data-toggle="modal"
                      data-target="#modal-perm"
                      @click="showPermModal(user)"
                    >Permissions</div>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="modal modal-left fade" id="modal-right" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">{{ userDetails.full_name }}' details</h4>
                    <button type="button" class="close" data-dismiss="modal">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="col-md-12">
                      <div class="card overflow-hidden">
                        <div class="card-body py-0">
                          <div class="card-row">
                            <div class="table-responsive">
                              <!-- <div class="flex j-c-between bd bg-light py-30 px-30">
                                <div class="flex-sh-0 ln-18">
                                  <div class="fs-16 fw-500 text-success">122 Sales</div>
                                  <span class="fs-12 text-light">
                                    <i class="far fa-clock"></i> 24 hours
                                  </span>
                                </div>
                                <div class="flex-sh-0 ln-18">
                                  <div class="fs-16 fw-500 text-danger">3 Problem</div>
                                  <span class="fs-12 text-light">
                                    <i class="far fa-clock"></i> 24 hours
                                  </span>
                                </div>
                                <div class="flex-sh-0 ln-18">
                                  <div class="fs-16 fw-500 text-warning">14 Waiting</div>
                                  <span class="fs-12 text-light">
                                    <i class="far fa-clock"></i> 24 hours
                                  </span>
                                </div>
                              </div>-->
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(value, property, idx) in userDetails" :key="idx">
                                    <td>{{ slugToString(property) }}</td>
                                    <td>
                                      <span v-if="property != 'user_passport'">{{ value }}</span>
                                      <a :href="value" v-else target="_blank">
                                        <img :src="value" alt class="img-fluid" />
                                      </a>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-bold btn-pure btn-secondary"
                      data-dismiss="modal"
                    >Close</button>
                    <!-- <button type="button" class="btn btn-bold btn-pure btn-primary">Save changes</button> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <div class="container-fluid" v-else>
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
                    </div> -->
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <template v-slot:modals>
      <modal modalId="createAdminModal" :modalTitle="`Add distributed funds to your savings`">
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
      admins: Array
    },
    components: { Layout },
    mixins: [mixins],
    data: () => ({
      users: [],
      userDetails: {},
      details: {}
    }),
    mounted() {
      // this.$nextTick(() => {
      //   $(function() {
      //     $("#datatable1").DataTable({
      //       responsive: true,
      //       order: [[0, "desc"]],
      //       language: {
      //         searchPlaceholder: "Search...",
      //         sSearch: ""
      //       }
      //     });
      //   });
      // });
    },
    methods: {
      createAdmin() {
        BlockToast.fire({
          text: "Creating admin..."
        });

        this.$inertia
          .post(this.$route("admin.create"), { ...this.details })
          .then(() => {
            if (this.flash.success) {
              ToastLarge.fire({
                title: "Success",
                html: `They will be required to set a password om their first login`,
                type: "success"
              });
            } else {
              swal.close();
            }
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
  .invalid-feedback {
    display: block;
  }
</style>
