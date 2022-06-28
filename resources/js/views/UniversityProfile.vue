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
                    <td>
                      <router-link :to="{ path: '/staff/' + item.name.first.replace(/\s+/g, '-') + '-' + item.name.last.replace(/\s+/g, '-') + '/id=' + item.id }">
                        {{ item.name.first + " " + item.name.last }}
                      </router-link>
                    </td>
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
                  <label for="first">First Name<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" v-model="first" required>
                  <small v-if="!validation && !first" class="text-danger">*first name is empty</small>
                </div>
                <div class="form-group col-md-6">
                  <label for="last">Last Name<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" v-model="last" required>
                  <small v-if="!validation && !last" class="text-danger">*last name is empty</small>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-7">
                  <label for="email">Email<span class="text-danger">*</span></label>
                  <input type="email" class="form-control" v-model="email" placeholder="example@mail.com" required>
                  <small v-if="!validation && !email" class="text-danger">*email is empty</small>
                  <small v-if="email && !emailValidation(email)" class="text-danger">*Please enter a valid email address</small>
                </div>
                <div class="form-group col-md-5">
                  <label for="dob">Date of Birth<span class="text-danger">*</span></label>
                  <input type="date" class="form-control" v-model="dob" required>
                  <small v-if="!validation && !dob" class="text-danger">*date of birth is empty</small>
                  <small v-if="dob && !ageValidation(dob)" class="text-danger">*Minimum age for a staff is 21</small>
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
        validation: true,
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
          })
          .catch(function (error) {
            console.log(error);
          });
      },
      addStaff() {
        this.id = this.$route.params.id;
        if (
          !this.first ||
          !this.last ||
          !this.email ||
          !this.dob ||
          !this.emailValidation(this.email) ||
          !this.ageValidation(this.dob)
        ) {
          this.$alert(
            "Please fill in all details correctly",
            "Error",
            "error"
          ).then(() => {
            this.validation = false;
          });
        }
        else {
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
              $(document).ready(function () {
                $("#createStaffModal").modal("hide");
              });
              alert("New Staff Created");
              this.getUniversityDetails();
              this.full_name = {};
              this.first = "";
              this.last = "";
              this.email = "";
              this.dob = "";
              this.is_active = true;
              this.validation = true;
            })
            .catch((error) => {
              alert("Error");
            });
        }
      },
      emailValidation: function (email) {
        const re =
          /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      },
      handleBlur(e) {
        this.emailValidation(this.email);
        this.ageValidation(this.dob);
      },
      ageValidation(dob) {
        var today = new Date();
        var birthDate = new Date(dob);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        if (age >= 21) {
          return true;
        }
        else {
          return false;
        }
      },
    }
  };
</script>