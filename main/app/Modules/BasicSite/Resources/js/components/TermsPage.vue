<template>
  <layout title="Our Blog">
    <div class="full-page">
      <!-- Page Banner -->
      <section class="pagebanner">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="bannerTitle text-left">
                <h2>Terms and Conditions</h2>
                <small>Last updated: 1/7/1900 8:28:13 PM</small>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="pb-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 faqPdRight">
              <div class="termsPage pt-0">
                <h1>THE BYE-LAWS OF SMART MONIE LIMITED</h1>
                <b>REGISTRATION NUMBER: 000000000000</b>
                <b>INTERPRETATION:</b>
                <p>All words used in these Bye-Laws and defined by Section 57 of the Nigerian Cooperative Societies Act Cap. N98 law of the Federation of Nigeria (LFN) 2004 assigned to them in the above named Section. The following words or expressions shall have the meaning respectively assigned to them below;</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@basicsite-assets/js/misc";
  import Layout from "@basicsite-components/BasicSiteAppComponent";
  export default {
    name: "TermsPage",
    components: { Layout },
    mixins: [mixins]
  };
</script>

<style lang="scss" scoped>
  .termsPage {
    h3 {
      color: #27b3ff;
      font-weight: 500;
      font-size: 2.1rem;
      margin-bottom: 2rem;
      margin-top: 1rem;
    }

    a {
      color: #27b3ff;
    }
  }
</style>
