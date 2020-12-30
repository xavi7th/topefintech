<template>
  <layout title="Managed Users">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12 col-lg-10 offset-lg-1">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable" data-order="[]">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">List of Users I Manage</th>
                </tr>
              </thead>
              <tbody class="list-group list-group-flush rui-project-releases-list m-0">
                <tr class="list-group-item p-0" v-for="(user, idx) in managedUsers" :key="idx">
                  <td class="rui-changelog d-block">
                    <div class="row vertical-gap">
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

                    <ul class="list-unstyled">
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[user.is_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
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
                          :class="[user.is_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">
                            <b>Address:</b>
                            {{ user.address }}
                          </span>
                        </div>
                      </li>
                    </ul>
                    <div class="col-12 text-right">
                      <inertia-link
                        v-if="user.is_verified"
                        :href="$route('agent.user_savings', user.phone)"
                        class="btn btn-success btn-sm"
                      >Savings Details</inertia-link>
                      <inertia-link
                        v-if="user.is_verified"
                        :href="$route('agent.user.interest', user.phone)"
                        class="btn btn-brand btn-sm"
                      >Interest Logs</inertia-link>
                      <inertia-link
                        v-if="user.is_verified"
                        :href="$route('agent.user.statement', user.phone)"
                        class="btn btn-dark btn-sm"
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
  import Layout from "@admin-assets/js/AdminAppComponent";
  export default {
    name: "ManageUsers",
    props: {
      managedUsers: Array,
    },
    components: { Layout },
    mixins: [mixins],
    data: () => ({
      userDetails: {},
      details: {},
    }),
    methods: {
      veryfyUser(id) {
        BlockToast.fire({
          text: "Manually verifying user ...",
        });

        this.$inertia
          .put(this.$route("admin.user.verify", id), null, {
            preserveState: false,
            preserveScroll: true,
            only: ["errors", "flash", "users"],
          })
      },
    },
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
