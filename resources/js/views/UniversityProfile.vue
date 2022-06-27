<template>
  <div>
    <nav-bar></nav-bar>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-8" v-for="(uni, index) in university" :key="index">
          <h1>School - {{ uni.name }}</h1>
          <div class="border border-secondary">
            <div class="bg-secondary border-bottom p-2 text-white">
              Genaral Information
            </div>
            <div class="p-2">
              <p><strong>Name of University:</strong> {{ uni.name }}</p>
              <p><strong>URL:</strong> 
                <a :href="uni.url" target="_blank">{{ uni.url }}</a>
              </p>
            </div>
          </div>        
        </div>
        <div class="col-12 col-lg-8">
          <h2>List of staffs</h2>
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
                :items="staffs"
                :search="search"
                :items-per-page="10"
                class="elevation-1"
              >
                <template v-slot:item="{ item }">
                  <tr>
                    <td>{{ item.name.first + " " + item.name.last }}</td>
                    <td>
                      <a :href="'mailto:' + item.email">{{ item.email }}</a>
                    </td>
                  </tr>
                </template>
              </v-data-table>
            </v-app>
          </v-card>
        </div>
      </div>
    </div>
    
    <div class="floating-add-icon" data-toggle="modal" data-target="#createStaffModal">
      <i class="fa fa-plus"></i>
    </div>

    <!-- Modal Create Staff -->
    <div class="modal fade" id="createStaffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create new staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="first">First Name</label>
                  <input type="text" class="form-control" v-model="first" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="last">Last Name</label>
                  <input type="text" class="form-control" v-model="last" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-8">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" v-model="email" placeholder="example@mail.com" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="dob">Date of Birth</label>
                  <input type="date" class="form-control" v-model="dob" required>
                </div>
              </div>
              <div class="form-group mx-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" v-model="is_active" checked>
                  <label class="form-check-label" for="is_active">
                    Active
                  </label>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button @click="addStaff()" class="btn btn-info text-white">Submit</button>
            <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end Modal Create Staff -->
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
        id: "",
        university: [],
        staffs: [],
        search: '',
        headers: [
          {
            text: 'Name',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          {
            text: 'Email',
            value: 'email',
          },
        ],
        first: "",
        last: "",
        email: "",
        dob: "",
        is_active: true,
      };
    },
    created() {
      if (!this.$session.exists()) {
        this.$alert("Please login to proceed").then(() => {
          this.$router.push({ name: "login" });
        });
      }
      this.getUniversityDetails();
    },
    methods: {
      getUniversityDetails() {
        this.id = this.$route.params.id;
        axios.defaults.baseURL = "/api";
        axios
          .get("/getUniversityDetails/" + this.id)
          .then((response) => {
            this.university = response.data.university;
            this.staffs = response.data.staffs;
            this.staff_name = response.data.staff_name;
          })
          .catch(function (error) {
            console.log(error);
          });
      },
      addStaff(){
      this.id = this.$route.params.id;

      var full_name = {
        first: this.first,
        last: this.last,
      };

      axios.defaults.baseURL = "/api";
      axios
        .post("/addStaffToUniversity/" + this.id, {
          university_id: this.id,
          first: this.first,
          last: this.last,
          email: this.email,
          dob: this.dob,
          is_active: this.is_active,
        })
        .then((response) => {
          alert("Staff Has Been Created");
          $(document).ready(function () {
            $("#createStaffModal").modal("hide");
          });
          this.getUniversityDetails();
          this.full_name = {};
          this.first = "";
          this.last = "";
          this.email = "";
          this.dob = "";
          this.is_active = true;
        })
        .catch((error) => {
          alert("Error");
        });
    },
      }
  };
</script>