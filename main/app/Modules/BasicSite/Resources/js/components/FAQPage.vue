<template>
  <layout title="Frequently Asked Questions">
    <div class="full-page">
      <section class="pagebanner">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="bannerTitle text-left">
                <h2>Frequently Asked Questions</h2>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="commonSection faqPage">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6 faqPdRight">
              <div class="singleFaq">
                <h3>01. What is SmartMonie?</h3>
                <p>-SmartMonie is an online Cooperative Society that encourages her members to save quarterly/monthly/weekly/daily in other to reach achieve their financial goals. Savings attract interest daily.</p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="singleFaq">
                <h3>02. What is SmartMonie?</h3>
                <p>-SmartMonie is an online Cooperative Society that encourages her members to save quarterly/monthly/weekly/daily in other to reach achieve their financial goals. Savings attract interest daily.</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
              <h3>
                If you have others question, kindly
                <inertia-link :href="$route('app.contact_us')" class="view_detail">contact us</inertia-link>&nbsp; or send us a mail at
                <a
                  class="view_detail"
                  :href="`mailto:${app.email}`"
                >{{ app.email }}</a>
              </h3>
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
    props: ["app"],
    mixins: [mixins],
    components: { Layout }
  };
</script>

<style lang="scss" scoped>
  .view_detail {
    color: #27b3ff;
    &:hover {
      color: black;
    }
  }

  .faqPage {
    padding-bottom: 0 !important;
  }
</style>
