<template>
  <layout :title="`${appUser.full_name}'s Account Statement`">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12 col-lg-8 offset-lg-2">
          <statement-of-account :account_statement="account_statement" />
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
      account_statement: Array,
      appUser: Object
    },
    components: {
      Layout,
      StatementOfAccount
    }
  };
</script>
