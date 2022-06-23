<template>
  <div>
    <nav-bar></nav-bar>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
          <div class="card shadow">
            <div class="p-5">
            <div class="col-2 mx-auto mb-3">
              <img src="https://www.arealme.com/logo.png" alt="Logo" class="img-fluid">
            </div>
            <div class="my-3">
              <div class="text-center">
                <h1 class="my-3">Login in to portal</h1>
              </div>
                <div class="row">
                  <div class="col-12 col-md-6 d-flex justify-content-center">
                    <button
                      @click="AuthProvider('google')"
                      class="
                        row
                        btn btn-danger
                        text-white
                        p-3
                        w-100
                        d-flex
                        align-items-center
                        justify-content-center
                      "
                    >
                      <span class="text-white col-1 ">
                        <i class="fa fa-google" aria-hidden="true"></i>
                      </span>
                      <span class="col-10">Sign in with Google</span>
                    </button>
                  </div>
                  <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <button
                      @click.prevent="AuthProvider('facebook')"
                      class="
                        row
                        btn btn-primary
                        p-3
                        w-100
                        d-flex
                        align-items-center
                        justify-content-center
                      "
                    >
                      <span class="col-1 text-white">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                      </span>
                      <span class="col-10">Sign in with Facebook</span>
                    </button>
                  </div>
                </div>
                <span class="row my-3 text-center justify-content-center font-weight-bold">
                  OR
                  </span>
                <div>
                  <div class="my-3">
                    <label for="email">Email Address</label>
                    <input
                      type="email"
                      name="email"
                      @blur="handleBlur"
                      class="form-control form-control-lg text-lowercase"
                      placeholder="example@email.com"
                      v-model="email"
                    />
                    <small v-if="email != '' && !emailValidation(email)"
                      >Please enter valid email address</small
                    >
                  </div>
                  <div class="my-3">
                    <label for="password">Password</label>
                    <div class="d-flex align-items-center">
                      <input
                      name="password"
                      v-bind:type="[showPassword ? 'text' : 'password']"
                      class="form-control form-control-lg"
                      autocomplete="off"
                      placeholder=""
                      v-model="password"
                    />
                      <div class="form-control form-control-lg col cursor-pointer" @click="displayPassword()">
                        <i class="fa" :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-3 m-auto">
                    <button class="btn btn-primary w-100" @click="logIn()">
                      Login
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import App from "./App.vue";

  export default {
    components: {
    "nav-bar": App,
  },
    data() {
      return {
        email: "",
        password: "",
        userData: {
          id: "",
          email: "",
        },
        showPassword: false,
      }
    },
    methods: {
      emailValidation: function (email) {
        const re =
          /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      },
      handleBlur(e) {
        this.emailValidation(this.email);
      },
      displayPassword(){
        this.showPassword = !this.showPassword;
      },
      logIn() {
      axios.defaults.baseURL = "/api";
      axios
        .post("/loginValidation", {
        email: this.email.toLowerCase(),
        password: this.password,
        })
        .then((response) => {
          this.userData = response.arr_user;
          let self = this;
          self.$session.start();
          self.$session.set("userData", this.userData);
          self.$router.push({ path: "/" });
        })
        .catch((error) => {
          console.log(error);
          this.$alert(
            "Your email or password is wrong.",
            "Error",
            "error"
          );
        });
      },
    }
  }
</script>
