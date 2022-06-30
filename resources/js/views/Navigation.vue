<template>
  <div>
    <h1>Universities Staff Management Portal</h1>
    <p>
      <router-link :to="{ name: 'home' }">Home</router-link> |
      <router-link :to="{ name: 'login' }">Login</router-link>
    </p>
    <div>{{ dateTime.hours }}:{{ dateTime.minutes }}:{{ dateTime.seconds }}</div>

    <button @click="logout">Logout</button>
    <div class="container">
    </div>
  </div>
</template>
<script>
const date = new Date();
  export default {
    data() {
      return {
        userData: {
          id: "",
          email: "",
        },
        dateTime: {
          hours: date.getHours(),
          minutes: date.getMinutes(),
          seconds: date.getSeconds(),
        },
        timer: undefined,
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
      setDateTime() {
      const date = new Date();
      this.dateTime = {
        hours: date.getHours(),
        minutes: date.getMinutes(),
        seconds: date.getSeconds(),
      };
    },
    },
    beforeMount() {
    this.timer = setInterval(this.setDateTime, 1000);
  },
  beforeUnmount() {
    clearInterval(this.timer);
  },
  };
</script>