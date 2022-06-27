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
                    <td>{{ item.id }}</td>
                    <td>
                      <router-link :to="{ path: '/profile/' + item.name.replace(/\s+/g, '-') + '/id=' + item.id }">
                        {{ item.name }}
                      </router-link>
                    </td>
                    <td>
                      <a :href="item.url" target="_blank">
                        {{ item.url }}
                      </a>
                    </td>
                  </tr>
                </template>
              </v-data-table>
            </v-app>
          </v-card>
          <!-- <table class="table table-hover">
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
                  <a :href="university.url" target="_blank">
                    {{ university.url }}
                  </a>
                </td>
              </tr>
              <tr>
              <th scope="row" colspan="3">1</th>
              
            </tr>
            </tbody>
          </table> -->
          
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
        universities: [],
        uni: [],
        search: '',
        headers: [
          {
            text: 'id',
            align: 'start',
            sortable: false,
            value: 'id',
          },
          {
            text: 'Name of University',
            value: 'name',
          },
          { text: 'URL', value: 'url' },
        ],
      }
      
    },
    mounted () {
      // axios.defaults.baseURL = "/api";
      // axios
      //   .get("/getAllUniversity")
      //   .then(response => {
      //     this.universities = response.data;
      //     this.uni = response.data;
      //   })
      //   .catch((error) => {
      //     alert(error);
      //   });
    },
    created() {
      if (!this.$session.exists()) {
        this.$alert("Please login to proceed").then(() => {
          this.$router.push({ name: "login" });
        });
      }
      this.getAllUniversity();
    },
    methods: {
      getAllUniversity() {
        axios.defaults.baseURL = "/api";
      axios
        .get("/getAllUniversity")
        .then(response => {
          this.universities = response.data;
          this.uni = response.data;
        })
        .catch((error) => {
          alert(error);
        });
      },
    }
  }
</script>
