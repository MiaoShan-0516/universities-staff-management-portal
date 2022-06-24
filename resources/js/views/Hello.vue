<template>
  <p>Hello World!</p>
</template>
<script>
  export default {
    data() {
      return {
      };
    },
    created() {
    if (!this.$session.exists()) {
      this.$alert("Please login to proceed").then(() => {
        this.$router.push({ name: "login" });
      });
    }
  },
    mounted() {
      this.$session.get("user_data")[0].id
    },
    methods: {
    },
  };
</script>