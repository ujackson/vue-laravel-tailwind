<template>
  <div id="content" v-bind:style="contentStyle">
    <div class="wrapper">
      <h1 v-if="one" v-bind:class="faded">{{timeOne}}</h1>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  name: "Clock",
  data() {
    return {
      contentStyle: {
        backgroundColor: "#000000".replace(/0/g, function() {
          return (Math.random() * 16).toString(16);
        })
      },
      timeOne: moment().format("LTS"),
      timeTwo: moment().format("l"),
      timeThree: moment().format("MMMM Do YY"),
      timeFour: moment().format("LT"),
      one: true,
      two: false,
      three: false,
      four: false,
      faded: ""
    };
  },
  methods: {},
  mounted: function() {
    setInterval(() => {
      this.timeOne = moment().format("LTS");
    }, 1000);
  }
};
</script>

<style scoped>
#content {
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  left: 0;
  top: 0;
  color: #ccc;
  transition: 0.5s;
  text-align: center;
  z-index: -99;
}
#content .wrapper {
  margin-bottom: 50px;
}
#content h1 {
  transition: 0.2s;
  font-size: 5.5em;
  margin: 0;
}
#content p {
  transition: 0.2s;
}
.faded {
  opacity: 0;
  transition: 0.2s;
}
</style>
