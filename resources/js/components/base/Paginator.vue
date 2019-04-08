<template>
  <ul v-if="pagination.total > pagination.per_page" class="flex rounded w-auto font-sans mt-4">
    <li v-if="pagination.current_page > 1">
      <a
        class="block no-underline hover:text-white hover:bg-blue-500 text-blue-500 border-r border-gray-400 px-3 py-2"
        href="javascript:void(0)"
        aria-label="Previous"
        v-on:click.prevent="changePage(pagination.current_page - 1)"
      >
        <!-- <span aria-hidden="true">«</span> -->
        Previous
      </a>
    </li>
    <li :key="index" v-for="(page, index) in pagesNumber">
      <a
        class="block no-underline hover:text-white hover:bg-blue-500 border-r border-gray-400 px-3 py-2"
        :class="{'text-white bg-blue-500 border-blue-500': page == pagination.current_page}"
        href="javascript:void(0)"
        v-on:click.prevent="changePage(page)"
      >{{ page }}</a>
    </li>
    <li v-if="pagination.current_page < pagination.last_page">
      <a
        class="block no-underline hover:text-white hover:bg-blue-500 text-blue-500 px-3 py-2"
        href="javascript:void(0)"
        aria-label="Next"
        v-on:click.prevent="changePage(pagination.current_page + 1)"
      >
        <!-- <span aria-hidden="true">»</span> -->
        Next
      </a>
    </li>
  </ul>
</template>
<script>
export default {
  props: {
    pagination: {
      type: Object,
      required: true
    },
    offset: {
      type: Number,
      default: 10
    }
  },
  computed: {
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }
      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      let to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      let pagesArray = [];
      for (let page = from; page <= to; page++) {
        pagesArray.push(page);
      }
      return pagesArray;
    }
  },
  methods: {
    changePage(page) {
      let pageUrl = this.pagination.path + "?page=" + page;
      this.$emit("paginate", pageUrl);
    }
  }
};
</script>
