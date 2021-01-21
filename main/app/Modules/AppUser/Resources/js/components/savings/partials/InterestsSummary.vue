<template>
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
        </div>
        <inertia-link
          :href="$isCurrentUrl('appuser.*') ? $route('appuser.interest.details', month) : $route('superadmin.user.interest.details', [user, month])"
          class="btn btn-info mt-10 mr-0 ml-auto d-block w-30"
        >Details</inertia-link>
      </div>
      <div class="rui-timeline-date">{{ month }}</div>
    </div>
  </div>
</template>

<script>
  export default {
   data: function() {
    return {
      interestSummary: this.$page.props.interests_summary,
      user:this.$page.props.user
    };
  }
  }
</script>

<style lang="scss" scoped>
  .rui-timeline {
    width: 100%;
  }
</style>
