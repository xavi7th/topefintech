<template>
  <div>
    <section class="commonSection postTodaySec">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="sec_title">Save Smartly</h2>
            <p class="sec_desc">You can save daily, weekly and monthly</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-5">
            <div class="latestPost">
              <h4>
                <a href="#">Don’t want to touch your funds over a period of time?</a>
              </h4>
              <p>Try SmartLock to lock your funds till the time you need it. You can break the lock whenever you choose.</p>
              <!-- <a href="#" class="readMore">More details</a> -->
            </div>
            <div class="latestPost">
              <h4>
                <a href="#">Save and invest for the future.</a>
              </h4>
              <p>You can save with long term and short term goals and liquidate after maturity</p>
              <!-- <a href="#" class="readMore">More details</a> -->
            </div>
            <div class="latestPost">
              <h4>
                <a href="#">Request for a SmartLoan.</a>
              </h4>
              <p>In need of cash for your business? Request for a SmartLoan</p>
              <!-- <a href="#" class="readMore">More details</a> -->
            </div>
            <div class="latestPost">
              <h4>
                <a href="#">Save and invest for no reason.</a>
              </h4>
              <p>That money you don’t want to spend but you can’t just keep in in hand, you can save it on SmartCoop</p>
              <!-- <a href="#" class="readMore">More details</a> -->
            </div>
          </div>
          <div class="col-lg-6 col-md-7">
            <div class="featureImg text-center">
              <img src="/img/home/2.png" alt />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="commonSection ab_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-7">
            <div class="singleABThumb">
              <img src="img/about/1.png" alt />
            </div>
          </div>
          <div class="col-lg-6 col-md-5 mt-5">
            <div class="latestPost">
              <h4>
                <a href="#">Save in bits.</a>
              </h4>
              <p>You can save in bits at a particular interval with our SmartSave feature</p>
              <!-- <a href="#" class="readMore">More details</a> -->
            </div>
            <div class="latestPost">
              <h4>
                <a href="#">Watch your savings grow.</a>
              </h4>
              <p>Monitor the progress of your savings from your SmartCoop dashboard in real-time.</p>
              <!-- <a href="#" class="readMore">More details</a> -->
            </div>
            <div class="latestPost">
              <h4>
                <a href="#">Take advantage of GOS.</a>
              </h4>
              <p>Goal Oriented Savings (GOS) helps you save towards a target like paying your rent, buying a car or even that weekend groove you have been craving.</p>
              <!-- <a href="#" class="readMore">More details</a> -->
            </div>
          </div>
          <div class="col-12 text-center">
            <div class="latestPost mt-5">
              <h2>
                <a href="#">Over ₦100,000 is securely saved monthly.</a>
              </h2>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="commonSection callToAction_3">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-9">
            <h3 class="text-white">Invest specific Projects and the your returns in 6 to 12 months</h3>
          </div>
          <div class="col-lg-4 col-md-3 text-center">
            <a class="common_btn" href="#">Visit Investment Shop</a>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style lang="scss" scoped>
  .featureImg {
    img {
      left: -50px;
      position: relative;
    }
  }
  .postTodaySec {
    padding: 0 !important;
  }
  .latestPost:last-of-type {
    border-bottom-color: transparent;
    margin-bottom: 0;
    padding-bottom: 0;
  }
  .callToAction_3 {
    padding: 30px 0 30px;

    .sec_title {
      font-weight: 300;
      text-align: center;
    }

    .common_btn {
      margin-top: 0 !important;
      height: 50px;
      padding: 20px 50px;
      font-weight: 200;
    }
  }
</style>
