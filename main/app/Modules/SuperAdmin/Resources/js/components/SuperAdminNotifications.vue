<template>
  <layout title="My Notifications">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-bordered rui-datatable" data-order="[]">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Notifications</th>
                </tr>
              </thead>
              <tbody class="list-group list-group-flush m-0 rui-project-task-list">
                <tr class="list-group-item p-0" v-for="notif in notifications" :key="notif.id">
                  <td class="rui-task rui-task-success">
                    <div class="rui-task-icon">
                      <span class="fa fa-history"></span>
                    </div>
                    <div class="rui-task-content">
                      <b class="rui-task-title">{{ notif.data.action }}</b>
                      <small
                        class="rui-task-subtitle"
                      >Sent on {{ new Date(notif.created_at).toDateString() }} {{ new Date(notif.created_at).toLocaleTimeString() }}</small>
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
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  export default {
    name: "SuperAdminNotifications",
    mixins: [mixins],
    props: {
      notifications: Array
    },
    components: {
      Layout
    }
  };
</script>
