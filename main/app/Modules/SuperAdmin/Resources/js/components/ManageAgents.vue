<template>
  <layout title="Manage Agents">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12 col-lg-8 offset-lg-2">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable" data-order="[]">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">List of Agents</th>
                </tr>
              </thead>
              <tbody class="list-group list-group-flush rui-project-releases-list m-0">
                <tr class="list-group-item p-0" v-for="(agent, idx) in agents" :key="idx">
                  <td class="rui-changelog d-block">
                    <h3 class="rui-changelog-title">{{ agent.full_name }}</h3>
                    <!-- <h4
                      class="rui-changelog-title"
                    >Wallet Balance: {{ agent.wallet_balance | Naira }}</h4> -->
                    <div class="rui-changelog-subtitle">
                      <a href="#">Created On:</a>
                      {{ new Date(agent.created_at).toDateString() }} {{ new Date(agent.created_at).toLocaleTimeString() }}
                    </div>
                    <ul class="list-unstyled">
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[agent.is_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">EMAIL: {{ agent.email }}</span>
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[agent.is_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span class="rui-changelog-item-type">PHONE NUMBER:{{ agent.phone }}</span>
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[agent.is_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span
                            class="rui-changelog-item-type"
                          >AGENT REFERRAL CODE: {{ agent.ref_code }}</span>
                        </div>
                      </li>
                      <li>
                        <div
                          class="rui-changelog-item"
                          :class="[agent.is_verified ? 'rui-changelog-success': 'rui-changelog-danger']"
                        >
                          <span
                            class="rui-changelog-item-type"
                          >BASE OF OPERATIONS: {{ agent.city_of_operation }}</span>
                        </div>
                      </li>
                      <li>
                          <button
                          class="btn btn-danger btn-xs"
                          v-if="agent.is_active"
                          @click="toggleAgentAccountStatus(agent)"
                        >Suspend Agent</button>

                          <button
                          class="btn btn-warning btn-xs"
                          v-else
                          @click="toggleAgentAccountStatus(agent)"
                        >Unlock Account</button>
                      </li>
                    </ul>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { errorHandlers, mixins } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  export default {
    name: "ManageAgents",
    props: {
      agents: Array,
    },
    components: { Layout },
    mixins: [mixins, errorHandlers],
    methods:{
       toggleAgentAccountStatus(agent) {
        BlockToast.fire({
          text: "Suspending Agent Account ...",
        });
        this.$inertia
          .put(this.$route("superadmin.agents.toggle_active_status", agent.id))
      },
    }
  };
</script>

<style lang="scss" scoped>
  .invalid-feedback {
    display: block;
  }
</style>
