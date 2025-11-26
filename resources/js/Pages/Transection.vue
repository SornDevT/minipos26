<template lang="">
    <div class="card">
    <h5 class="card-header">ການເຄື່ອນໄຫວທຸລະກຳ</h5>
    <div class="card-body">

        <div class="d-flex justify-content-between">
            <div class=" d-flex align-items-center mb-3">
                <div class="me-2" @click="Sort = (Sort === 'asc') ? 'desc' : 'asc'; GetTran(); " style="cursor: pointer;">
                    <i class='bx bx-sort-up fs-4' v-if="Sort === 'asc'"></i>
                    <i class='bx bx-sort-down fs-4' v-else></i>
                </div>
                <select class="form-select w-auto me-2" v-model="PerPage" @change="GetTran()">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class="  mb-3 d-flex justify-content-end align-items-center">
                <div class="input-group input-group-merge w-auto me-2">
                    <input type="text" v-model="Search" class="form-control w-auto" placeholder="ຄົ້ນຫາ..." @keyup.enter="GetTran()" />
                    <span class="input-group-text" id="basic-addon-search31"><i class="icon-base bx bx-search"></i></span>
                </div>
                <div class="btn-group me-2" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary" @click="month_type = 'm'"><i class='bx bx-chevron-right' v-if="month_type === 'm'"></i> ເດືອນ</button>
                  <button type="button" class="btn btn-secondary" @click="month_type = 'y'"><i class='bx bx-chevron-right' v-if="month_type === 'y'"></i> ປີ</button>
                </div>
                <input type="date" v-model="dmy" class="form-control w-auto" />  
            </div>
        </div> 
        <!-- {{ CategoryList }} -->
      <div class="table-responsive text-nowrap"> 
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ວັນທີ</th>
              <th>ເລກທີທຸລະກຳ</th>
              <th>ປະເພດທຸລະກຳ</th>
              <th>ລາຍລະອຽດ</th>
              <th class="text-center">ມູນຄ່າ</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="tr in Transection.data" :key="tr.id">
              
                <td>{{ date(tr.created_at)}} </td>
                <td>{{tr.TranID}} </td>
                <td>{{tr.TranType}} </td>
                <td>{{tr.Detail}} </td>
                <td class="text-end">{{FormatPrice(tr.Price)}} ກີບ</td>
            </tr>
           
          </tbody>
        </table>
        <Pagination :pagination="Transection" :offset="4" @paginate="GetTran($event)" />
      </div>

    </div>
  </div>
</template>
<script>

import { useAuthStore } from '../Stores/Auth';
import axios from 'axios';
import dayjs from 'dayjs';


export default {
    setup() {
        const authStore = useAuthStore();
        return {    
            authStore,
        };
    },
    data() {
        return {
            month_type:"m",
            dmy: new Date().toISOString().substr(0, 10),
            PerPage: 10,
            Search: '',
            Sort: 'desc',
            Transection:[],
        }
    },
    methods: {
         FormatPrice(value) {
             let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        date(val) {
            return dayjs(val).format('DD/MM/YYYY');
        },
        GetTran(page = 1) {
             axios.get(`/api/transection?page=${page}&perPage=${this.PerPage}&sort=${this.Sort}&search=${this.Search}&month_type=${this.month_type}&dmy=${this.dmy}`, {
                headers: {
                    Authorization: `Bearer ${this.authStore.token}`
                }
            }).then((response) => {
                this.Transection = response.data;
            }).catch((error) => {
                console.error('Error fetching products:', error);
                if(error && error.response.status === 401){
                    this.authStore.logout();
                    this.$router.push({ name: 'Login' });
                }
            });
        }
    },
    created() {
        this.GetTran();
    },
    watch: {
        Search(newVal) {
            if (newVal.length === 0 ) {
                this.GetTran();
            }
        },
        dmy(newVal, oldVal) {
            this.GetTran();
        },
        month_type(newVal, oldVal) {
            this.GetTran();
        }
    }
}
</script>
<style lang="">
    
</style>