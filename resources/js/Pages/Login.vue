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
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" v-model="password" name="password" placeholder="*******" aria-describedby="password">
                  <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" v-model="rememberMe" type="checkbox" id="remember-me">
                    <label class="form-check-label" for="remember-me"> ຈື່ຂ້ອຍໄວ້ໃນລະບົບ </label>
                  </div>
                 
                </div>
              </div>
              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" @click="Login()">ເຂົ້າສູ່ລະບົບ</button>
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
            rememberMe: false
        }
    },
    methods:{
        Login(){

            axios.post('/api/login', {
                email: this.email,
                password: this.password,
                remember_me: this.rememberMe
            }).then(response => {
                // ສຳເລັດ
                console.log(response.data);
               
                // ອັບເດດສະຖານະໃນ store
                this.authStore.setToken(response.data.token);
                this.authStore.setUser(response.data.user);
                // ນໍາໄປຫາໜ້າຫຼັກ
                this.$router.push('/');
            }).catch(error => {
                // ຜິດພາດ
                console.log(error.response.data);
               
            });
        }

    }
}
</script>
<style lang="">
    
</style>