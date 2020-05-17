<template>
  <layout title="Our Blog">
    <div class="full-page">
      <!-- Page Banner -->
      <section class="pagebanner">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="bannerTitle text-left">
                <h2>Frequently Ask Question</h2>
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
            <div class="col-lg-6 col-md-6 faqPdRight">
              <div class="singleFaq">
                <h3>01. Make your start the world possible?</h3>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
              </div>
              <div class="singleFaq">
                <h3>02. How much does it cost?</h3>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
              </div>
              <div class="singleFaq">
                <h3>03. Is the universe deterministic?</h3>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 faqPdLeft">
              <div class="singleFaq">
                <h3>04. Do numbers exhibit benford's?</h3>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
              </div>
              <div class="singleFaq">
                <h3>05. Questions about games gambling</h3>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
              </div>
              <div class="singleFaq">
                <h3>06. Which probability are supported?</h3>
                <p>
                  Make a site look like the demo, so to make your
                  start into the world of possible we have include
                  content from and our showcase site import the
                  sample files we ship the core.
                </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
              <h2 class="sec_title">
                If you have others question!
                <br />Please, fillup this form.
              </h2>
              <form class="questinForm row" action="#" method="post">
                <div class="col-lg-6 col-md-6">
                  <input type="email" name="email" placeholder="supportloan@gmail.com" />
                </div>
                <div class="col-lg-6 col-md-6">
                  <input type="number" name="phone" placeholder="+88 00 *** *** ***" />
                </div>
                <div class="col-lg-12 col-md-12">
                  <textarea required name="message" placeholder="Text here...."></textarea>
                </div>
                <div class="col-lg-12 col-md-12">
                  <button class="common_btn" type="submit">Submit Now</button>
                </div>
              </form>
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
    name: "FAQPage",
    mixins: [mixins],
        components: { Layout },
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
