<template>
  <layout title="All Transaction Logs">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12 col-lg-8 offset-lg-2">
          <statement-of-account :account_statement="allTransactions" />
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent";
  import StatementOfAccount from '@dashboard-components/savings/partials/StatementOfAccount.vue';

  export default {
    mixins: [mixins],
    props: {
      allTransactions: Array,
      appUser: Object
    },
    components: {
      Layout,
      StatementOfAccount
    }
  };
</script>
