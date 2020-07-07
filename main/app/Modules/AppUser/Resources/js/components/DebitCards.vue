<template>
  <layout title="Debit Cards" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-12">
          <button
            type="button"
            class="btn btn-brand"
            data-toggle="modal"
            data-target="#createDebitCardModal"
          >Add Card</button>
        </div>
      </div>
      <div class="rui-gap-2"></div>
      <div class="row vertical-gap">
        <div
          class="col-md-4"
          v-for="(debit_card,idx) in $page.debit_cards.data"
          :key="debit_card.id"
        >
          <div class="card">
            <button
              type="button"
              class="btn btn-outline-dark btn-uniform btn-delete"
              @click="deleteCard(debit_card)"
            >
              <span class="icon">
                <span data-feather="x" class="rui-icon rui-icon-stroke-1_5"></span>
              </span>
            </button>
            <div :class="`card-body card${(idx % 5) + 1}`">
              <h6 class="card-subtitle h4 text-muted mt-60 text-white" style="font-size: 1.8rem;">
                <strong>{{debit_card.pan}}</strong>
              </h6>
              <a class="card-link">Expiry</a>
              <br />
              <span style="font-size: 1.5rem;">{{debit_card.month}} / {{debit_card.year}}</span>
              <button
                class="btn btn-dark default-card btn-sm disabled"
                v-if="debit_card.is_default"
              >Default Card</button>
              <button
                class="default-card btn btn-dark btn-sm"
                @click="markDefaultCard(debit_card)"
                v-else
              >Mark As Default</button>
              <button
                class="default-card btn btn-light btn-sm"
                @click="authorizeCard(debit_card)"
                v-if="!debit_card.is_authorised"
              >Authorize Card</button>
              <button class="default-card btn btn-light btn-sm" disabled v-else>Card Authorized</button>
            </div>
          </div>
        </div>
      </div>
      <div class="rui-gap-2"></div>
      <div class="rui-gap-2"></div>
      <div class="rui-gap-3"></div>
    </div>
    <template v-slot:modals>
      <modal modalId="createDebitCardModal" modalTitle="Add New Debit Card">
        <form class="#" @submit.prevent="addCard">
          <FlashMessage />
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="card-pan">Card PAN</label>
              <input
                type="number"
                class="form-control"
                id="card-pan"
                v-model="details.pan"
                placeholder="Card Number"
              />
              <FlashMessage v-if="errors.pan" :msg="errors.pan[0]" />
            </div>
            <div class="col-md-4 col-6">
              <label for="card-expiry-month">Expiry Month</label>
              <select id="card-expiry-month" v-model="details.month" class="form-control">
                <option :value="null">Choose</option>
                <option v-for="n in 12" :key="n">{{n}}</option>
              </select>
            </div>
            <div class="col-md-4 col-6">
              <label for="card-expiry-year">Expiry Year</label>
              <select id="card-expiry-year" v-model="details.year" class="form-control">
                <option :value="null">Choose</option>
                <option
                  v-for="n in 80"
                  :key="n -1 +(new Date().getFullYear())"
                >{{ n - 1 + (new Date().getFullYear()) }}</option>
              </select>
            </div>
            <div class="col-md-4 col-6">
              <label for="card-cvv">CVV</label>
              <input
                type="number"
                class="form-control"
                id="card-cvv"
                v-model="details.cvv"
                placeholder="Enter CVV"
              />
            </div>
            <div class="col-12 d-none d-md-block">
              <FlashMessage v-if="errors.cvv" :msg="errors.cvv[0]" />
              <FlashMessage v-if="errors.year" :msg="errors.year[0]" />
              <FlashMessage v-if="errors.month" :msg="errors.month[0]" />
            </div>
            <div class="col-md-12 mt-30 mt-md-0 col-6 text-center">
              <button type="submit" class="btn btn-success btn-long">
                <span class="text">Add</span>
              </button>
            </div>
            <div class="col-12 d-md-none">
              <FlashMessage v-if="errors.cvv" :msg="errors.cvv[0]" />
              <FlashMessage v-if="errors.year" :msg="errors.year[0]" />
              <FlashMessage v-if="errors.month" :msg="errors.month[0]" />
            </div>
          </div>
        </form>
      </modal>
    </template>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  import axios from "axios";
  export default {
    name: "DebitCards",
    mixins: [mixins],
    components: {
      Layout
    },
    data: function() {
      return {
        debit_cards: this.$page.debit_cards,
        details: {
          month: null,
          year: null
        }
      };
    },
    methods: {
      authorizeCard(debitCard) {
        BlockToast.fire({
          text: "Processing ..."
        });

        this.$inertia
          .visit(this.$route("appuser.cards.authorize", debitCard.id), {
            method: "get",
            data: {},
            replace: false,
            preserveState: false,
            preserveScroll: false
          })
          .then(() => {
            if (this.flash.success) {
              ToastLarge.fire({
                title: "Success",
                html: this.flash.success,
                position: "bottom",
                icon: "success",
                timer: 5000
              });
            } else if (this.flash.error) {
              ToastLarge.fire({
                title: "Error",
                html: this.flash.error,
                position: "bottom",
                icon: "error",
                timer: 10000
              });
            } else {
              swal.close();
            }
          });
      },
      markDefaultCard(debitCard) {
        BlockToast.fire({
          text: "Updating default card..."
        });

        this.$inertia
          .put(
            this.$route("appuser.cards.default"),
            {
              debit_card_id: debitCard.id
            },
            {
              preserveState: true,
              preserveScroll: false
            }
          )
          .then(() => {
            if (this.flash.success) {
              ToastLarge.fire({
                title: "Success",
                html: this.flash.success,
                position: "bottom",
                icon: "success",
                timer: 10000
              });
            } else {
              swal.close();
            }
          });
      },
      addCard() {
        BlockToast.fire({
          text: "Adding card to your account. Please wait..."
        });

        this.$inertia
          .post(
            this.$route("appuser.cards.add"),
            { ...this.details },
            {
              preserveState: true,
              preserveScroll: false
            }
          )
          .then(() => {
            if (this.flash.success) {
              this.details = {};
              Toast.fire({
                title: "Success",
                text: this.flash.success,
                position: "center bottom"
              });
            } else {
              swal.close();
            }
          });
      },
      deleteCard(debitCard) {
        swalPreconfirm
          .fire({
            confirmButtonText: "Carry on!",
            text: "This will permanently delete this card from your account",
            preConfirm: () => {
              return axios
                .delete(this.$route("appuser.cards.delete", debitCard))
                .then(rsp => {
                  return true;
                })
                .catch(error => {
                  if (error.response) {
                    swal.showValidationMessage(
                      `Request failed: ${error.response.data.message}`
                    );
                  } else {
                    swal.showValidationMessage(`Request failed: ${error}`);
                  }
                });
            }
          })
          .then(val => {
            if (val.isDismissed) {
              Toast.fire({
                title: "Canceled",
                icon: "info",
                position: "center"
              });
            } else if (val.value) {
              this.$inertia.reload({
                method: "get",
                data: {},
                preserveState: false,
                preserveScroll: true,
                only: ["debit_cards"]
              });
              ToastLarge.fire({
                title: "Success",
                html: `Debit Card <b>${debitCard.pan}</b> has been deleted from your account`,
                position: "bottom",
                icon: "success",
                timer: 10000
              });
            }
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
  $themeColors: (
    "card1": #dc51ac,
    "card2": #d64651,
    "card3": #e55937,
    "card4": #3f51b5,
    "card5": #e91e63
  );

  @each $themeColor, $i in $themeColors {
    .card-body {
      &.#{$themeColor} {
        background-color: $i;
      }
    }
  }
  .card {
    &.rounded {
      border-radius: 5px;
    }

    .card-body {
      border-radius: 0.5em;
      color: #fff;

      .default-card {
        float: right;
      }
    }

    .btn-delete {
      background-color: #fff;
      position: absolute;
      padding: 5px;
      right: 0;
      font-size: 9px;
    }
  }

  .mt-md-0 {
    @media (min-width: 768px) {
      margin-top: 0 !important;
    }
  }
</style>
