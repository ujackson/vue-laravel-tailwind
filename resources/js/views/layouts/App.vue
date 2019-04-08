<template>
  <div>
    <nav class="bg-blue-900 shadow mb-8 py-6">
      <div class="container mx-auto px-6 md:px-0">
        <div class="flex items-center justify-center">
          <div class="flex items-center flex-no-shrink mr-6">
            <router-link to="/">
              <svg
                class="h-8 w-8 mr-2 bg-red-700"
                width="54"
                height="54"
                viewBox="0 0 54 54"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"
                ></path>
              </svg>
            </router-link>
            <router-link to="/">
              <span class="font-semibold text-xl tracking-tighter text-white">{{AppName}}</span>
            </router-link>
          </div>
          <div class="block md:hidden lg:hidden xl:hidden">
            <button
              class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white"
            >
              <svg class="h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
              </svg>
            </button>
          </div>

          <div v-if="!AuthCheck" class="flex-1 text-right">
            <router-link
              to="/login"
              class="no-underline hover:underline text-gray-100 text-sm p-3"
            >Login</router-link>
            <router-link
              to="/register"
              class="inline-block text-sm px-4 py-2 leading-none shadow rounded text-white bg-red-700 hover:border-transparent hover:text-teal-600 hover:bg-white mt-4 lg:mt-0"
            >Register</router-link>
          </div>

          <div v-if="AuthCheck" class="flex-1">
            <div class="float-right hidden md:block lg:block xl:block">
              <div class="relative group">
                <div
                  class="flex items-center cursor-pointer text-white group-hover:border-gray-200 rounded-t-lg py-1 px-2"
                >
                  <img :src="user.avatar" class="h-8 w-8 rounded-full mr-2">
                  {{user.name}}
                  <svg
                    class="fill-current h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                    ></path>
                  </svg>
                </div>
                <div
                  class="items-center absolute border border-t-0 rounded-b-lg p-1 bg-white p-2 invisible group-hover:visible w-full"
                >
                  <router-link
                    to="/home"
                    class="px-4 py-2 block text-black hover:bg-gray-200"
                  >Dashboard</router-link>
                  <router-link to="/profile" class="px-4 py-2 block text-black hover:bg-gray-200">My Profile</router-link>
                  <hr class="border-t mx-2 border-gray-400">
                  <router-link
                    class="px-4 py-2 block text-black hover:bg-gray-200"
                    to="/logout"
                  >Logout</router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="min-h-screen flex flex-col">
      <div class="flex-grow">
        <transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </div>
      <footer
        class="w-full text-center border-t border-gray-400 p-4 bottom-0 text-gray-700"
      >Copyright &copy; {{currentYear}} {{AppName}}</footer>
    </div>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      currentYear: ""
    };
  },

  mounted() {
    this.currentYear = new Date().getFullYear();
  }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
