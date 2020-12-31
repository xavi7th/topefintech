<script>
  export default {
    name: "Modal",
    props: {
      modalId: String,
      modalTitle: String,
    },
  };
</script>

<template>
  <div
    class="modal fade"
    :id="modalId"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ modalTitle }}</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span data-feather="x" class="rui-icon rui-icon-stroke-1_5"></span>
          </button>
        </div>
        <div class="modal-body">
          <slot></slot>
        </div>
        <div class="modal-footer">
          <slot name="modal-buttons"></slot>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
          <slot name="actionButton"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
