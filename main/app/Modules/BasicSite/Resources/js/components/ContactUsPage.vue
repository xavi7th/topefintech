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
                    <form
                      :action="$route('app.contact')"
                      @submit.prevent="sendContactMessage"
                      class="contactFrom row"
                      id="contactForm"
                    >
                      <div class="col-md-6">
                        <input
                          class="required"
                          type="text"
                          name="f_name"
                          id="f_name"
                          placeholder="First name*"
                          v-model="form.first_name"
                        />
                      </div>
                      <div class="col-md-6">
                        <input
                          class="required"
                          type="text"
                          name="l_name"
                          id="l_name"
                          placeholder="Last name*"
                          v-model="form.last_name"
                        />
                      </div>
                      <div class="col-md-6">
                        <input
                          class="required"
                          type="email"
                          name="email"
                          id="email"
                          placeholder="Email here*"
                          v-model="form.email"
                        />
                      </div>
                      <div class="col-md-6">
                        <input
                          class="required"
                          type="text"
                          name="phone"
                          id="phone"
                          placeholder="Phone*"
                          v-model="form.phone"
                        />
                      </div>
                      <div class="col-md-12">
                        <input
                          class="required"
                          type="text"
                          name="address"
                          id="address"
                          placeholder="Address (optional)"
                          v-model="form.address"
                        />
                      </div>
                      <div class="col-md-12">
                        <textarea
                          class="required"
                          name="con_message*"
                          id="con_message"
                          placeholder="Text here...."
                          v-model="form.message"
                        ></textarea>
                      </div>
                      <div class="col-md-12">
                        <button
                          name="submit"
                          type="submit"
                          id="con_submit"
                          class="common_btn"
                          :disabled="form.processing"
                        >
                          Send Message
                        </button>
                      </div>
                    </form>
                  </div>
                  <div class="col-lg-5 col-md-5 noPaddingLeft">
                    <div class="gmap">
                      <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.3105294028974!2d5.756351615939262!3d5.520855595996861!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1041b290fda34221%3A0xe2569e7efb709e04!2s35%20Bazunu%20Rd%2C%20Warri!5e0!3m2!1sen!2sng!4v1608733215333!5m2!1sen!2sng"
                        frameborder="0"
                        style="width: 100%; height: 100%; border: 0"
                        allowfullscreen=""
                        aria-hidden="false"
                        tabindex="0"
                      ></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="helpingPost rounded-0 m-0 pt-4">
                <h3 class="text-left mx-0">Our contact details are:</h3>
                <div class="row ml-md-5">
                  <div class="col-12 ml-md-5">
                    <div class="loanDesc">
                      <h5>Call Center:</h5>
                      :
                      <p>{{ $page.props.app.phone }}</p>
                    </div>
                    <div class="loanDesc">
                      <h5><i class="fa fa-envelope-o"></i></h5>
                      :
                      <p>{{ $page.props.app.email }}</p>
                    </div>
                    <div class="loanDesc">
                      <h5><i class="fa fa-user"></i></h5>
                      :
                      <p>{{ $page.props.app.opening_days }}</p>
                    </div>
                    <div class="loanDesc">
                      <h5><i class="fa fa-clock-o"></i></h5>
                      :
                      <p>{{ $page.props.app.opening_hours }}</p>
                    </div>
                    <div class="loanDesc">
                      <h5><i class="fa fa-flag"></i></h5>
                      :
                      <p>{{ $page.props.app.address }}</p>
                    </div>
                    <div class="loanDesc">
                      <h5 class="mt-md-4">Our Community</h5>
                      <ul class="social">
                        <li v-if="$page.props.app.facebook">
                          <a target="_blank" :href="$page.props.app.facebook">
                            <i class="fa fa-facebook"></i>
                          </a>
                        </li>
                        <li v-if="$page.props.app.instagram">
                          <a target="_blank" :href="$page.props.app.instagram">
                            <i class="fa fa-twitter"></i>
                          </a>
                        </li>
                        <li v-if="$page.props.app.twitter">
                          <a target="_blank" :href="$page.props.app.twitter">
                            <i class="fa fa-instagram"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
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
  import { errorHandlers } from "@dashboard-assets/js/config";
  import Layout from "@basicsite-components/BasicSiteAppComponent";

  export default {
    name: "ContactsPage",
    mixins: [mixins, errorHandlers],
    components: { Layout },
    data() {
      return {
        form: this.$inertia.form({
          first_name:null,
          last_name:null,
          email:null,
          phone:null,
          address:null,
          message:null,
          })
      };
    },
    methods: {
      sendContactMessage() {
        BlockToast.fire({
          text: "Please wait...",
        });

        this.form
          .post(this.$route("app.contact"), { ...this.details },{
            onSuccess: () => this.details = {}
          })
      },
    },
  };
</script>
