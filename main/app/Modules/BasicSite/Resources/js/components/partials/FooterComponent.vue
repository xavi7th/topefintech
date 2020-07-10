<template>
  <div>
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg col-md">
            <aside class="widget about_widgets">
              <img src="/img/logo.png" alt class="footer-logo" />
              <h4>Reach us via</h4>

              <p>
                <i class="fa fa-phone"></i>
                {{ $page.app.phone }}
              </p>

              <a :href="`mailto:${$page.app.email}`">{{ $page.app.email }}</a>

              <h5>Recources</h5>

              <ul>
                <li>
                  <inertia-link :href="$route('app.terms')">Terms &amp; Conditions</inertia-link>
                </li>
                <li>
                  <inertia-link :href="$route('app.faqs')">FAQs</inertia-link>
                </li>
                <li>
                  <inertia-link :href="$route('app.privacy')">Privacy Policy</inertia-link>
                </li>
                <li>
                  <inertia-link :href="$route('app.career')">Careers</inertia-link>
                </li>
                <li>
                  <inertia-link
                    class="hidden-sm hidden-lg hidden-md hidden-xl"
                    :href="$route('app.contact_us')"
                  >Contact Us</inertia-link>
                </li>
              </ul>
            </aside>
          </div>
          <div class="col-12 col-lg-5 col-md">
            <aside class="widget links">
              <h4>We are available:</h4>
              <p>
                Monday - Saturday:
                <br />08:00 AM - 08:00 PM CAT
              </p>
            </aside>
          </div>
          <div class="col-12 col-lg col-md">
            <aside class="widget subscribe_widgets">
              <h4>Find us at:</h4>
              <p class="text-black">{{$page.app.address}}</p>

              <h5 class="mt-5">Our Community</h5>
              <ul class="social">
                <li v-if="$page.app.facebook">
                  <a target="_blank" :href="$page.app.facebook">
                    <i class="fa fa-facebook"></i>
                  </a>
                </li>
                <li v-if="$page.app.instagram">
                  <a target="_blank" :href="$page.app.instagram">
                    <i class="fa fa-twitter"></i>
                  </a>
                </li>
                <li v-if="$page.app.twitter">
                  <a target="_blank" :href="$page.app.twitter">
                    <i class="fa fa-instagram"></i>
                  </a>
                </li>
              </ul>
            </aside>
          </div>
        </div>
      </div>
    </footer>

    <section class="copyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-10">
            <p>Smart Monie is a FinTech based Co-operative Society with Registration Number: 000000000000</p>
          </div>
          <div class="col-sm-2 text-right">
            <p>
              <a href="#" id="backTo">
                <i class="flaticon-chevron"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  export default {
    name: "SiteFooter",
    data: () => ({
      details: {}
    }),
    methods: {
      sendMessage() {
        if (window.hasValidationErrors) {
          Toast.fire({
            type: "error",
            text: "There are errors in the form",
            title: "Oops! "
          });
        } else {
          axios.post(siteContact, { ...this.details }).then(rsp => {
            console.log(rsp);

            if (rsp && rsp.status == 201) {
              this.details = {};
              swal.fire("Sent", `You will be contacted shortly`, "success");
            }
          });
        }
      }
    }
  };
</script>

<style lang="scss" scoped>
  .footer {
    padding-top: 150px;

    ul {
      padding: 0 !important;
    }

    .about_widgets {
      margin-top: 0;
      img {
        max-width: 40%;
        position: absolute;
        top: -100px;
        left: 40px;
      }

      h5 {
        margin-top: 15px;
        margin-bottom: 5px;
      }
      p {
        font-size: 16px;
        line-height: 20px;
      }
    }

    a {
      color: #24b3ff !important;
    }

    .subscribe_widgets {
      input[type="submit"] {
        margin-top: -30px;
        height: 41px;
        line-height: 25px;
      }
    }
    .social {
      display: flex;
      justify-content: space-between;
      width: 40%;
    }
  }
</style>
