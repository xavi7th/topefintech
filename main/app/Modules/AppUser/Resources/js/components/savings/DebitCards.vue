<template>
  <layout title="Debit Cards" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-3">
          <button type="button" class="btn btn-success btn-long">
            <span class="text">Add Card</span>
          </button>&nbsp;
        </div>
      </div>
      <div class="rui-gap-2"></div>
      <div class="row vertical-gap">
        <div class="col-3">
          <div class="card">
            <div
              class="card-body"
              style="background-color: #3F51B5; border-radius: .5em; color: #fff;"
            >
              <h6 class="card-subtitle h4 text-muted mt-60 text-white" style="font-size: 1.8rem;">
                <strong>XXXX XXXX XXXX 8976</strong>
              </h6>
              <a class="card-link">Expiry</a>
              <br />
              <span style="font-size: 1.5rem;">02 / 21</span>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="card">
            <div
              class="card-body"
              style="background-color: #E91E63; border-radius: .5em; color: #fff;"
            >
              <h6 class="card-subtitle h4 text-muted mt-60 text-white" style="font-size: 1.8rem;">
                <strong>XXXX XXXX XXXX 8976</strong>
              </h6>
              <a class="card-link">Expiry</a>
              <br />
              <span style="font-size: 1.5rem;">02 / 21</span>
            </div>
          </div>
        </div>
      </div>
      <div class="rui-gap-2"></div>
      <div class="rui-gap-2"></div>
      <div class="rui-gap-3"></div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "DebitCards",
    mixins: [mixins],
    components: {
      Layout
    },
    data: () => {
      return {};
    }
  };
</script>

<style lang="scss" scoped>
  .card {
    &.rounded {
      border-radius: 5px;
    }
  }
</style>
