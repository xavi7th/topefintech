<template>
  <layout :title="`${appUser.full_name}'s Account Statement`">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12 col-lg-8 offset-lg-2">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable" data-order="[]">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Statement</th>
                </tr>
              </thead>
              <tbody class="list-group list-group-flush rui-project-releases-list m-0">
                <tr
                  class="list-group-item p-0"
                  v-for="(record, idx) in account_statement"
                  :key="idx"
                >
                  <td class="rui-changelog d-block">
                    <h3 class="rui-changelog-title">Amount: {{ record.amount | Naira}}</h3>
                    <div class="rui-changelog-subtitle">
                      <a href="#">Transaction Date:</a>
                      {{ new Date(record.created_at).toDateString() }} {{ new Date(record.created_at).toLocaleTimeString() }}
                    </div>
                    <ul class="list-unstyled">
                      <li>
                        <div class="rui-changelog-item rui-changelog-success">
                          <span class="rui-changelog-item-type">{{ record.description }}</span>
                        </div>
                      </li>
                    </ul>
                    <ul class="list-unstyled">
                      <li>
                        <a class="rui-changelog-file text-capitalize" href="#">
                          <span class="fa fa-history"></span>
                          <strong class="mx-5">Transaction Type:</strong>
                          {{record.trans_type}}
                        </a>
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
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@admin-assets/js/AdminAppComponent";
  export default {
    name: "UserAccountStatement",
    mixins: [mixins],
    props: {
      account_statement: Array,
      appUser: Object
    },
    components: {
      Layout
    }
  };
</script>
