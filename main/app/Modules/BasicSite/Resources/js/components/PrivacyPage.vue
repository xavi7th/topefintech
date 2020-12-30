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
                <small>Last updated: {{ privacy_policy.updated_at }}</small>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="pb-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 faqPdRight">
              <div class="privacyPage pt-0" v-html="privacy_policy.content"></div>
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
    name: "PrivacyPage",
    props:['privacy_policy'],
    components: { Layout },
    mixins: [mixins]
  };
</script>

<style lang="scss" scoped>
  .privacyPage {
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
