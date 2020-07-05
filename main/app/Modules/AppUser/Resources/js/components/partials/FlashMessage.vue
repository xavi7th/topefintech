<script>
  export default {
    name: "FlashMessage",
    props: {
      msg: String
    },
    mounted() {
      setTimeout(() => {
        this.$page.flash.error = null;
        this.$page.flash.success = null;
      }, 3000);
    }
  };
</script>

<style scoped>
  .alert-danger {
    color: #7c2a34;
    background-color: #fcdce0;
    padding: 0.75rem 1.25rem;
  }
  .alert-success {
    color: #186746;
    background-color: #d5f4e7;
    padding: 0.75rem 1.25rem;
  }
  .invalid-feedback {
    display: block;
    text-align: center;
    font-weight: 700;
  }
</style>

<template>
  <div v-if="msg" class="invalid-feedback">
    <span>{{msg}}</span>
  </div>

  <div v-else>
    <transition name="slide-left">
      <div class="alert alert-danger" v-if="$page.flash.error">{{$page.flash.error}}</div>
      <div class="alert alert-success" v-else-if="$page.flash.success">{{$page.flash.success}}</div>
    </transition>
  </div>
</template>
