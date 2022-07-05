<template>
  <div>
    <div id="navbar" class="d-flex align-items-center fixed-top">
      <div class="container">
        <div class="row justify-content-between justify-content-lg-center align-items-center">
          <div 
            class="col-2 d-block d-lg-none"
            @click="active"
          >
            <div class="row align-items-center">
              <div class="col-12 h4">
                <i class="fa fa-bars"></i>
              </div>
            </div>
          </div>
          <div class="col-5 col-lg-4 d-flex align-items-center">
            <div class="logo">
              <router-link :to="{ name: 'home' }">
                <img src="/img/logo.png" alt="logo" class="img-fluid">
              </router-link>
            </div>
          </div>
          <div class="col-5 col-lg-4 d-flex align-items-center justify-content-center">
            <div class="time">
              {{ dateTime.hours > 12 ? dateTime.hours-12 : dateTime.hours }}:{{ dateTime.minutes }}:{{ dateTime.seconds }}
              <span>{{ dateTime.hours > 12 ? 'PM' : 'AM' }}</span>
            </div>
          </div>
          <div
            class="
              d-none d-lg-flex
              col-4 col-sm-2
              dropdown
              justify-content-end
              text-center
              shadow-none
              user-dropdown
            "
            v-bind:class="{ touch: isDrop }"
          >
            <div
              class="col-12 col-sm-12 pr-0"
            >
              <div
                class="user-dropdown"
                type=""
                id="droptrigger"
                v-on:click="dropTrigger"
              >
                <div>
                  Dashboard
                  <i class="fa fa-user mx-1"></i>
                  <i class="fa fa-caret-down"></i>
                </div>
              </div>
            </div>
            <div class="dropcontent" v-bind:class="{ open: isDrop }">
              <div>
                <div class="row px-3 py-2">
                  <div class="col-12 px-0 pb-0 d-flex align-items-center">
                    <router-link
                      :to="{ name: 'home' }"
                      class="dropdown-item border-bottom py-2"
                    >
                      Home
                    </router-link>
                  </div>
                  <div class="col-12">
                    <button @click="logout" class="btn btn-dark btn-block m-0">
                      Logout
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <nav id="sidebar" v-bind:class="{ active: isActive }">
      <div class="sidebar-header">
        <div class="container">
          <div class="row">
            <div class="col-8 px-0 font-weight-less-bold">
              <div class="col-12 p-0">
                <router-link :to="{ name: 'home' }">
                  <dd
                    :class="{ 'menu-item-active': subIsActive('/home') }"
                    class="m-0 p-3"
                  >
                    Home
                  </dd>
                </router-link>
                <button @click="logout" class="btn btn-dark btn-block m-0">
                  Logout
                </button>
              </div>
            </div>
            <div class="col-4 text-right p-0">
              <button
                type="button"
                @click="active"
                id="sidebarCollapseX"
                class="btn btn-close"
              >
              </button>
            </div>
          </div>
        </div>
      </div>
    </nav>
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
        isActive: false,
        isVisible: false,
        isDrop: false,
      };
    },
    created() {
    },
    beforeMount() {
      this.timer = setInterval(this.setDateTime, 1000);
    },
    mounted() {
      document.addEventListener("click", this.close);
      document.addEventListener("click", this.hide);
    },
    beforeUnmount() {
      clearInterval(this.timer);
      document.removeEventListener("click", this.close);
      document.removeEventListener("click", this.hide);
    },
    methods: {
      logout() {
        this.isActive = false;
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
      active(e) {
        this.isActive = !this.isActive;
        this.isVisible = !this.isVisible;
      },
      hide(e) {
        if (!this.$el.contains(e.target)) {
          this.isActive = false;
          this.isVisible = false;
        }
      },
      dropTrigger(e) {
        this.isDrop = !this.isDrop;
      },
      close(e) {
        if (!this.$el.contains(e.target)) {
          this.isDrop = false;
        }
      },
      subIsActive(input) {
        const paths = Array.isArray(input) ? input : [input];
        return paths.some((path) => {
          return this.$route.path.indexOf(path) === 0; // current path starts with this path string
        });
      },
    },
  };
</script>