<template>
  <span v-if="rating && rating != 0">
    <i
      v-for="index in [1, 2, 3, 4, 5]"
      :key="index"
      class="star gold-color"
      :class="rating >= index ? 'fas fa-star' : 'far fa-star' "
    ></i>
  </span>
</template>
<script>
export default {
  name: "Rating",
  props: ["rating"]
};
</script>
<style scoped>
@import "https://use.fontawesome.com/releases/v5.8.1/css/all.css";
.gold-color {
  color: gold;
}
</style>
