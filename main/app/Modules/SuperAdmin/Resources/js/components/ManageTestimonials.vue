<template>
  <layout title="Manage Testimonials" :isAuth="false">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8">
          <div class="table-responsive">
            <table class="table table-bordered" data-datatable-order="0:asc">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Location</th>
                  <th scope="col">Testimonial</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="testimonial in testimonials" :key="testimonial.id">
                  <th scope="row">{{ testimonial.id }}</th>
                  <td>
                    {{ testimonial.name }}
                    <a :href="testimonial.img" target="_blank">
                      <img :src="testimonial.thumb_url" :alt="`${testimonial.name}'s image`" class="img-responsive img-thumbnail">
                    </a>
                  </td>
                  <td>{{ testimonial.city }}</td>
                  <td>{{ testimonial.testimonial }}</td>
                  <td class="text-capitalize text-nowrap">
                    <button
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateTestimonialModal"
                      @click="details = testimonial"
                    >
                      Edit
                    </button>
                    <button
                      class="btn btn-danger btn-xs"
                      @click="deleteTestimonial(testimonial.id)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-lg-4 col-xl-4">
          <div class="d-flex align-items-center justify-content-between mb-25">
            <h2 class="mnb-2" id="formBase">Create New Testimonial</h2>
          </div>
          <form class="#" @submit.prevent="createTestimonial">
            <div class="row vertical-gap sm-gap">
              <div class="col-12">
                <label for="userName"> User Name </label>
                <input
                  type="text"
                  class="form-control"
                  id="userName"
                  v-model="details.name"
                  placeholder="Please Specify"
                />
              </div>

              <div class="col-12">
                <label for="userImage"> User image </label>
                <input
                  ref="userImage"
                  type="file"
                  class="form-control"
                  id="userImage"
                  accept="image/*"
                />
              </div>

              <div class="col-12">
                <label for="testimonialLocation"> Location </label>
                <input
                  type="text"
                  class="form-control"
                  id="testimonialLocation"
                  v-model="details.city"
                  placeholder="User location"
                />
              </div>

              <div class="col-12">
                <label for="testimonial">
                  Testimonial Details
                </label>
                <textarea
                  type="text"
                  class="form-control"
                  id="testimonial"
                  v-model="details.testimonial"
                  placeholder="User's testimonial"
                />
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-long">
                  <span class="icon">
                    <span
                      data-feather="plus-circle"
                      class="rui-icon rui-icon-stroke-1_5"
                    ></span>
                  </span>
                  <span class="text">Create</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <template v-slot:modals>
      <form class="#" @submit.prevent="updateTestimonial">
        <modal modalId="updateTestimonialModal" modalTitle="Edit Testimonial">
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name"> User Name </label>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="details.name"
                placeholder="User's name"
              />
            </div>

            <div class="col-12">
              <img :src="details.thumb_url" :alt="`${details.name}'s image`" class="img-responsive img-thumbnail">
            </div>

            <div class="col-12">
              <label for="updateUserImage"> User image </label>
              <input
                ref="updateUserImage"
                type="file"
                class="form-control"
                id="updateUserImage"
                accept="image/*"
              />
            </div>

            <div class="col-12">
              <label for="location"> Location </label>
              <input
                type="text"
                class="form-control"
                id="location"
                v-model="details.city"
                placeholder="Location"
              />
            </div>

            <div class="col-12">
              <label for="update-testimonial"> Testimonial</label>
              <textarea
                type="text"
                class="form-control"
                id="update-testimonial"
                v-model="details.testimonial"
              ></textarea>
            </div>
          </div>
          <div slot="modal-buttons">
            <button type="submit" class="btn btn-primary btn-long">
              <span class="icon">
                <span
                  data-feather="plus-circle"
                  class="rui-icon rui-icon-stroke-1_5"
                ></span>
              </span>
              <span class="text">Update</span>
            </button>
          </div>
        </modal>
      </form>
    </template>
  </layout>
</template>

<script>
  import { mixins, errorHandlers } from "@dashboard-assets/js/config";
  import Layout from "@superadmin-assets/js/SuperAdminAppComponent.vue";
  export default {
    name: "ManageTestimonialPlans",
    mixins: [mixins, errorHandlers],
    props: {
      testimonials: Array,
    },
    components: {
      Layout,
    },
    data: () => {
      return {
        details: {},
      };
    },
    methods: {
      createTestimonial() {
        BlockToast.fire({
          text: "Creating testimonial portfolio ...",
        });

        this.details.img = this.$refs.userImage.files[0];

          let formData = new FormData();

        _.forEach(this.details, (val, key) => {
          formData.append(key, val);
        });

        this.$inertia
          .post(
            this.$route("superadmin.testimonial.create"),
            formData,
            {
              preserveState: true,
              preserveScroll: true,
              only: ["testimonials", "errors", "flash"],
            }
          )
          .then(() => {
            this.displayResponse();
            this.displayErrors(10000);
          }).then(() => {
            if (this.$page.flash.success) {
              this.details = {}
            }
          });
      },

      updateTestimonial() {
        BlockToast.fire({
          text: "Creating testimonial portfolio ...",
        });

         this.details.img = this.$refs.updateUserImage.files[0];
         this.details._method = 'PUT';

          let formData = new FormData();

        _.forEach(this.details, (val, key) => {
          formData.append(key, val);
        });


        this.$inertia
          .post(this.$route("superadmin.testimonial.update", this.details.id), formData, {
            preserveState: true,
            preserveScroll: true,
            only: ["testimonials", "errors", "flash"],
          })
          .then(() => {
            this.displayResponse(10000);
            this.displayErrors(10000);
          }).then(() => {
            if (this.$page.flash.success) {
              this.details = {}
            }
          })
          jQuery('#updateTestimonialModal').modal('hide');
      },

      deleteTestimonial(id) {
        BlockToast.fire({
          text: "Deleting testimonial...",
        });

        this.$inertia
          .delete(this.$route("superadmin.testimonial.delete", id), {
            preserveState: true,
            preserveScroll: true,
            only: ["testimonials", "errors", "flash"],
          })
          .then(() => {
            this.displayResponse(10000);
            this.displayErrors(10000);
          });
      },
    },
  };
</script>

<style lang="scss" scoped>
  .card {
    &.rounded {
      border-radius: 5px;
    }
  }
</style>
