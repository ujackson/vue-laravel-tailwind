<template>
  <div class="container mx-auto">
    <div class="flex flex-wrap justify-center">
      <div class="w-full max-w-sm">
        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
          <div class="font-semibold bg-gray-100 text-gray-800 py-3 px-6 mb-0 shadow-inner">Register</div>

          <form @submit.prevent="saveForm" class="w-full p-6">
            <div class="flex flex-wrap mb-6">
              <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>

              <input
                v-model="formData.name"
                id="name"
                type="text"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                :class="{ ' border-red-500': errors['name'] }"
                name="name"
                autofocus
              >
              <span v-if="errors['name']" class="text-red-500 text-xs italic">
                <strong>{{ errors['name'][0] }}</strong>
              </span>
            </div>

            <div class="flex flex-wrap mb-6">
              <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-Mail Address:</label>

              <input
                v-model="formData.email"
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

            <div class="flex flex-wrap mb-6">
              <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>

              <input
                v-model="formData.password"
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
                v-model="formData.password_confirmation"
                id="password-confirm"
                type="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="password_confirmation"
              >
            </div>

            <div class="flex flex-wrap">
              <button
                type="submit"
                class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap py-2 px-4 rounded text-base leading-normal no-underline text-blue-100 bg-blue-500 hover:bg-blue-400"
              >Register</button>

              <p class="w-full text-xs text-center text-gray-600 mt-8 -mb-4">
                Already have an account?
                <router-link
                  to="/login"
                  class="text-blue-500 hover:text-blue-700 no-underline"
                >Login</router-link>
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
  name: "Register",
  data() {
    return {
      errors: [],
      formData: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
      },
      loader: false,
      plan: [],
      successMsg: ""
    };
  },
  mounted() {},
  methods: {
    saveForm() {
      this.loader = true;
      this.errors = [];
      axios
        .post("/api/register", this.formData)
        .then(response => {
          this.loader = false;
          this.$router.push({
            name: "verify",
            params: { uuid: response.data.user.uuid }
          });
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
