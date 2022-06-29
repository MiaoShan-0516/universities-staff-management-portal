<template>
  <div>
  <nav-bar></nav-bar>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8" v-for="(user, index) in staff" :key="index">
        <h1>Staff - {{ user.name.first + ' ' + user.name.last }}</h1>
        <div class="border border-secondary">
          <div class="bg-secondary border-bottom p-2 text-white">
            Genaral Information
          </div>
          <div class="p-2">
            <img :src="user.picture" alt="staff_photo" class="img-fluid mb-3">
            <p><strong>Name:</strong> {{ user.name.first + ' ' + user.name.last }}</p>
            <p><strong>Email:</strong> 
            <a :href="'mailto:' + user.email">{{ user.email }}</a>
            </p>
            <p><strong>Date of birth:</strong> {{ user.dob }}</p>
            <p><strong>Age:</strong> {{ age }}</p>
          </div>
        </div> 
        <div 
          class="floating-add-icon" 
          data-toggle="modal" 
          data-target="#updateStaffModal"
          @click="getCurrentStaff(user)"
        >
          <i class="fa fa-pencil"></i>
        </div>       
      </div>
    </div>
  </div>
  
  
  <div class="cursor-pointer" data-toggle="modal" data-target="#deleteStaffModal" @click="deleteStaff()">
    <i class="fa fa-eraser"></i>
  </div>

  <!-- Modal Create Staff -->
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
      staff: [],
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
      this.getStaffDetails();
    },
    methods: {
      getStaffDetails() {
      this.id = this.$route.params.id;
      axios.defaults.baseURL = "/api";
      axios
        .get("/getStaffDetails/" + this.id)
        .then((response) => {
          this.staff = response.data.staff;
          this.birthday = response.data.birthday;
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