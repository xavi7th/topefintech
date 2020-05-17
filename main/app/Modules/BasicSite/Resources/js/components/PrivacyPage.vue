<template>
  <layout title="Privacy">
    <div class="full-page">
      <!-- Page Banner -->
      <section class="pagebanner">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="bannerTitle text-left">
                <h2>Privacy Policy</h2>
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
      <section class="commonSection faqPage">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 faqPdRight">
              <div class="singleFaq">
                <h3>01. Make your start the world possible?</h3>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Common Section -->
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@basicsite-assets/js/misc";
  import Layout from "@basicsite-components/BasicSiteAppComponent";
  export default {
    name: "PrivacyPage",
    components: { Layout },
    mixins: [mixins],
    mounted() {
      this.$emit("page-loaded");
    },
    beforeDestroy() {
      this.$unloadScript("/js/main.js");
    }
  };
</script>

<style lang="scss" scoped>
</style>
