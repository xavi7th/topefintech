<template>
  <section class="commonSection custome_sec_2">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="sec_title">
           Financial Education is Key to Long lasting Wealth
          </h2>
          <p class="sec_desc">
            Learn and grow. We are here to help you when you need financial
            support and the required training to get your financial goals on track.
          </p>
        </div>
      </div>
      <div class="row">
       <div class="col-lg-6 col-md-6">
          <div class="customer_thumb">
            <img src="img/about/3.png" alt />
          </div>
        </div>

        <div class="col-lg-6 col-md-6">
          <div class="customer_area">


            <div class="singleCustomer" v-for="testimonial in testimonials" :key="testimonial.name">
              <img class="img-thumbnail img-circle img-rounded"  :src="testimonial.thumb_url" :alt="testimonial.name" />
              <div class="quote_img">
                <img src="img/quote.png" alt />
              </div>
              <p>
                {{testimonial.testimonial}}
              </p>
              <h5>{{testimonial.name}}</h5>
              <!-- <div class="cus_signature">
                <img src="img/signature.png" alt />
              </div> -->
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
.sec_desc{
  @media (max-width: 767px) {
        margin-bottom: 0;
  }
}
</style>


<script>

  export default {
    props: {
      testimonials:Array
    }
  };
</script>
