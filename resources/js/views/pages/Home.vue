<template>
  <div class="flex items-center">
    <div class="w-full sm:w-full md:w-3/4 lg:w-3/4 xl:w-3/4 md:mx-auto">
      <div
        class="text-sm border border-t-8 rounded text-green-800 border-green-700 bg-green-100 px-3 py-4 mb-4"
        role="alert"
      >Welcome Back {{user.name}}!</div>

      <div class="mb-2 border-solid border-gray-400rounded border shadow-sm">
        <div class="bg-gray-200 px-2 py-3 border-solid border-grey-400 border-b">
          Dashboard - All Users
          <span
            class="rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold"
          >{{pagination.total}}</span>
        </div>
        <div class="p-3">
          <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <table class="text-left w-full border-collapse">
              <thead>
                <tr>
                  <th
                    class="py-4 px-6 bg-gray-100 font-bold uppercase text-sm text-gray-600 border-b border-gray-400"
                  >Avatar</th>
                  <th
                    class="py-4 px-6 bg-gray-100 font-bold uppercase text-sm text-gray-600 border-b border-gray-400"
                  >Role</th>
                  <th
                    class="py-4 px-6 bg-gray-100 font-bold uppercase text-sm text-gray-600 border-b border-gray-400"
                  >Name</th>
                  <th
                    class="py-4 px-6 bg-gray-100 font-bold uppercase text-sm text-gray-600 border-b border-gray-400"
                  >Email</th>
                  <th
                    class="py-4 px-6 bg-gray-100 font-bold uppercase text-sm text-gray-600 border-b border-gray-400"
                  >Created</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="index" class="hover:bg-gray-200">
                  <td class="py-4 px-6 border-b border-gray-400">
                    <img class="h-10 w-10 rounded-full" :src="user.avatar">
                  </td>
                  <td class="py-4 px-6 border-b border-gray-400">{{user.role}}</td>
                  <td class="py-4 px-6 border-b border-gray-400">{{user.name}}k</td>
                  <td class="py-4 px-6 border-b border-gray-400">{{user.email}}</td>
                  <td class="py-4 px-6 border-b border-gray-400">{{user.createdOn}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="w-full p-2">
            <paginator :pagination="pagination" @paginate="getUsers"></paginator>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Home",
  data() {
    return {
      users: [],
      pagination: [],
      loader: true
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers(page) {
      page = page || "/api/users";
      axios
        .get(page)
        .then(response => {
          this.users = response.data.data;
          this.pagination = response.data.meta;
          this.loader = false;
        })
        .catch(error => {
          this.flash(
            "Unexpected error occurred while trying to process your request!",
            "error"
          );
          this.loader = false;
        });
    }
  }
};
</script>
