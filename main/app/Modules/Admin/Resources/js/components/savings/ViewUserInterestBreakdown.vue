<template>
  <layout :title="`${user.full_name} Records for ${month}`" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="rui-timeline rui-timeline-right-lg mt-30">
          <div class="rui-timeline-line"></div>

          <div
            class="rui-timeline-item"
            v-for="(interest_summary, month, idx) in interestSummary"
            :key="idx"
            :class="{'rui-timeline-item-swap' : !!(idx%2)}"
          >
            <div class="rui-timeline-icon">
              <span data-feather="clock" class="rui-icon rui-icon-stroke-1_5"></span>
            </div>
            <div class="rui-timeline-content p-0 border-0">
              <div class="list-group">
                <a
                  href="#home"
                  v-for="(interest, savings_type) in interest_summary"
                  :key="`${interest + savings_type}`"
                  class="list-group-item list-group-item-action"
                  v-bind:class="[ savings_type =='smart' ? 'list-group-item-brand':  'list-group-item-success' ]"
                >
                  <b class="text-capitalize mr-15">{{savings_type}} savings:</b>
                  {{ interest | Naira }}
                </a>
                <div class="rui-gap-3 d-none d-lg-block"></div>
              </div>
            </div>
            <div class="rui-timeline-date">{{ month }}</div>
          </div>
        </div>
      </div>
      <div class="rui-gap-3"></div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@admin-assets/js/AdminAppComponent";
  export default {
    name: "UserInterestBreakdown",
    mixins: [mixins],
    components: {
      Layout
    },
    data: function() {
      return {
        interestSummary: this.$page.props.interests_summary,
        month: this.$page.props.month,
        user: this.$page.props.user
      };
    }
  };
</script>

<style lang="scss" scoped>
  .rui-timeline {
    width: 100%;
  }
</style>
