<template lang="">

    <div class="row d-flex justify-content-center">
        <div class="col-lg-4 col-md-6">

              <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card px-sm-6 px-0">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
          

                <span class="app-brand-text demo text-heading fw-bold">ສະບາຍດີ</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">ຍິນດີຕ້ອນຮັບ 👋</h4>
            <p class="mb-6">ກະລຸນາເຂົ້າສູ່ລະບົບ</p>

              <!-- Email: {{ email }} <br>
              Password: {{ password }} <br>
              remember-me: {{ rememberMe }} <br> -->
              <div class="mb-6">
                <label for="email" class="form-label">ອີເມວລ໌:</label>
                <input type="text" class="form-control" id="email" name="email-username" v-model="email" placeholder="ກະລຸນາໃສ່ອີເມວລ໌..." autofocus="">
                <p class=" text-danger fs-6 " v-if="message_email" > {{message_email}}</p>
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                <div class="input-group input-group-merge">
                  <input :type="showpassword" id="password" class="form-control" v-model="password" name="password" placeholder="*******" aria-describedby="password">
                  <!-- <span class="input-group-text cursor-pointer" @click="showpassword = showpassword === 'password' ? 'text' : 'password'"> -->
                  <span class="input-group-text cursor-pointer" @click="ShowPass()">

                    <!-- <i class="icon-base bx" :class="showpassword === 'password' ? 'bx-hide' : 'bx-show'"></i> -->

                    <i class="icon-base bx bx-hide" v-if="showpassword === 'password'"></i>
                    <i class="icon-base bx bx-show" v-else></i>
                    
                  </span>
                  
                </div>
                <p class=" text-danger fs-6" v-if="message_password" >{{ message_password }}</p>
              </div>
              <div class="mb-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" v-model="rememberMe" type="checkbox" id="remember-me">
                    
                    <label class="form-check-label" for="remember-me"> ຈື່ຂ້ອຍໄວ້ໃນລະບົບ </label>
                  </div>
                 
                </div>
              </div>
              <div class="alert alert-warning" role="alert" v-if="message_login">{{ message_login }}</div>
              <div class="mb-6"> 
                <button class="btn btn-primary d-grid w-100" @click="Login()" :disabled="isFormValid">ເຂົ້າສູ່ລະບົບ</button>
              </div>
           
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>

        </div>
    </div>

  
</template>
<script>
import axios from 'axios';
import { useAuthStore } from '../Stores/Auth';

export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    },
    data() {
        return {
            email: '',
            password: '',
            rememberMe: false,
            message_email: '',
            message_password: '',
            showpassword: 'password',
            message_login: ''
        }
    },
    computed: {
       isFormValid() {

        // check email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(this.email){
            if(!emailPattern.test(this.email)){
                this.message_email = 'ອີເມວລ໌ບໍ່ຖືກຕ້ອງ';
            } else {
                this.message_email = '';
            }
        } else {
            this.message_email = '';
        }

        // check password
        if(this.password){
            if(this.password.length < 6){ // sone = 4
                this.message_password = 'ລະຫັດຜ່ານຕ້ອງມີຢ່າງນ້ອຍ 6 ໂຕອັກສອນ';
            } else {
                this.message_password = '';
            }
        } else {
            this.message_password = '';
        }

        // disable button

          if(!emailPattern.test(this.email) || this.password.length < 6){
            return true; // disable
          } else {
            return false; // enable
          }
       }
    },
    methods:{
        ShowPass(){
           if(this.showpassword === 'password'){
                this.showpassword = 'text';
           } else {
                this.showpassword = 'password';
           }
        },
        Login(){

            axios.post('/api/login', {
                email: this.email,
                password: this.password,
                remember_me: this.rememberMe
            }).then(response => {
                // ສຳເລັດ
                console.log(response.data);

              
                this.message_login = '';
               
                // ອັບເດດສະຖານະໃນ store
                this.authStore.setToken(response.data.token);
                this.authStore.setUser(response.data.user);
                // ນໍາໄປຫາໜ້າຫຼັກ
                this.$router.push('/');
            }).catch(error => {
                // ຜິດພາດ
                console.log(error.response.data);
                  if(error.response.data.success === false){
                    this.message_login = error.response.data.message;
                    return; // ອອກຈາກ method Login ຫຼື ຍຸດການເຮັດວຽກ
                }

               
            });
        }

    }
}
</script>
<style lang="">
    
</style>