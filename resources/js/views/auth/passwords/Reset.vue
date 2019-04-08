<template>
  <div class="container mx-auto">
    <loader v-if="loader"></loader>
    <div class="flex flex-wrap justify-center">
      <div class="w-full max-w-sm">
        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
          <div
            class="font-semibold bg-gray-100 text-gray-800 py-3 px-6 mb-0 shadow-inner"
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
                autofocus
              >
              <span v-if="errors['email']" class="text-red-500 text-xs italic">
                <strong>{{ errors['email'][0] }}</strong>
              </span>
            </div>

            <div class="flex flex-wrap mb-6">
              <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>

              <input
                v-model="password"
                id="password"
                type="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                :class="{ ' border-red-500': errors['password'] }"
                name="password"
              >
              <span v-if="errors['password']" class="text-red-500 text-xs italic">
                <strong>{{ errors['password'][0] }}</strong>
              </span>
            </div>

            <div class="flex flex-wrap mb-6">
              <label
                for="password-confirm"
                class="block text-gray-700 text-sm font-bold mb-2"
              >Confirm Password:</label>

              <input
                v-model="password_confirmation"
                id="password-confirm"
                type="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="password_confirmation"
              >
            </div>

            <div class="flex flex-wrap">
              <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-dark-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              >Reset Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PasswordResetForm",
  data() {
    return {
      email: "",
      password: "",
      token: "",
      password_confirmation: "",
      loader: false,
      errors: []
    };
  },

  created() {
    this.token = this.$route.params.token;
  },

  methods: {
    postForm() {
      this.loader = true;
      this.errors = [];
      axios
        .post("/api/password/reset", {
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          token: this.token
        })
        .then(response => {
          this.loader = false;
          location.assign('/login');
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
