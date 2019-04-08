<template>
  <div class="container mx-auto">
    <loader v-if="loader"></loader>
    <div class="flex flex-wrap justify-center">
      <div class="w-full max-w-sm">
        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
          <div class="font-semibold bg-gray-100 text-gray-900 py-3 px-6 mb-0 shadow-inner">Login</div>

          <form @submit.prevent="postLogin" class="w-full p-6">
            <div class="flex flex-wrap mb-6">
              <label for="email" class="block text-gray-800 text-sm font-bold mb-2">E-Mail Address:</label>

              <input
                v-model="formData.email"
                type="email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                autofocus
                :class="{ ' border-red-500': errors['email'] }"
                name="email"
                id="email"
                placeholder
              >
              <span v-if="errors['email']" class="text-red-500 text-xs italic">
                <strong>{{ errors['email'][0] }}</strong>
              </span>
            </div>

            <div class="flex flex-wrap mb-6">
              <label for="password" class="block text-gray-800 text-sm font-bold mb-2">Password:</label>

              <input
                v-model="formData.password"
                type="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                :class="{ ' border-red-500': errors['password'] }"
                name="password"
                id="password"
                placeholder
              >
              <span v-if="errors['password']" class="text-red-500 text-xs italic">
                <strong>{{ errors['password'][0] }}</strong>
              </span>
            </div>

            <div class="flex mb-6">
              <input v-model="formData.remember" type="checkbox" name="remember" id="remember">
              <label class="text-sm text-gray-700 ml-3" for="remember">Remember Me</label>
            </div>

            <div class="flex flex-wrap items-center">
              <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              >Login</button>
              <router-link
                class="text-sm text-blue-500 hover:text-blue-700 whitespace-no-wrap no-underline ml-auto"
                to="/password/forgot"
              >Forgot Your Password?</router-link>

              <p class="w-full text-xs text-center text-gray-700 mt-8 -mb-4">
                Don't have an account?
                <router-link
                  to="/register"
                  class="text-blue-500 hover:text-blue-700 no-underline"
                >Register</router-link>
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
  name: "Login",
  data() {
    return {
      errors: [],
      formData: {
        email: "",
        password: "",
        remember: ""
      },
      loader: false
    };
  },
  mounted() {},
  methods: {
    postLogin() {
      this.loader = true;
      this.errors = [];
      axios
        .post("/api/login", this.formData)
        .then(response => {
          console.log(response.data);
          if (response.data.verified === false) {
            this.flash("Email pending verification!", "error");
            this.$router.push({
              name: "verify",
              params: { uuid: response.data.user.uuid }
            });
          } else {
            window.localStorage.setItem("access-token", response.data.token);
            window.localStorage.setItem(
              "user",
              JSON.stringify(response.data.user)
            );
            window.location.assign(response.data.redirectTo);
          }
          this.loader = false;
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
