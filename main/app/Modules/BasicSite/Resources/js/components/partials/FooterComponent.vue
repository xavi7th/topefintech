<template>
  <div>
    <footer class="footer footer_2">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <aside class="widget about_widgets">
              <img src="/img/logo.png" alt class="footer-logo" />
              <h4>Reach us via</h4>

              <p>
                <i class="fa fa-phone"></i>
                {{ $page.props.app.phone }}
              </p>

              <a :href="`mailto:${$page.props.app.email}`">{{ $page.props.app.email }}</a>

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
              </ul>
            </aside>
          </div>
          <div class="col-lg-4 col-md-6">
            <aside class="widget links">
              <h4>We are available:</h4>
              <p>
                {{ $page.props.app.opening_days }}:
                <br />{{ $page.props.app.opening_hours }}
              </p>
            </aside>
          </div>
          <div class="col-lg-4 col-md-6">
            <aside class="widget subscribe_widgets">
              <h4>Find us at:</h4>
              <p class="text-black">{{$page.props.app.address}}</p>

              <h5 class="mt-5">Our Community</h5>
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
            </aside>
          </div>
        </div>
      </div>
    </footer>

    <section class="copyright copyright_2">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 text-center">
            <p>
              Copyright
              <i class="icofont-copyright"></i>
              {{ new Date().getFullYear() }}; All Right Reserved
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
