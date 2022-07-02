<template>
  <div data-app>
    <nav-bar></nav-bar>
    <div class="container-fluid breadcrumb-header"> 
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 py-0">
            <span class="font-weight-bold">Home</span>
          </div>
        </div>
      </div>
    </div>
    <section>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10">
            <!-- Desktop Univeristy Table -->
            <v-card class="d-none d-lg-block">
              <v-card-title>
                List of University
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
            <!-- End Desktop Univeristy Table -->
            
            <!-- Mobile Univeristy Table -->
            <v-card id="university-table-mob" class="d-block d-lg-none">
              <v-card-title>
                List of University
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
                  :items-per-page="10"
                  class="elevation-1"
                >
                  <template v-slot:item="{ item }">
                    <tr class="tr-border">
                      <router-link :to="{ path: '/profile/' + item.name.replace(/\s+/g, '-') + '/id=' + item.id }">
                        <div class="d-flex">
                          <div class="col-1">
                            <td>{{ item.id }}</td>
                          </div>
                          <div class="col-11">
                            <div class="d-flex flex-column">
                              <td class="td-title">
                                <router-link :to="{ path: '/profile/' + item.name.replace(/\s+/g, '-') + '/id=' + item.id }">
                                  {{ item.name }}
                                </router-link>
                              </td>
                              <td class="td-body">
                                <a :href="item.url" target="_blank">
                                  {{ item.url }}
                                </a>
                              </td>
                            </div>
                          </div>
                        </div>
                      </router-link>
                    </tr>
                  </template>
                </v-data-table>
              </v-app>
            </v-card>
            <!-- End Mobile Univeristy Table -->
          </div>
        </div>
      </div>
    </section>
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
            text: 'No',
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
      else {
        this.getAllUniversity();
      }
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
