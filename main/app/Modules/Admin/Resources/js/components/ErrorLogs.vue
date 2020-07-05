<template>
  <layout title="Error Logs">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable" data-order="[]">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Errors</th>
                </tr>
              </thead>
              <tbody class="list-group list-group-flush m-0 rui-project-task-list">
                <tr class="list-group-item p-0" v-for="err in errors" :key="err.id">
                  <td class="rui-task rui-task-danger">
                    <div class="rui-task-icon">
                      <span class="fa fa-history mr-10"></span>
                      {{err.time}}
                    </div>
                    <div class="rui-task-content">
                      <b class="rui-task-title">{{ err.message }}</b>
                      <small class="rui-task-subtitle">
                        <strong>Error Type:</strong>
                        {{ err.type }}
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
  import Layout from "@admin-assets/js/AdminAppComponent";
  export default {
    name: "AdminNotifications",
    mixins: [mixins],
    props: {
      errors: Array
    },
    components: {
      Layout
    }
  };
</script>
