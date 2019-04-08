<template>
  <div class="container mx-auto">
    <loader v-if="loader"></loader>
    <div class="flex flex-wrap justify-center">
      <div class="w-full max-w-sm">
        <div
          v-if="status"
          class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4"
          role="alert"
        >{{ status }}</div>

        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
          <div
            class="font-semibold bg-gray-100 text-gray-600 py-3 px-6 mb-0 shadow-inner"
          >Reset Password</div>

          <form @submit.prevent="postForm" class="w-full p-6">
            <div class="flex flex-wrap mb-6">
              <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-Mail Address:</label>

              <input
                v-model="email"
                id="email"
                type="email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                :class="{ ' border-red-500': errors['email'] }"
                name="email"
              >
              <span v-if="errors['email']" class="text-red-500 text-xs italic">
                <strong>{{ errors['email'][0] }}</strong>
              </span>
            </div>

            <div class="flex flex-wrap">
              <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              >Send Password Reset Link</button>

              <p class="w-full text-xs text-center text-gray-600 mt-8 -mb-4">
                <router-link
                  to="/login"
                  class="text-blue-500 hover:text-blue-600 no-underline"
                >Back to login</router-link>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ResetPassword",
  data() {
    return {
      errors: [],
      email: "",
      loader: false,
      status: ""
    };
  },
  methods: {
    postForm() {
      this.loader = true;
      this.errors = [];
      this.status = "";
      axios
        .post("/api/password/email", {'email': this.email})
        .then(result => {
          this.status = result.data.status;
          this.loader = false;
          this.flash(result.data.status, "success");
        })
        .catch(err => {
          if (err.response.status === 422) {
            this.flash("Please check the form for errors.", "error");
            this.errors = err.response.data.errors;
          } else {
            this.flash(
              "Unexpected error occurred while trying to process your request!",
              "error"
            );
          }
          this.loader = false;
        });
    }
  }
};
</script>

<style>
</style>
