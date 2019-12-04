<template>
  <header class="header_1" id="header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-3 col-md-3">
          <div class="logo">
            <a href="index.html">
              <img src="/img/logo.png" alt />
            </a>
          </div>
        </div>
        <div class="col-lg-7 col-md-7">
          <nav class="mainmenu MenuInRight text-right">
            <a href="javascript:void(0);" class="mobilemenu d-md-none d-lg-none d-xl-none">
              <span></span>
              <span></span>
              <span></span>
            </a>
            <ul>
              <li class="menu-item-has-children">
                <a href="#">home</a>
                <ul class="sub-menu">
                  <li>
                    <a href="index.html">Home 01</a>
                  </li>
                  <li>
                    <a href="index2.html">Home 02</a>
                  </li>
                </ul>
              </li>
              <li class="menu-item-has-children">
                <a href="#">Services</a>
                <ul class="sub-menu">
                  <li>
                    <a href="services.html">Service 01</a>
                  </li>
                  <li>
                    <a href="services2.html">Service 02</a>
                  </li>
                  <li>
                    <a href="service_details.html">Service Details</a>
                  </li>
                </ul>
              </li>
              <li class="menu-item-has-children">
                <a href="#">Pages</a>
                <ul class="sub-menu">
                  <li>
                    <a href="about.html">About</a>
                  </li>
                  <li>
                    <a href="404.html">404 Page</a>
                  </li>
                  <li>
                    <a href="faq.html">Faq Page</a>
                  </li>
                  <li class="menu-item-has-children">
                    <a href="#">Portfolio</a>
                    <ul class="sub-menu">
                      <li>
                        <a href="portfolio.html">Portfolio</a>
                      </li>
                      <li>
                        <a href="portfolio_detail.html">Portfolio Details</a>
                      </li>
                    </ul>
                  </li>
                  <li class="menu-item-has-children">
                    <a href="#">Testimonial</a>
                    <ul class="sub-menu">
                      <li>
                        <a href="testimonial.html">Testimonial 01</a>
                      </li>
                      <li>
                        <a href="testimonial2.html">Testimonial 02</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a href="team.html">Team Member</a>
                  </li>
                  <li>
                    <a href="application_form.html">Application Form</a>
                  </li>
                  <li>
                    <a href="loan_calculation.html">Loan Calculation</a>
                  </li>
                </ul>
              </li>
              <li class="menu-item-has-children">
                <a href="#">Blog</a>
                <ul class="sub-menu">
                  <li>
                    <a href="blog.html">Blog Page</a>
                  </li>
                  <li>
                    <a href="single_blog.html">Blog Details</a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="contact.html">Contact</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-lg-2 col-md-2 hidden-xs">
          <div class="navigator_btn btn_bg text-right">
            <a class="common_btn" href="#">Apply Now</a>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
  export default {
    name: "Header",
    props: {
      isHome: {
        type: Boolean,
        default: false,
        required: true
      }
    },
    data() {
      return {};
    },
    computed: {
      breadcrumb() {
        return this.$route.meta.breadcrumb;
      },
      routes() {
        return this.$router.options.routes.filter(x => !x.meta.navSkip);
      }
    }
  };
</script>

<style lang="scss">
  .mainmenu.MenuInRight.text-right {
    li {
      @media (max-width: 1100px) {
        font-size: 90%;
      }
      @media (max-width: 768px) {
        font-size: 0.6rem;
        padding: 15px 10px;
      }
    }
  }
</style>
