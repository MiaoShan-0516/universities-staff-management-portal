<template>
  <div data-app>
    <nav-bar></nav-bar>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
          <v-card>
            <v-card-title>
              Home
              <v-spacer></v-spacer>
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
            <v-app id="inspire">
            <v-data-table
              :headers="headers"
              :items="uni"
              :search="search"
              :items-per-page="25"
              class="elevation-1"
            >
              <template v-slot:item="{ item }">
                <tr>
                  <td>{{item.name}}</td>
                  <td>
                    <a :href="'https://' + item.domains[0]" target="_blank">
                      {{ 'https://' + item.domains[0] }}
                    </a>
                  </td>
                </tr>
              </template>
            </v-data-table>
  </v-app>
          </v-card>
          <table class="table table-hover">
            <thead>
              <tr>
                <th></th>
                <th>Name of University</th>
                <th>URL</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(university, index) in universities" :key="index">
                <th scope="row">{{ index + 1 }}</th>
                <td>{{ university.name }}</td>
                <td>
                  <a :href="'https://' + university.domains[0]" target="_blank">
                    {{ 'https://' + university.domains[0] }}
                  </a>
                </td>
              </tr>
              <tr>
              <th scope="row" colspan="3">1</th>
              
            </tr>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import Navigation from "./Navigation.vue";

  export default {
    components: {
    "nav-bar": Navigation,
  },
    data() {
      return {
        universities: null,
        uni: [],
        search: '',
        headers: [
          {
            text: '	Name of University',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          { text: 'URL', value: 'url' },
        ],
      }
      
    },
    mounted () {
      axios
        .get('http://universities.hipolabs.com/search?country=Malaysia')
        .then(response => {
          this.universities = response.data
          this.uni = response.data
        })
        .catch((error) => {
          alert(error);
        });
    },
    created() {
      if (!this.$session.exists()) {
        this.$alert("Please login to proceed").then(() => {
          this.$router.push({ name: "login" });
        });
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
