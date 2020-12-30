<template>
  <section class="commonSection callToAction_2">
    <div class="container">
      <div class="row">
        <div class="col-md-7 order-2 order-md-1">
          <div class="serviceArea pt-5 text-justify">
            <h3>Your money is well protected</h3>
            <p>
              With <b>bank-grade security</b>. Our payment processors are PCIDSS compliant to ensure optimum security of your data electronically. Also {{$page.props.app.name}} uses the highest levels of Internet Security,
              and it is secured by 256 bits SSL security encryption to ensure that your information is completely protected from fraud.
            </p>
            <p>
              We offer <b>best-in-class investments</b>. We invest in risk free capital markets, mid-stream petroleum marketing, and professionally managed mutual funds. We partner in on only pre-vetted investment opportunities.
            </p>
            <h5>
               Investing with {{ $page.props.app.name }} means your money works hard for you all day every day.
            </h5>
          </div>
        </div>
        <div class="col-md-5 order-1 order-md-2">
          <div class="tw-stretch-element-inside-column">
            <div class="callImage">
              <img src="img/home/4.png" alt />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
