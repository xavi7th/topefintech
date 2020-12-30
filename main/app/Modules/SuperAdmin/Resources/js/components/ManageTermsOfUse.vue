<template>
  <layout title="Manage Terms of Use" :isAuth="false">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <ckeditor
            :editor="editor"
            v-model="details.terms_of_use"
            :config="editorConfig"
            :disabled="editorDisabled"
          ></ckeditor>
        </div>
        <div class="col-12 col-md-6 offset-md-3 justify-content-md-space-around mt-25">
          <button type="button" @click="editorDisabled = !editorDisabled" class="btn btn-warning btn-long ml-25">
            <span class="icon">
              <span
                data-feather="alert-circle"
                class="rui-icon rui-icon-stroke-1_5"
              ></span>
            </span>
            <span class="text">toggle edit</span>
          </button>
          <button type="button" @click="updateTermsOfUse" class="btn btn-primary btn-long">
            <span class="icon">
              <span
                data-feather="plus-circle"
                class="rui-icon rui-icon-stroke-1_5"
              ></span>
            </span>
            <span class="text">Update</span>
          </button>
        </div>
      </div>
    </div>

  </layout>
</template>

<script>
  import { mixins, errorHandlers } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent.vue";
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  import { editorConfig } from "@basicsite-assets/js/bootstrap";

  export default {
    name: "ManageTermsOfUse",
    mixins: [mixins, errorHandlers],
    props: { terms_of_use: String, csrf_token: String },
    components: { Layout },
    data: function() {
      return {
        editor: ClassicEditor,
        editorConfig: editorConfig(route('superadmin.manage_site_contents.image.upload'), this.csrf_token),
        editorDisabled:true,
        details: {
          terms_of_use: this.terms_of_use || 'Terms of Use not yet specified'
        },
      };
    },
    methods: {
      updateTermsOfUse() {
        BlockToast.fire({
          text: "Updating ...",
        });

        this.$inertia
          .post(this.$route("superadmin.manage_site_contents.terms_of_use.update"), this.details, {
            preserveState: true,
            preserveScroll: true,
            only: ["terms_of_use", "errors", "flash"]
          })
      },
    },
  };
</script>

<style lang="scss">
.ck.ck-editor {
    max-width: 100%;
}
.ck-editor__editable_inline {
    min-height: 200px;
    max-height: 90vh;
}
</style>
