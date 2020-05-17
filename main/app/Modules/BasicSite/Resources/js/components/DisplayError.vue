<template>
  <div class="full-page">
    <!-- Page Banner -->
    <section class="pagebanner">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="bannerTitle text-left">
              <h2>404_Error</h2>
              <p>
                We are here to help you when you need your
                <br />financial support, then we are help you.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Page Banner -->

    <!-- Common Section -->
    <section class="commonSection page_4040">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 offset-lg-3">
            <div class="content_404 text-center">
              <h1>404</h1>
              <h4>Opps! This page is not found.</h4>
              <p>
                Simply import the sample files we ship with the theme
                and the core structur for your site is already mind that
                you don’t use the demo content.
              </p>
              <a class="common_btn" href="#">Back to home</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Common Section -->
  </div>
</template>

<script>
  export default {
    name: "PageNotFound",
    mounted() {
      this.$emit("page-loaded");
    },
    beforeDestroy() {
      this.$unloadScript("/js/main.js");
    }
  };
</script>
