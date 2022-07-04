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
          <span>{{ university[0].name }} > </span>
          <span 
            v-for="(user, index) in staff" 
            :key="index" 
            class="font-weight-bold"
          >
            {{ user.name.first + ' ' + user.name.last }}
          </span>
        </div>
      </div>
    </div>
  </div>
  <section id="without-breadcrumb">
    <div id="staff-profile" class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div v-for="(user, index) in staff" :key="index">
            <div class="name-card px-4 px-lg-5">
              <div class="row justify-content-center align-items-center">
                <div class="col-4 col-lg-3 p-0 p-lg-3 text-right">
                  <img :src="user.picture" alt="staff_photo" class="img-fluid w-100 py-3 rounded-circle">
                </div>
                <div class="col-8 d-none d-lg-block">
                  <div class="row justify-content-center">
                    <div class="col-8">
                      <h1>{{ user.name.first + ' ' + user.name.last }}</h1>
                      <p>
                        Status:
                        <i 
                          class="fa fa-circle"
                          :class="{ 'text-success': user.is_active, 'text-danger': !user.is_active }"
                        ></i>
                        <span 
                          class="font-weight-bold"
                          :class="{ 'text-success': user.is_active, 'text-danger': !user.is_active }"
                        >
                          {{ user.is_active ? 'Active' : 'Inactive Staff' }}
                        </span>
                      </p>
                      <p>
                        <strong>Email: </strong><a :href="'mailto:' + user.email">{{ user.email }}</a>
                      </p>
                      <p>
                        <strong>Date of birth: </strong>{{ user.dob }}
                      </p>
                      <p>
                        <strong>Age: </strong>{{ age }}
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-8 d-block d-lg-none d-flex flex-column align-items-center text-center">
                  <h5 class="font-weight-bold">{{ user.name.first + ' ' + user.name.last }}</h5>
                  <p class="m-0">
                    Status:
                    <i 
                      class="fa fa-circle"
                      :class="{ 'text-success': user.is_active, 'text-danger': !user.is_active }"
                    ></i>
                    <span 
                      class="font-weight-bold"
                      :class="{ 'text-success': user.is_active, 'text-danger': !user.is_active }"
                    >
                      {{ user.is_active ? 'Active' : 'Inactive Staff' }}
                    </span>
                  </p>
                </div>
              </div>     
            </div>
            <div class="d-block d-lg-none mt-3">
              <div class="bg-white p-3 my-2">
                <p class="m-0">
                  <strong>Email: </strong><a :href="'mailto:' + user.email">{{ user.email }}</a>
                </p>
              </div>
              <div class="bg-white p-3 my-2">
                <p class="m-0">
                  <strong>Date of birth: </strong>{{ user.dob }}
                </p>
              </div>
              <div class="bg-white p-3 my-2">
                <p class="m-0">
                  <strong>Age: </strong>{{ age }}
                </p>
              </div>
            </div>
            <div class="row justify-content-center mt-3">
              <div 
                class="btn-update-icon" 
                data-toggle="modal" 
                data-target="#updateStaffModal"
                @click="getCurrentStaff(user)"
              >
                <i class="fa fa-pencil"></i>
              </div>   
              <div 
                class="btn-update-icon" 
                @click="deleteStaff()"
              >
                <i class="fa fa-eraser"></i>
              </div>   
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Update Staff -->
  <div class="modal fade" id="updateStaffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        uniId: "",
        staff: [],
        university: [
          {
            name: '',
          }
        ],
        birthday: "",
        today: "",
        age: "",
        validation: true,
        update_staff_first: "",
        update_staff_last: "",
        update_staff_email: "",
        update_staff_dob: "",
        update_staff_is_active: "",
      };
    },
    created() {
      if (!this.$session.exists()) {
        this.$alert("Please login to proceed").then(() => {
          this.$router.push({ name: "login" });
        });
      }
      else {
        this.getStaffDetails();
      }
    },
    methods: {
      getStaffDetails() {
      this.id = this.$route.params.id;
      this.uniId = this.$route.params.uniId;
      console.log(this.id);
      axios.defaults.baseURL = "/api";
      axios
        .get("/getStaffDetails/" + this.id + '/' + this.uniId)
        .then((response) => {
          this.staff = response.data.staff;
          this.birthday = response.data.birthday;
          this.university = response.data.university;
          //calculate age
          var today = new Date();
          var dateOfBirth = new Date(this.birthday);
          var ages = today.getFullYear() - dateOfBirth.getFullYear();
          var m = today.getMonth() - dateOfBirth.getMonth();
          if (m < 0 || (m === 0 && today.getDate() < dateOfBirth.getDate())) 
          {
              ages--;
          }
          this.age = ages;
        })
        .catch(function (error) {
        console.log(error);
        });
      },
      getCurrentStaff(user) {
        this.update_staff_first = user.name.first;
        this.update_staff_last = user.name.last;
        this.update_staff_email = user.email;
        this.update_staff_dob = user.dob;
        this.update_staff_is_active = user.is_active;
        this.university_id = user.university_id;
        this.picture = user.picture;
      },
      updateStaffDetails() {
        this.id = this.$route.params.id;
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
              id: this.id,
              university_id: this.university_id,
              first: this.update_staff_first,
              last: this.update_staff_last,
              dob: this.update_staff_dob,
              email: this.update_staff_email,
              is_active: this.update_staff_is_active,
              picture: this.picture,
            })
            .then((response) => {
              alert("Staff Update Successful!");
              $(document).ready(function () {
                $("#updateStaffModal").modal("hide");
              });
              this.validation = true;
              this.getStaffDetails();
            })
            .catch((error) => {
              alert("Error");
            });
        }
      },
      deleteStaff() {
        this.id = this.$route.params.id;
        if(confirm("Do you want to delete this staff?")){
          axios.defaults.baseURL = "/api";
          axios
          .post('/deleteStaff/' + this.id)
          .then((response) => {
            alert("Staff Deleted");
            this.$router.back();
          })
          .catch((error) => {
            alert("Error");
          });   
        }
      },
      emailValidation: function (update_staff_email) {
        const re =
          /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(update_staff_email);
      },
      handleBlur(e) {
        this.emailValidation(this.update_staff_email);
        this.ageValidation(this.update_staff_dob);
      },
      ageValidation(update_staff_dob) {
        var today = new Date();
        var birthDate = new Date(update_staff_dob);
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