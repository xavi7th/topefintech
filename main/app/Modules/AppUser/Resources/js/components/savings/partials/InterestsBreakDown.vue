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
          <div class="rui-gap-3 d-none d-lg-block"></div>
        </div>
      </div>
      <div class="rui-timeline-date">{{ month }}</div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      month:{
        required:true,
        type:String
      },
      interestSummary:{
        required: true,
        type: Object
      }
    }
  };
</script>
