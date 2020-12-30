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
                <small>Last updated: {{ new Date(terms_of_use.updated_at) }}</small>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="pb-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 faqPdRight">
              <div class="termsPage pt-0" v-html="terms_of_use.content">

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
    props:['terms_of_use'],
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
