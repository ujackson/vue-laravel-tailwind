<template>
  <div class="container mx-auto">
    <loader v-if="loader"></loader>
    <div class="flex flex-wrap justify-center">
      <div class="w-full max-w-sm">
        <div
          v-if="resent"
          class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4"
          role="alert"
        >A fresh verification link has been sent to your email address.</div>

        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
          <div
            class="font-semibold bg-gray-100 text-gray-800 py-3 px-6 mb-0 shadow-inner"
          >Verify Your Email Address</div>

          <div class="w-full flex flex-wrap p-6">
            <p
              class="leading-normal mb-6"
            >Before proceeding, please check your email for a verification link.</p>

            <a
              @click="verificationResend"
              class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline no-underline ml-auto"
              href="javascript:void(0)"
            >Resend verification email</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "VerifyEmail",
  data() {
    return {
      resent: false,
      loader: false
    };
  },
  mounted() {},
  methods: {
    verificationResend() {
      this.resent = false;
      this.loader = true;
      axios
        .get("/api/email/resend/" + this.$route.params.uuid)
        .then(result => {
          this.flash(result.data, "success");
          this.resent = true;
          this.loader = false;
        })
        .catch(err => {
          if (err.response.status === 400) {
            this.flash(err.response.data, "error");
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
