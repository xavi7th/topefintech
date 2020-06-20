<template>
  <layout title="Debit Cards" :isAuth="false">
    <div class="container-fluid">
      <div class="row vertical-gap">
        <div class="col-3">
          <button type="button" class="btn btn-success btn-long">
            <span class="text">Add Card</span>
          </button>&nbsp;
        </div>
      </div>
      <div class="rui-gap-2"></div>
      <div class="row vertical-gap">
        <div
          class="col-md-3"
          v-for="(debit_card,idx) in $page.debit_cards.data"
          :key="debit_card.id"
        >
          <div class="card">
            <div :class="`card-body card${(idx % 5) + 1}`">
              <h6 class="card-subtitle h4 text-muted mt-60 text-white" style="font-size: 1.8rem;">
                <strong>{{debit_card.pan}}</strong>
              </h6>
              <a class="card-link">Expiry</a>
              <br />
              <span style="font-size: 1.5rem;">{{debit_card.month}} / {{debit_card.year}}</span>
              <span class="default-card" v-if="debit_card.is_default">Default</span>
              <button
                class="default-card btn btn-dark"
                @click="markDefaultCard(debit_card)"
                v-else
              >Mark Default</button>
            </div>
          </div>
        </div>
      </div>
      <div class="rui-gap-2"></div>
      <div class="rui-gap-2"></div>
      <div class="rui-gap-3"></div>
    </div>
  </layout>
</template>

<script>
  import { mixins } from "@dashboard-assets/js/config";
  import Layout from "@dashboard-assets/js/AppComponent";
  export default {
    name: "DebitCards",
    mixins: [mixins],
    components: {
      Layout
    },
    data: function() {
      return {
        debit_cards: this.$page.debit_cards
      };
    },
    methods: {
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
              Toast.fire({
                title: "Success",
                text: this.flash.success,
                position: "center bottom"
              });
            } else {
              swal.close();
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
  }
</style>
