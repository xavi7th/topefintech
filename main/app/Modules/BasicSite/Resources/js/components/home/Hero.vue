<template>
  <section class="payloan_header_bg header_bg_2 px-xl-1">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 order-md-2">
          <div class="header_img">
            <img src="img/slider/5.png" alt />
          </div>
        </div>
        <div class="col-md-6 order-md-1">
          <div class="welcome_area">
            <div class="welcome_text">
              <h1>The Better Way To Learn And Grow</h1>
              <p>SmartMonie bridges the knowledge gap in personal finance and offer smarter ways to save and invest</p>
            </div>
            <div class="welcome_button">
              <a href="#" class="common_btn">Contact Us</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<style lang="scss" scoped>
  .header_bg_2 {
    position: relative;
    padding: 130px 0 70px;

    @media (max-width: 767px) and (min-width: 576px) {
      padding-top: 50px;

      img {
        width: 50%;
        margin: 10px auto;
        display: block;
      }

      .welcome_area {
        margin: 20px -25px 0;
      }
    }

    @media (max-width: 575px) {
      ☄img {
        width: 80% !important;
        margin: 20px auto !important;
        display: block !important;
      }
    }
  }
</style>
