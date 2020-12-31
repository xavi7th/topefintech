<template>
  <div class="container-fluid">
    <h2>My Vault</h2>

    <div
      class="row rui-swiper"
      id="vaultStatistics"
      data-swiper-initialslide="0"
      data-swiper-loop="false"
      data-swiper-grabcursor="false"
      data-swiper-center="false"
      data-swiper-slides="auto"
      data-swiper-gap="30"
      data-swiper-speed="400"
    >
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <template
            v-if="
              !userSavings.length &&
              !maturedSavings.length &&
              !liquidatedSavings.length
            "
          >
            <div class="swiper-slide">
              <div class="rui-widget rui-widget-chart">
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">{{ 0 | Naira }}</div>
                  <small class="rui-widget-subtitle">No Interests</small>
                </div>
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    data-chartist-series="1,20"
                    data-chartist-width="4"
                    data-chartist-gradient="#ff8ebc;#ef2b5a"
                  ></div>
                </div>
              </div>
            </div>
          </template>
          <template v-else>
            <div
              class="swiper-slide"
              v-for="portfolio in maturedSavings"
              :key="portfolio.id"
            >
              <div class="rui-widget rui-widget-chart">
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`1,1`"
                    data-chartist-width="4"
                    data-chartist-gradient="#ff8ebc;#ef2b5a"
                  ></div>
                </div>
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">
                    {{ portfolio.current_balance | Naira }}
                  </div>
                  <small class="rui-widget-subtitle text-uppercase text-danger text-center"
                    >MATURED: <br> {{ portfolio.name }} Savings</small
                  >
                  <div class="d-flex">
                    <button
                      class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-warning btn-xs mr-5"
                      v-if="!portfolio.has_withdrawal_request"
                      @click="
                        withdrawSavings(
                          portfolio,
                          'Withdraw mature ' + portfolio.name + ' savings funds'
                        )
                      "
                    >
                      Withdraw
                    </button>
                    <button
                      class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-info btn-xs mr-5"
                      v-else
                    >
                      Withdrawal Requested
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="swiper-slide"
              v-for="portfolio in liquidatedSavings"
              :key="portfolio.id"
            >
              <div class="rui-widget rui-widget-chart">
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`1,1`"
                    data-chartist-width="4"
                    data-chartist-gradient="#ff8ebc;#ef2b5a"
                  ></div>
                </div>
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">
                    {{ portfolio.current_balance | Naira }}
                  </div>
                  <small class="rui-widget-subtitle text-uppercase text-danger text-center"
                    >Liquidated: <br> {{ portfolio.name }} Savings</small
                  >
                  <div class="d-flex">
                    <button
                      class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-warning btn-xs mr-5"
                      v-if="portfolio.can_withdraw"
                      @click="
                        withdrawSavings(
                          portfolio,
                          'Withdraw liquidated smart savings funds'
                        )
                      "
                    >
                      Withdraw
                    </button>
                    <div
                      class="alert alert-danger btn-xs fs-11"
                      role="alert"
                      v-else
                    >
                      LOCKED: {{ portfolio.locktime_countdown }} days
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="swiper-slide"
              v-for="portfolio in userSavings"
              :key="portfolio.id"
            >
              <div class="rui-widget rui-widget-chart">
                <div class="rui-chartjs-container">
                  <div
                    class="rui-chartist rui-chartist-donut"
                    data-width="200"
                    data-height="200"
                    :data-chartist-series="`${portfolio.total_duration},${portfolio.elapsed_duration}`"
                    data-chartist-width="4"
                    data-chartist-gradient="#ff8ebc;#ef2b5a"
                  ></div>
                </div>
                <div class="rui-widget-chart-info">
                  <div class="rui-widget-title h2">
                    {{ portfolio.total_unprocessed_interest_amount | Naira }}
                  </div>
                  <small class="rui-widget-subtitle text-capitalize"
                    >Interests: {{ portfolio.name }} Savings</small
                  >
                  <div class="d-flex">
                    <button
                      type="button"
                      v-if="portfolio.interests_withdrawable"
                      class="justify-content-center mt-10 mt-sm-0 btn btn-shadow btn-warning btn-xs mr-5"
                        @click="
                        withdrawInterests(
                          portfolio,
                          'Withdraw accrued ' + portfolio.name + ' savings interests'
                        )
                      "
                    >
                      Withdraw
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="swiper-button-next">
        <span
          data-feather="chevron-right"
          class="rui-icon rui-icon-stroke-1_5"
        ></span>
      </div>
      <div class="swiper-button-prev">
        <span
          data-feather="chevron-left"
          class="rui-icon rui-icon-stroke-1_5"
        ></span>
      </div>
    </div>

    <div class="rui-gap-3"></div>
    <div class="rui-gap-3"></div>
  </div>
</template>

<script>
  import { errorHandlers, getErrorString } from "@dashboard-assets/js/config";

  export default {
    name: "VaultStatistics",
    mixins: [errorHandlers],
    props: {
      userSavings: Array,
      liquidatedSavings: Array,
      maturedSavings: Array,
    },
    data: () => {
      return {
        details: {},
      };
    },
    methods: {
      makeSavings(amount = null) {
        BlockToast.fire({
          text: "Initialising transaction ...",
        });
        this.$inertia
          .get(this.$route("appuser.paystack.initialise"), {
              amount: amount || this.details.amount,
              description:
                "Fund savings into account of " + this.$options.filters.Naira(amount),
            },
            {
            replace: false,
            preserveState: false,
            preserveScroll: true,
            only: ["errors", "flash"],
          })
      },
      withdrawSavings(savings, description) {
        swalPreconfirm
          .fire({
            confirmButtonText: "Carry on!",
            text:
              "This will close this savings portfolio and send a request for its current balance.",
            preConfirm: () => {
              return this.$inertia
                .post(this.$route("appuser.withdraw.create", savings.id), {
                  description,
                },{
                  onSuccess: page =>{
                    if (!page.props.flash.error) {
                       if (page.props.flash.verification_needed) {
                        swal
                          .fire({
                            title: "OTP Required!",
                            html: page.props.flash.verification_needed,
                            icon: "info",
                          })
                          .then(() => {
                            swal
                              .fire({
                                title: "Enter Verification OTP",
                                input: "text",
                                inputAttributes: {
                                  autocapitalize: "off",
                                  autocomplete: false,
                                  required: true,
                                },
                                showCancelButton: false,
                                focusCancel: false,
                                allowOutsideClick: false,
                                confirmButtonText: "Verify Withdrawal",
                                showLoaderOnConfirm: true,
                                preConfirm: (otp) => {
                                  return this.$inertia.post(this.$route("appuser.withdraw.verify"), {otp})
                                },
                                allowOutsideClick: () => !swal.isLoading(),
                              })
                              .then((result) => {
                                if (result.dismiss) {
                                  swal.fire({
                                    title: "Cancelled",
                                    text: "Your withdrawal request cannot be processed without supplying your OTP. If you are yet to receive your OTP, kindly contact our support team",
                                    icon: "info",
                                    footer: `Our email: &nbsp;&nbsp;&nbsp; <a target="_blank" href="mailto:${page.props.app.email}">${page.props.app.email}</a>`,
                                  });
                                }
                              });
                          });
                      }
                    }
                  }
                })
            },
          })
          .then((val) => {
            if (val.isDismissed) {
              Toast.fire({
                title: "Canceled",
                icon: "info",
                position: "center",
              });
            }
          });
      },
      withdrawInterests(savings, description) {
        swalPreconfirm
          .fire({
            confirmButtonText: "Proceed with Request",
            text:
              "This will create a request for all your accrued interests till date.",
            preConfirm: () => {
              return this.$inertia
                .post(this.$route("appuser.withdraw_interests.create", savings.id), {
                  description,
                },{
                  onSuccess: page => {
                    if (page.props.flash.verification_needed) {
                      swal
                        .fire({
                          title: "OTP Required!",
                          html: page.props.flash.verification_needed,
                          icon: "info",
                        })
                        .then(() => {
                          swal
                            .fire({
                              title: "Enter Verification OTP",
                              input: "text",
                              inputAttributes: {
                                autocapitalize: "off",
                                autocomplete: false,
                                required: true,
                              },
                              showCancelButton: false,
                              focusCancel: false,
                              allowOutsideClick: false,
                              confirmButtonText: "Verify Withdrawal",
                              showLoaderOnConfirm: true,
                              preConfirm: (otp) => {
                                return this.$inertia
                                  .post(this.$route("appuser.withdraw_interests.verify"), {
                                    otp,
                                  })
                              },
                              allowOutsideClick: () => !swal.isLoading(),
                            })
                            .then((result) => {
                              if (result.dismiss) {
                                swal.fire({
                                  title: "Cancelled",
                                  text: "Your withdrawal request cannot be processed without supplying your OTP. If you are yet to receive your OTP, kindly contact our support team",
                                  icon: "info",
                                });
                              }
                            });
                        });
                    }
                  }
                })
            },
          })
          .then((val) => {
            if (val.isDismissed) {
              Toast.fire({
                title: "Canceled",
                icon: "info",
                position: "center",
              });
            }
          });
      },
    },
  };
</script>
