<template>
  <layout title="My Account Statement" :isAuth="false">
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
  import Layout from "@dashboard-assets/js/AppComponent";
  import StatementOfAccount from '@dashboard-components/savings/partials/StatementOfAccount.vue';
  export default {
    mixins: [mixins],
    props: {
      account_statement: Array
    },
    components: {
      Layout,
      StatementOfAccount
    }
  };
</script>
