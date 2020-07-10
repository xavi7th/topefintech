<template>
  <layout title="User Distribution" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-lg-5 col-xl-6">
          <div class="align-items-center justify-content-between mb-25">
            <p class="lead">
              Hey FirstName, We have created multiple payment options. You can either pay with Card or
              Bank Transfer. Your details are secured with PCI-DSS-certified protection.
            </p>
          </div>
          <p>
            <strong>Amount:</strong> ₦5,000
          </p>
          <p>
            <strong>Charges:</strong> ₦50
          </p>
          <a class="btn btn-success btn-long" href="#">Pay Now</a>
          <!-- <a class="btn btn-primary btn-long" href="#">Bank Deposit/Transfer</a>
							<a class="btn btn-brand btn-long" href="#">Pay via oPay</a>
          <a class="btn btn-dark btn-long" href="#">Pay via Agent</a>-->
          <br />
          <br />
          <p class="text-brand">
            <em>
              <strong>Run into any troubles,</strong>
              call us or send
              us a whatsapp message at {{$page.app.phone}} or email us at {{$page.app.email}}
            </em>
          </p>
        </div>
        <div class="col-lg-4 col-xl-4">
          <div class="rui-widget rui-widget-actions">
            <div class="rui-widget-head">
              <h4 class="rui-widget-title">Other Payment Options</h4>
            </div>
            <div class="rui-widget-content">
              <ul class="list-group list-group-flush rui-widget-list">
                <li class="list-group-item">
                  <div class="media media-filled">
                    <a class="media-link">
                      <span class="media-img bg-transparent">
                        <img src="/img/money-card.png" class="icon-file" alt />
                      </span>
                      <span class="media-body">
                        <span class="media-title mb-10">
                          <strong>
                            Pay via bank
                            deposit
                          </strong>
                        </span>
                        <small class="media-subtitle mb-5 text-black">
                          <strong>Account Number:</strong> 00000000000
                        </small>
                        <small class="media-subtitle mb-5 text-black">
                          <strong>Account Name:</strong> Smart Monie
                        </small>
                        <small class="media-subtitle mb-10 text-black">
                          <strong>Bank Name:</strong> United Bank for Africa
                        </small>
                        <small class="media-subtitle mb-5 text-danger">
                          <strong>NB:</strong>
                          Depositor’s name/description
                          should be your email address.
                          After payment sent your proof of payment to
                          {{$page.app.email}}
                        </small>
                      </span>
                    </a>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="media media-filled">
                    <a class="media-link">
                      <span class="media-img bg-transparent">
                        <img src="/img/business.png" class="icon-file" alt />
                      </span>
                      <span class="media-body">
                        <span class="media-title mb-10">
                          <strong>
                            Pay via our Payment
                            Agents
                          </strong>
                        </span>
                        <small class="media-subtitle mb-5 text-danger">
                          <strong>
                            Kindly find the details of our authorized payment agents
                            across the country.
                          </strong>
                        </small>
                        <small class="media-subtitle mb-5 text-black">
                          <strong>
                            1. Dafe Onosu – 0809494949 – Choba Port
                            Harcourt
                          </strong>
                        </small>
                        <small class="media-subtitle mb-5 text-black">
                          <strong>
                            2. Jerry Gana – 0809494949 – Choba Port
                            Harcourt
                          </strong>
                        </small>
                      </span>
                    </a>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="media media-filled">
                    <a class="media-link">
                      <span class="media-img bg-transparent">
                        <img src="/img/pay.png" class="icon-file" alt />
                      </span>
                      <span class="media-body">
                        <span class="media-title mb-10">
                          <strong>Pay via oPay</strong>
                        </span>
                        <small class="media-subtitle mb-5 text-black">
                          <strong>oPay Wallet:</strong> smartmonie
                        </small>
                        <small class="media-subtitle mb-5 text-danger">
                          <strong>NB:</strong>
                          Depositor’s name/description should be your
                          email address.
                          After payment sent your proof of payment to
                          {{$page.app.phone}}
                        </small>
                      </span>
                    </a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <!-- <div class="rui-widget rui-widget-actions">
							<div class="rui-widget-head">
							<h4 class="rui-widget-title"><strong>Other Payment Options</strong></h4>
							</div>
							<div class="rui-widget-content">
							<ul class="list-group list-group-flush rui-widget-list">
							<li class="list-group-item">
							<div class="media media-filled">
							<a href="#" class="media-link">
							<span class="media-img bg-transparent">
							<img src="/img/money-card.png"
							class="icon-file" alt="">
							</span>
							<span class="media-body">
							<span class="media-title">
							<strong>Pay via Bank Deposit</strong>
							given
							you authorization to make use of his/her
							details. Else your
							request may be declined.
							</span>
							</span>
							</a>
							</div>
							</li>
							<li class="list-group-item">
							<div class="media media-filled">
							<a href="#" class="media-link">
							<span class="media-img bg-transparent">
							<img src="/img/pay.png"
							class="icon-file" alt="">
							</span>
							<span class="media-body">
							<span class="media-title">
							<strong>Pay via OPAY</strong>
							<p>Account Number: 2141490399</p>
							Please do not use a surety
							that hasn't
							given
							you authorization to make use of his/her
							details. Else your
							request may be declined.
							</span>
							</span>
							</a>
							</div>
							</li>
							<li class="list-group-item">
							<div class="media media-filled">
							<a href="#" class="media-link">
							<span class="media-img bg-transparent">
							<img src="/img/business.png"
							class="icon-file" alt="">
							</span>
							<span class="media-body">
							<span class="media-title">
							<strong>Pay via Our agents</strong>
							Please do not use a surety
							that hasn't
							given
							you authorization to make use of his/her
							details. Else your
							request may be declined.
							</span>
							</span>
							</a>
							</div>
							</li>
							</ul>
							</div>
          </div>-->
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "SavingsDistribution",
    mixins: [mixins],
    components: {
      Layout
    },
    data: () => {
      return {};
    }
  };
</script>

<style lang="scss" scoped>
  .card {
    &.rounded {
      border-radius: 5px;
    }
  }
</style>
