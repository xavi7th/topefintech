<template>
  <div>
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-6">
            <aside class="widget about_widgets">
              <img src="/img/logo.png" alt class="footer-logo" />
              <h4>Reach us via</h4>

              <p>
                <i class="fa fa-phone"></i>
                {{ CONSTANTS.phone1 }}
              </p>

              <a :href="`mailto:${CONSTANTS.email}`">{{ CONSTANTS.email }}</a>

              <h5>Working Hours:</h5>
              <p>Monday - Friday: 08:00 AM - 08:00 PM CAT</p>
              <h5>Find us at:</h5>
              <p
                class="text-black"
              >Janet Akintola Street, Akins Bus Stop, off Addor road, Ajah, Lagos State, Nigeria</p>
            </aside>
          </div>
          <div class="col-lg-3 col-md-6">
            <aside class="widget links">
              <h4>Quick Links</h4>
              <ul>
                <li>
                  <router-link :to="{name:'site.terms'}">Terms &amp; Conditions</router-link>
                </li>
                <li>
                  <router-link :to="{name:'site.faq'}">FAQs</router-link>
                </li>
                <li>
                  <router-link :to="{name:'site.privacy'}">Privacy Policy</router-link>
                </li>
                <li>
                  <router-link :to="{name:'site.career'}">Careers</router-link>
                </li>
                <li>
                  <a
                    href="#"
                  >Click here to get Instant Website &amp; Mobile Apps for your cooperative Society</a>
                </li>
              </ul>
            </aside>
          </div>
          <div class="col-lg-4 col-md-6">
            <aside class="widget subscribe_widgets">
              <h4>Subscribe our newsletter.</h4>
              <form action="#" method="post">
                <input type="email" placeholder="Email address" name="email" />
                <input type="submit" value="Subscribe now" />
              </form>
              <h5 class="mt-5">Our Community</h5>
              <ul class="social">
                <li>
                  <a href="#">
                    <i class="fa fa-facebook"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-twitter"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
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
            <p>
              Smart Cooperative also known as SmartCoop; is a FinTech subsidiary of
              <a
                href="#"
              >Tcom Wireless.</a> RC - 2340415
            </p>
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
  import { siteContact, CONSTANTS } from "@basicsite-assets/js/config";
  export default {
    name: "SiteFooter",
    data: () => ({
      details: {},
      CONSTANTS
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
