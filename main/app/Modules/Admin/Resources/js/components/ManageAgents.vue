<template>
  <layout title="Manage Agents">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12">
          <button
            class="btn btn-success btn-lg"
            data-toggle="modal"
            data-target="#createAgentModal"
          >Create Agent</button>
        </div>
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
                    </ul>

                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <template v-slot:modals>

      <modal modalId="createAgentModal" :modalTitle="`Create a new agent account`">
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
          <div class="form-group mb-5" :class="{'has-error': errors.city_of_operation}">
            <label for="form-city-of-operation">
              <strong>City of Operation</strong>
            </label>
            <input
              type="text"
              class="form-control form-control-pill"
              id="form-city-of-operation"
              v-model="details.city_of_operation"
              name="city-of-operation"
            />
            <FlashMessage v-if="errors.city_of_operation" :msg="errors.city_of_operation[0]" />
          </div>

          <div class="form-group mt-20 text-center">
            <button type="button" class="btn btn-brand" @click="createAgent">Create Agent Account</button>
          </div>
        </form>
      </modal>
    </template>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@agent-assets/js/AgentAppComponent";
  export default {
    name: "ManageAgents",
    props: {
      agents: Array,
    },
    components: { Layout },
    mixins: [mixins],
    data: () => ({
      details: {},

    }),

    methods: {
      createAgent() {
        BlockToast.fire({
          text: "Creating agent...",
        });

        this.$inertia
          .post(this.$route("admin.create_agent"), { ...this.details })
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
