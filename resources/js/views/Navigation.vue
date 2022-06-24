<template>
  <div>
    <h1>Universities Staff Management Portal</h1>
    <p>
      <router-link :to="{ name: 'home' }">Home</router-link> |
      <router-link :to="{ name: 'login' }">Login</router-link>
      <router-link :to="{ name: 'hello' }">Hello World</router-link>
    </p>
    <button @click="logout">Logout</button>
    <div class="container">
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
      userData: {
        id: "",
        email: "",
      },
      };
    },
    created() {
    },

    methods: {
      logout() {
        this.$confirm("Are you confirm to logout?").then(() => {
          this.$session.destroy();
          location.reload();
        });
      },
    },
  };
</script>