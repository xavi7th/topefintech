<template>
  <layout title="My Withdrawal Requests" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable">
              <thead class="thead-dark">
                <tr>
                  <th scope="col" class="p-0">
                    <div class="rui-project-task-info m-0 text-center justify-content-between">
                      <a class="rui-project-task-info-link" href="#">
                        <span class="rui-project-task-info-icon">
                          <span data-feather="check-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                          <span class="rui-project-task-info-title">
                            <span>{{statistics.total_processed}}</span> Processed
                          </span>
                        </span>
                      </a>
                      <a class="rui-project-task-info-link" href="#">
                        <span class="rui-project-task-info-icon">
                          <span data-feather="alert-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                          <span class="rui-project-task-info-title">
                            <span>{{statistics.total_pending}}</span> Pending
                          </span>
                        </span>
                      </a>
                      <a class="rui-project-task-info-link" href="#">
                        <span class="rui-project-task-info-icon">
                          <span data-feather="thumbs-down" class="rui-icon rui-icon-stroke-1_5"></span>
                          <span class="rui-project-task-info-title">
                            <span>{{statistics.total_declined}}</span> Declined
                          </span>
                        </span>
                      </a>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody class="list-group list-group-flush m-0 rui-project-task-list">
                <tr
                  class="list-group-item p-0"
                  v-for="request in withdrawal_requests"
                  :key="request.id"
                >
                  <td
                    class="rui-task"
                    :class="[request.deleted_at !== null ? 'rui-task-danger' :request.is_processed ? 'rui-task-success' : 'rui-task-warning']"
                  >
                    <div class="rui-task-icon">
                      <span
                        data-feather="thumbs-down"
                        class="rui-icon rui-icon-stroke-1_5 fs-15"
                        v-if="request.deleted_at  !== null"
                      ></span>
                      <span
                        data-feather="check-circle"
                        class="rui-icon rui-icon-stroke-1_5 fs-15"
                        v-else-if="request.is_processed"
                      ></span>
                      <span
                        data-feather="alert-circle"
                        class="rui-icon rui-icon-stroke-1_5 fs-15"
                        v-else
                      ></span>
                    </div>
                    <div class="rui-task-content">
                      <a class="rui-task-title" href="#home">Amount: {{ request.amount | Naira }}</a>
                      <small
                        class="rui-task-subtitle"
                      >Requested {{ new Date(request.created_at).toDateString() }} {{ new Date(request.created_at).toLocaleTimeString() }}</small>
                      <small class="rui-task-subtitle">
                        <a href="#">CHARGE FREE:</a>
                        <span v-if="request.is_charge_free">Yes</span>
                        <span v-else>No</span>
                      </small>
                    </div>
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
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "ViewWithdrawalRequests",
    mixins: [mixins],
    props: {
      withdrawal_requests: Array,
      statistics: Object
    },
    components: {
      Layout
    },
    data: () => {
      return {};
    },
    created() {
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
    }
  };
</script>
