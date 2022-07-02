<template>
  <div>
    <nav-bar></nav-bar>
    <div class="d-none d-lg-block container-fluid breadcrumb-header"> 
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 py-0">
            <span>
              <router-link :to="{ name: 'home'}">
                Home
              </router-link>
              >
            </span>
            <span 
              v-for="(uni, index) in university" 
              :key="index" 
              class="font-weight-bold"
            >
              {{ uni.name }}
            </span>
          </div>
        </div>
      </div>
    </div>
    <section id="without-breadcrumb">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10">
            <div
              v-for="(uni, index) in university" :key="index"
              class="name-card"
            >
              <div class="row justify-content-center align-items-center">
                <div class="col-3 col-lg-2 p-0 p-lg-2">
                  <img src="/img/u_icon.png" alt="u_icon" class="img-fluid">
                </div>
                <div class="d-none d-lg-block col-3 text-right">
                  <p><strong>Name of University :</strong></p>
                  <p><strong>URL :</strong></p>
                </div>
                <div class="d-none d-lg-block col-6 text-left">
                  <p>{{ uni.name }}</p>
                  <p>
                    <u><a :href="uni.url" target="_blank">{{ uni.url }}</a></u>
                  </p>
                </div>
                <div class="d-block d-lg-none col-8">
                  <small>
                    <strong>Name:</strong> {{ uni.name }}
                  </small>
                  <br>
                  <small>
                    <strong>URL: </strong>
                    <u><a :href="uni.url" target="_blank">{{ uni.url }}</a></u>
                  </small>
                </div>
              </div>       
            </div>
          </div>
          <div class="col-12 col-lg-10">
            <div class="text-right my-2" @click="toggleInactiveStaff()">
              <input class="col-6" type="checkbox" data-toggle="toggle" data-onstyle="info" data-on="Include Inctive Staff" data-off="Show Active Staff">
            </div>
            <!-- Desktop Staff Table -->
            <v-card class="d-none d-lg-block">
              <v-card-title>
                List of Staff
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-app id="staff">
                <v-data-table
                  :headers="headers"
                  :items="staffs"
                  :search="search"
                  class="elevation-1"
                >
                  <template v-slot:item="{ item }">
                    <tr v-if="item.is_active">
                      <td>
                        <router-link :to="{ path: '/' + item.university_id + '/staff/' + item.name.first.replace(/\s+/g, '-') + '-' + item.name.last.replace(/\s+/g, '-') + '/id=' + item.id }">
                          {{ item.name.first + " " + item.name.last }}
                        </router-link>
                      </td>
                      <td>
                        <a :href="'mailto:' + item.email">{{ item.email }}</a>
                      </td>
                      <td class="text-right">
                        <i 
                          data-toggle="modal" 
                          data-target="#updateStaffModal"
                          @click="
                            getCurrentStaff(
                              item.id, 
                              item.name.first, 
                              item.name.last, 
                              item.email,
                              item.dob,
                              item.is_active,
                              item.picture,
                              item.university_id
                            )
                          "
                          class="fa fa-pencil cursor-pointer"
                        ></i>
                        <button 
                          type="button" 
                          class="close mx-4"
                          @click="deleteStaff(item.id)"
                        >
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </td>
                    </tr>
                    <tr v-if="!item.is_active && showInactiveStaff" class="inactive-staff-row">
                      <td>
                        <router-link :to="{ path: '/' + item.university_id + '/staff/' + item.name.first.replace(/\s+/g, '-') + '-' + item.name.last.replace(/\s+/g, '-') + '/id=' + item.id }">
                          {{ item.name.first + " " + item.name.last }}
                        </router-link>
                      </td>
                      <td>
                        <a :href="'mailto:' + item.email">{{ item.email }}</a>
                      </td>
                      <td class="text-right">
                        <i 
                          data-toggle="modal" 
                          data-target="#updateStaffModal"
                          @click="
                            getCurrentStaff(
                              item.id, 
                              item.name.first, 
                              item.name.last, 
                              item.email,
                              item.dob,
                              item.is_active,
                              item.picture,
                              item.university_id
                            )
                          "
                          class="fa fa-pencil cursor-pointer"
                        ></i>
                        <button 
                          type="button" 
                          class="close mx-4"
                          @click="deleteStaff(item.id)"
                        >
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </td>
                    </tr>
                  </template>
                </v-data-table>
              </v-app>
            </v-card>
            <!-- End Desktop Staff Table -->

            <!-- Mobile Staff Table -->
            <v-card class="d-block d-lg-none">
              <v-card-title>
                List of Staff
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-app id="staff">
                <v-data-table
                  :headers="headers"
                  :items="staffs"
                  :search="search"
                  class="elevation-1"
                >
                  <template v-slot:item="{ item }">
                    <tr v-if="item.is_active" class="tr-border">
                      <div class="d-flex">
                        <div class="col-8">
                          <router-link :to="{ path: '/' + item.university_id + '/staff/' + item.name.first.replace(/\s+/g, '-') + '-' + item.name.last.replace(/\s+/g, '-') + '/id=' + item.id }">
                            <div class="d-flex flex-column">
                              <td class="td-title">
                                {{ item.name.first + " " + item.name.last }}
                              </td>
                              <td class="td-body">
                              
                                <a :href="'mailto:' + item.email">{{ item.email }}</a>
                              </td>
                            </div>
                          </router-link>
                        </div>  
                        <div class="col-4 d-flex align-items-center justify-content-end">
                          <td class="d-flex">
                            <button 
                              class="mx-2 h4 collapse"
                              :class="'editStaff' + item.id"
                            >
                              <i 
                                data-toggle="modal" 
                                data-target="#updateStaffModal"
                                @click="
                                  getCurrentStaff(
                                    item.id, 
                                    item.name.first, 
                                    item.name.last, 
                                    item.email,
                                    item.dob,
                                    item.is_active,
                                    item.picture,
                                    item.university_id
                                  )
                                "
                                class="fa fa-pencil cursor-pointer"
                              ></i>
                            </button>
                            <button 
                              @click="deleteStaff(item.id)"
                              class="mx-2 h4 collapse"
                              :class="'editStaff' + item.id"
                            >
                              <i class="fa fa-close"></i>
                            </button>
                            <button 
                              data-toggle="collapse" 
                              :href="'.editStaff' + item.id"
                              class="mx-2 h5"
                            >
                              <i class="fa fa-bars"></i>
                            </button>
                          </td>
                        </div>
                      </div>
                    </tr>
                    <tr v-if="!item.is_active && showInactiveStaff" class="inactive-staff-row">
                      <div class="d-flex">
                        <div class="col-8">
                          <router-link :to="{ path: '/' + item.university_id + '/staff/' + item.name.first.replace(/\s+/g, '-') + '-' + item.name.last.replace(/\s+/g, '-') + '/id=' + item.id }">
                            <div class="d-flex flex-column">
                              <td class="td-title">
                                {{ item.name.first + " " + item.name.last }}
                              </td>
                              <td class="td-body">
                              
                                <a :href="'mailto:' + item.email">{{ item.email }}</a>
                              </td>
                            </div>
                          </router-link>
                        </div>  
                        <div class="col-4 d-flex align-items-center justify-content-end">
                          <td class="d-flex">
                            <button 
                              class="mx-2 h4 collapse"
                              :class="'editStaff' + item.id"
                            >
                              <i 
                                data-toggle="modal" 
                                data-target="#updateStaffModal"
                                @click="
                                  getCurrentStaff(
                                    item.id, 
                                    item.name.first, 
                                    item.name.last, 
                                    item.email,
                                    item.dob,
                                    item.is_active,
                                    item.picture,
                                    item.university_id
                                  )
                                "
                                class="fa fa-pencil cursor-pointer"
                              ></i>
                            </button>
                            <button 
                              @click="deleteStaff(item.id)"
                              class="mx-2 h4 collapse"
                              :class="'editStaff' + item.id"
                            >
                              <i class="fa fa-close"></i>
                            </button>
                            <button 
                              data-toggle="collapse" 
                              :href="'.editStaff' + item.id"
                              class="mx-2 h5"
                            >
                              <i class="fa fa-bars"></i>
                            </button>
                          </td>
                        </div>
                      </div>
                    </tr>
                  </template>
                </v-data-table>
              </v-app>
            </v-card>
            <!-- End Mobile Staff Table -->
          </div>
        </div>
      </div>
    </section>
    
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

    <!-- Modal Update Staff -->
    <div class="modal fade" id="updateStaffModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update staff</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="first">First Name<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" v-model="update_staff_first" required>
                  <small v-if="!validation && !update_staff_first" class="text-danger">*first name is empty</small>
                </div>
                <div class="form-group col-md-6">
                  <label for="last">Last Name<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" v-model="update_staff_last" required>
                  <small v-if="!validation && !update_staff_last" class="text-danger">*last name is empty</small>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-7">
                  <label for="email">Email<span class="text-danger">*</span></label>
                  <input type="email" class="form-control" v-model="update_staff_email" placeholder="example@mail.com" required>
                  <small v-if="!validation && !update_staff_email" class="text-danger">*email is empty</small>
                  <small v-if="update_staff_email && !emailValidation(update_staff_email)" class="text-danger">*Please enter a valid email address</small>
                </div>
                <div class="form-group col-md-5">
                  <label for="dob">Date of Birth<span class="text-danger">*</span></label>
                  <input type="date" class="form-control" v-model="update_staff_dob" required>
                  <small v-if="!validation && !update_staff_dob" class="text-danger">*date of birth is empty</small>
                  <small v-if="update_staff_dob && !ageValidation(update_staff_dob)" class="text-danger">*Minimum age for a staff is 21</small>
                </div>
              </div>
              <div class="form-group mx-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" v-model="update_staff_is_active">
                  <label class="form-check-label" for="is_active">
                  Active
                  </label>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
          <button @click="updateStaffDetails()" class="btn btn-info text-white">Update</button>
          <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end Modal Update Staff -->
    
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
          {
            text: 'Action',
            value: 'action',
          },
        ],
        first: "",
        last: "",
        email: "",
        dob: "",
        is_active: true,
        validation: true,
        showInactiveStaff: false,
        update_staff_id: "",
        update_staff_first: "",
        update_staff_last: "",
        update_staff_email: "",
        update_staff_dob: "",
        update_staff_is_active: "",
        update_staff_picture: "",
        update_staff_university_id: "",
      };
    },
    created() {
      if (!this.$session.exists()) {
        this.$alert("Please login to proceed").then(() => {
          this.$router.push({ name: "login" });
        });
      }
      else {
        this.getUniversityDetails();
      }
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
      toggleInactiveStaff() {
        this.showInactiveStaff = !this.showInactiveStaff;
        this.getUniversityDetails();
        console.log(this.showInactiveStaff);
      },
      getCurrentStaff(staffId, staffFirstName, staffLastName, staffEmail, staffDob, staffIsActive, staffPicture, staffUniversityId) {
        this.update_staff_id = staffId;
        this.update_staff_first = staffFirstName;
        this.update_staff_last = staffLastName;
        this.update_staff_email = staffEmail;
        this.update_staff_dob = staffDob;
        this.update_staff_is_active = staffIsActive;
        this.update_staff_picture = staffPicture;
        this.update_staff_university_id = staffUniversityId;
      },
      updateStaffDetails() {
        if (
          !this.update_staff_first ||
          !this.update_staff_last ||
          !this.update_staff_email ||
          !this.update_staff_dob ||
          !this.emailValidation(this.update_staff_email) ||
          !this.ageValidation(this.update_staff_dob)
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
            .post("/updateStaffDetails", {
              id: this.update_staff_id,
              university_id: this.update_staff_university_id,
              first: this.update_staff_first,
              last: this.update_staff_last,
              dob: this.update_staff_dob,
              email: this.update_staff_email,
              is_active: this.update_staff_is_active,
              picture: this.update_staff_picture,
            })
            .then((response) => {
              alert("Staff Update Successful!");
              $(document).ready(function () {
                $("#updateStaffModal").modal("hide");
              });
              this.validation = true;
              this.getUniversityDetails();
            })
            .catch((error) => {
              alert("Error");
            });
        }
      },
      deleteStaff(staffId) {
        if(confirm("Do you want to delete this staff?")){
          axios.defaults.baseURL = "/api";
          axios
          .post('/deleteStaff/' + staffId)
          .then((response) => {
            alert("Staff Deleted");
            this.getUniversityDetails();
          })
          .catch((error) => {
            alert("Error");
          });   
        }
      },
    }
  };
</script>