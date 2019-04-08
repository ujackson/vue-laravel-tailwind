<template>
  <div>
    <div class="container mx-auto px-20">
      <loader v-if="loader"></loader>
      <div class="flex px-10">
        <div class="w-1/4">
          <div class="mb-4">
            <img class="rounded-lg" :src="profile.avatar">
          </div>
          <div class="mb-4">
            <div class="text-2xl font-medium text-gray-800">{{profile.name}}</div>
            <div class="text-xl text-gray-600 font-light capitalize">Role: {{profile.role}}</div>
          </div>
          <div class="flex items-center text-left py-4 mb-4 border-b">
            <div class="flex items-center mr-2">
              <svg
                class="fill-current text-gray-600 w-4 h-4"
                width="24"
                height="24"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
              >
                <path
                  d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"
                ></path>
              </svg>
            </div>
            <div>
              <a href="#" class="no-underline text-sm">{{profile.email}}</a>
            </div>
          </div>
          <div class>
            <div class="font-medium text-gray-800">Ratings</div>
            <div class="flex items-center mt-2">
              <rating :rating="profile.rating"></rating>
            </div>
          </div>
        </div>
        <div class="w-3/4 ml-6 mt-2">
          <div class="flex items-center font-bold text-gray-600 text-sm border-b">
            <div
              class="p-4 border-b-2 font-normal text-gray-800 border-blue-500 text-3xl -mb-2px"
            >Edit Profile</div>
          </div>
          <form @submit.prevent="updateProfile" enctype="multipart/form-data">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
              <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="name"
                  >Name</label>
                  <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3"
                    id="name"
                    type="text"
                    v-model="profile.name"
                    :class="{ ' border-red-500': errors['name'] }"
                    name="name"
                    placeholder="Jane"
                  >
                  <span v-if="errors['name']" class="text-red-500 text-xs italic">
                    <strong>{{ errors['name'][0] }}</strong>
                  </span>
                </div>
                <div class="md:w-1/2 px-3">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="email"
                  >E-Mail Address</label>
                  <input
                    v-model="profile.email"
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4"
                    id="email"
                    :class="{ ' border-red-500': errors['email'] }"
                    type="email"
                    name="email"
                    placeholder="Doe"
                  >
                  <span v-if="errors['email']" class="text-red-500 text-xs italic">
                    <strong>{{ errors['email'][0] }}</strong>
                  </span>
                </div>
              </div>
              <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="password"
                  >Password</label>
                  <input
                    v-model="password"
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3"
                    id="password"
                    type="password"
                    placeholder="******************"
                    :class="{ ' border-red-500': errors['password'] }"
                    name="password"
                  >
                  <span v-if="errors['password']" class="text-red-500 text-xs italic">
                    <strong>{{ errors['password'][0] }}</strong>
                  </span>
                </div>
                <div class="md:w-1/2 px-3">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="avatar"
                  >Avatar</label>
                  <input
                    @change="onFileChange"
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4"
                    id="avatar"
                    type="file"
                    :class="{ ' border-red-500': errors['avatar'] }"
                    name="avatar"
                  >
                  <span v-if="errors['avatar']" class="text-red-500 text-xs italic">
                    <strong>{{ errors['avatar'][0] }}</strong>
                  </span>
                </div>
              </div>
              <div class="-mx-3 md:flex mb-2">
                <div class="md:w-full px-3 mb-6 md:mb-0">
                  <button
                    class="py-2 px-4 shadow-md no-underline rounded-full bg-blue-500 text-white font-sans font-semibold border-blue-500 hover:text-white hover:bg-blue-400 focus:outline-none active:shadow-none mr-2"
                  >Save Changes</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loader: true,
      profile: [],
      password: "",
      avatar: "",
      errors: []
    };
  },

  mounted() {
    this.getUserDetails();
  },
  methods: {
    getUserDetails() {
      axios
        .get("/api/user")
        .then(response => {
          this.profile = response.data.data;
          this.loader = false;
        })
        .catch(error => {
          this.loader = false;
        });
    },
    onFileChange(e) {
      this.avatar = e.target.files[0];
    },
    updateProfile() {
      this.loader = true;
      this.errors = [];

      let formData = new FormData();
      formData.append("name", this.profile.name);
      formData.append("email", this.profile.email);
      formData.append("password", this.password);
      formData.append("avatar", this.avatar);

      axios
        .post("/api/user", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log(response.data);
          this.flash("Profile updated successfully.", "success");
          //localStorage.removeItem('user')
          window.localStorage.setItem(
            "user",
            JSON.stringify(response.data.user)
          );
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

