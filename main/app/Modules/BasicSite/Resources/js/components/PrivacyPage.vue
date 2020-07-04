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
                <small>Last updated: 7/6/2019 10:09:18 AM</small>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Page Banner -->

      <!-- Common Section -->
      <section class="pb-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 faqPdRight">
              <div class="privacyPage pt-0">
                <h3>Accessing Your Information</h3>
                <p>
                  You must notify us of any change in your Personal Information by updating your SmartCoop
                  account profile through our Services. Any changes will affect only future uses of your Personal
                  Information.
                  Subject to applicable law, which might, from time to time, oblige us to store your Personal
                  Information for a certain period of time, we will respect your wishes to correct inaccurate
                  information. Otherwise, we will hold your Personal Information for as long as we believe it will
                  help us achieve our objectives as detailed in this Privacy Policy.
                  You can ask us whether we are storing your Personal Information and you can ask to receive a
                  copy of that Personal Information. Before sending you any Personal Information, we will ask
                  you to provide proof of your identity. If you are not able to provide proof of your identity, we
                  reserve the right to refuse to send you any Personal Information. We will respond as quickly as
                  we can to your requests for details of Personal Information we hold about you.
                </p>
                <h3>Information You Share Socially</h3>
                <p>
                  Our Services may allow you to connect and share your actions, comments, content, and
                  information publicly or with friends. We are not responsible for maintaining the confidentiality
                  of any information you share publicly or with friends.
                  Our Services may also allow you to connect with us on, share on, and use third-party websites,
                  applications, and services. Please be mindful of your personal privacy needs and the privacy
                  needs of others, as you choose whom to connect with and what to share and make public. We
                  cannot control the privacy or security of information you choose to make public or share with
                  others. We also do not control the privacy practices of third parties. Please contact those sites and
                  services directly if you want to learn about their privacy practices.
                </p>
                <h3>Security</h3>
                <p>
                  We have, and require our third-party service providers that receive Personal Information from us
                  to have, a comprehensive written information security program that contains administrative,
                  technical, and physical safeguards for our respective physical facilities and in our respective
                  computer systems, databases, and communications networks that are reasonably designed to
                  protect information contained within such systems from loss, misuse, or alteration. When your
                  bank account information is transmitted via our Services, it will be protected by encryption
                  technology, such as Secure Sockets Layer (SSL).
                  No method of electronic transmission or storage is 100% secure. Therefore, we cannot guarantee
                  absolute security of your Personal Information. You also play a role in protecting your Personal
                  Information. Please safeguard your username and password for your SmartCoop account and do
                  not share them with others. If we receive instructions using your SmartCoop account login
                  information, we will consider that you have authorized the instructions. You agree to notify us
                  immediately of any unauthorized use of your SmartCoop account or any other breach of security.
                  We reserve the right, in our sole discretion, to refuse to provide our Services, terminate
                  SmartCoop accounts, and to remove or edit content.
                </p>
                <h3>Protecting Children&#39;s Privacy</h3>
                <p>
                  Our Services are not directed, or intended to be attractive to children under the age of 18. We do
                  not knowingly collect Personal Information from children under the age of 18. If you are under
                  the age of 18, do not use our Services or submit any information to us.
                </p>
                <h3>Links to Third-Party Websites</h3>
                <p>
                  When you use our Services, you may be directed to other websites that are beyond our control.
                  We may also allow third-party websites or applications to link to our Services. We are not
                  responsible for the privacy practices of any third parties or the content of linked websites, but we
                  do encourage you to read the applicable privacy policies and terms and conditions of such parties
                  and websites. This Privacy Policy only applies to our Services.
                </p>
                <h3>Changes to our Privacy Policy</h3>
                <p>
                  Subject to applicable law, we may revise this Privacy Policy at any time and in our sole
                  discretion. When we revise this Privacy Policy, we will post the revised version via our Services
                  and will update the date at the top of this Privacy Policy. The revised Privacy Policy will be
                  effective upon posting via our Services, unless otherwise set forth therein or as otherwise
                  required by applicable law. You are free to decide whether or not to accept a revised version of
                  this Privacy Policy, but accepting this Privacy Policy, as revised, is required for you to continue
                  accessing or using our Services. If you do not agree to the terms of this Privacy Policy or any
                  revised version of this Privacy Policy, your sole recourse is to terminate your access and use of
                  our Services. Except as otherwise expressly stated by us, your access and use of our Services is
                  subject to the version of this Privacy Policy in effect at the time of access or use.
                </p>
                <h3>How can I contact SmartCoop?</h3>
                <p>
                  If you have any questions, comments, or concerns regarding these Terms or the Services, please
                  contact us via email at
                  <a
                    :href="`mailto:${$page.app.email}`"
                  >{{ $page.app.email }}</a> or phone
                  <a href="tel:08098075887">08098075887</a>.
                </p>
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
    name: "PrivacyPage",
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
