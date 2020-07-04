<template>
  <layout title="Our Blog">
    <div class="full-page">
      <!-- Page Banner -->
      <section class="pagebanner">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="bannerTitle text-left">
                <h2>Contact Us</h2>
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
      <section class="commonSection contactPage">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="formArea">
                <div class="row">
                  <div class="col-lg-7 col-md-7">
                    <form action="#" method="post" class="contactFrom row" id="contactForm">
                      <div class="col-md-6">
                        <input
                          class="required"
                          type="text"
                          name="f_name"
                          id="f_name"
                          placeholder="First name*"
                        />
                      </div>
                      <div class="col-md-6">
                        <input
                          class="required"
                          type="text"
                          name="l_name"
                          id="l_name"
                          placeholder="Last name*"
                        />
                      </div>
                      <div class="col-md-12">
                        <input
                          class="required"
                          type="email"
                          name="email"
                          id="email"
                          placeholder="Email here*"
                        />
                      </div>
                      <div class="col-md-6">
                        <input
                          class="required"
                          type="text"
                          name="phone"
                          id="phone"
                          placeholder="Phone*"
                        />
                      </div>
                      <div class="col-md-6">
                        <input
                          class="required"
                          type="text"
                          name="address"
                          id="address"
                          placeholder="Address*"
                        />
                      </div>
                      <div class="col-md-12">
                        <textarea
                          class="required"
                          name="con_message*"
                          id="con_message"
                          placeholder="Text here...."
                        ></textarea>
                      </div>
                      <div class="col-md-12">
                        <button
                          name="submit"
                          type="submit"
                          id="con_submit"
                          class="common_btn"
                        >Send Message</button>
                      </div>
                    </form>
                  </div>
                  <div class="col-lg-5 col-md-5 noPaddingLeft">
                    <div class="gmap">
                      <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.29553869827!2d3.5827810152795734!3d6.484206825416578!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bfa014096ae43%3A0xc6c3ac2f3ba9ed84!2sJanet%20Akitola%20St%2C%20Eti-Osa%2C%20Lekki!5e0!3m2!1sen!2sng!4v1575482608176!5m2!1sen!2sng"
                        frameborder="0"
                        style="width:100%; border:0; height:100%"
                        allowfullscreen
                      ></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="helpingPost rounded-0 m-0 pt-4">
                <h3 class="text-left mx-0">Our contact details are:</h3>
                <div class="row ml-5">
                  <div class="col-12 ml-5">
                    <div class="loanDesc">
                      <h5>Email</h5>:
                      <p>{{ $page.app.email }}</p>
                    </div>
                    <div class="loanDesc">
                      <h5>WhatsApp</h5>:
                      <p>{{ $page.app.whatsapp }}</p>
                    </div>
                    <div class="loanDesc">
                      <h5>Call Center:</h5>:
                      <p>{{ $page.app.phone }}</p>
                    </div>
                  </div>
                </div>
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
    name: "ContactsPage",
    mixins: [mixins],
    components: { Layout }
  };
</script>

<style lang="scss" scoped>
</style>
