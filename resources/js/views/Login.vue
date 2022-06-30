<template>
  <div>
    <section id="login">
      <div class="container-fluid p-0">
        <div class="row">
          <img src="/img/login_bg.jfif" class="img-fluid d-none d-lg-block col-md-6 p-0" alt="login_bg">
          <div class="col-12 col-md-6 m-auto text-center px-0">
            <img src="/img/logo.png" class="img-fluid" alt="logo">
            <h1 class="my-4">Welcome</h1>
            <button class="btn-google" @click="AuthProvider('google')">
              <span class="mr-2">
                <i class="fa fa-google" aria-hidden="true"></i>
              </span>
              <span>Sign in with Google</span>
            </button>
            <h2 class="mt-4">OR</h2>
            <div class="col-10 col-md-6 m-auto">
              <div class="my-3">
                <div class="d-flex align-items-center">
                  <div class="form-control form-control-md col">
                    <i class="fa fa-envelope"></i>
                  </div>
                  <input
                    type="email"
                    name="email"
                    @blur="handleBlur"
                    class="form-control form-control-lg text-lowercase"
                    placeholder="Email Address"
                    v-model="email"
                  />
                </div>
                <small class="text-danger" v-if="email != '' && !emailValidation(email)">
                  Please enter valid email address (format: example@email.com)
                </small>
              </div>
              <div class="my-3">
                <div class="d-flex align-items-center">
                  <div class="form-control form-control-md col">
                    <i class="fa fa-lock mr-1"></i>
                  </div>
                  <input
                    name="password"
                    v-bind:type="[showPassword ? 'text' : 'password']"
                    class="form-control form-control-lg"
                    autocomplete="off"
                    placeholder="Password"
                    v-model="password"
                  />
                  <div class="form-control form-control-md col cursor-pointer" @click="displayPassword()">
                    <i class="fa" :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></i>
                  </div>
                </div>
              </div>
              <div>
                <button class="btn btn-login" @click="logIn()">
                  Login
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    components: {
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
      AuthProvider(provider) {
        this.$auth.authenticate(provider).then(response =>{
          this.SocialLogin(provider,response)
          }).catch(err => {
              console.log({err:err})
          })
      },
      SocialLogin(provider,response) {
        axios.defaults.baseURL = "/api";
          axios
            .post("/sociallogin/" + provider, response)
            .then((response) => {
              console.log(response.data)
              this.userData = response.arr_user;
              let self = this;
              self.$session.start();
              self.$session.set("userData", this.userData);
              self.$router.push({ path: "/" });
          }).catch(err => {
              console.log({err:err})
          })
      },
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
