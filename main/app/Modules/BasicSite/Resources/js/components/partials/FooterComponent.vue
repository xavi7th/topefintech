<template>
  <div>
    <!-- footer section -->
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <aside class="widget about_widgets">
              <img src="/img/logo.png" alt />
              <p>88 694 895 684</p>
              <p>88 487 983 576</p>
              <p>
                <a
                  href="/cdn-cgi/l/email-protection"
                  class="__cf_email__"
                  data-cfemail="54383b353a24382127143339353d387a373b39"
                >[email&#160;protected]</a>
              </p>
            </aside>
          </div>
          <div class="col-lg-4 col-md-6">
            <aside class="widget recent_posts">
              <div class="singleLPost">
                <h4>
                  <a href="#">What should you need do to get personal loan ver easay.</a>
                </h4>
                <span>20 days ago</span>
                <p>
                  Many modern alternatives often eumen incorpo
                  other content actually detracts from...
                </p>
              </div>
              <div class="singleLPost">
                <h4>
                  <a href="#">What should you need do to get personal loan ver easay.</a>
                </h4>
                <span>20 days ago</span>
                <p>
                  Many modern alternatives often eumen incorpo
                  other content actually detracts from...
                </p>
              </div>
            </aside>
          </div>
          <div class="col-lg-4 col-md-6">
            <aside class="widget subscribe_widgets">
              <h3>Subscribe our newsletter.</h3>
              <form action="#" method="post">
                <input type="email" placeholder="Email address" name="email" />
                <input type="text" placeholder="Phone no." name="phone" />
                <input type="submit" value="Subscribe now" />
              </form>
            </aside>
          </div>
        </div>
      </div>
    </footer>
    <!-- footer section -->

    <!-- Copyright section -->
    <section class="copyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <p>
              Copyright
              <a href="#">Payloan</a>. All rights reserved
            </p>
          </div>
          <div class="col-sm-6 text-right">
            <a href="#" id="backTo">
              <i class="flaticon-chevron"></i>
            </a>
          </div>
        </div>
      </div>
    </section>
    <!-- Copyright section -->
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
  .footer-1 {
    a {
      color: #f5f5f5;
    }
  }
</style>
