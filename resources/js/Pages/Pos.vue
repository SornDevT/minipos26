<template lang="">
    <div class="row">
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body d-flex">
                <select class="form-select w-auto me-2 " v-model="CategorySelect" @change="GetProducts()">
                     <option value="all">ໝວດໝູ່ທັງໝົດ</option>
                    <option :value="category.id" v-for="category in CategoryList" :key="category.id">{{ category.CategoryName }}</option>
                </select>
                <div class="input-group input-group-merge w-100 me-2">
                    <input type="text" v-model="Search" class="form-control w-auto" placeholder="ຄົ້ນຫາ..." @keyup.enter="GetProducts()" />
                    <span class="input-group-text" id="basic-addon-search31"><i class="icon-base bx bx-search"></i></span>
                </div>
            </div>
          </div>
          <PerfectScrollbar>
                <div class="row" style="height: calc(100vh - 300px); ">
                        <div class="col-lg-3 mb-4" v-for="item in ProductsList" :key="item.id" >
                                    <div class="card" style="position: relative;" @click="AddOrder(item)">
                                        <!-- <span class="num-list">10</span>
                                        <span class="store-num">ສິນຄ້າໝົດ</span> -->
                                        <img v-if="item.ImagePath" :src="url + '/assets/img/products/'+item.ImagePath" alt="Card image cap" class="img-pos card-img-top" >
                                        <img v-else :src="url + '/assets/img/no-img.jpg'" alt="Card image cap" class="img-pos card-img-top" >
                                        <div class="card-body p-1 text-center">
                                            <p class="card-text">{{ item.ProductName }}</p>
                                            <p class="card-text">{{ item.PriceSell }} ກີບ</p>
                                        </div>
                                </div>
                        </div>

                </div>
            </PerfectScrollbar>



        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
                        <label>ຊື່ລູກຄ້າ:</label>
                        <input type="text" class="form-control mb-3" placeholder="ຊື່ລູກຄ້າ...">
                        <label>ເບີໂທ:</label>
                        <input type="text" class="form-control mb-3" placeholder="ເບີໂທ...">
                    </div>
                    <div class=" bg-info p-3 text-white">
                        ລາຍການສິນຄ້າ
                    </div>
                    <PerfectScrollbar>
                        <div style="height: calc(100vh - 500px); "> 
                            <!-- {{ListOrder}} -->
                        <table class="table borderless mb-0" v-if="ListOrder.length > 0">
                            <tr v-for="item in ListOrder" :key="item.id">
                                <td>
                                    <div class="p-1 d-flex">
                                        
                                        <img v-if="item.ImagePath" :src="url + '/assets/img/products/'+item.ImagePath" class="img-list">
                                        <img v-else :src="url + '/assets/img/no-img.jpg'" class="img-list">
                                        <div class="w-100 ms-2 pe-2">
                                        <span>{{ item.ProductName }}</span>
                                        <div class="text-end">{{ item.Qty }} x {{ item.PriceSell }} ກີບ</div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class='bx bxs-plus-circle text-success '></i> | <i class='bx bxs-minus-circle text-warning' ></i>  | <i class='bx bxs-trash text-danger' ></i></span>
                                            <span>{{ item.PriceSell * item.Qty }} ກີບ</span>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div v-else class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 500px); ">
                           <i class='bx bxs-data'></i> ບໍ່ມີຂໍ້ມູນ
                        </div>
                        </div>
                    </PerfectScrollbar>
                    <div class=" bg-info p-3 text-white fw-bold d-flex justify-content-between align-items-center">
                        <span>ລວມທັງໝົດ:</span> <span>1,200,000 ກີບ</span>
                    </div>
                    <div class="p-2">
                        <button type="button" class="btn rounded-pill btn-success w-100">ຊຳລະເງິນ</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useAuthStore } from '../Stores/Auth';

export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    },
    data() {
        return {
            url: window.location.origin,
             CategoryList: [],
             ProductsList: [],
             ListOrder: [],
             CategorySelect: 'all',
            Search: '', 
            Sort: 'asc',
            PerPage: 'all',
        }
    },
    methods: {
        AddOrder(item){
            // console.log(item);


            let exist = this.ListOrder.find(order => order.id === item.id);

            if(exist){
                exist.Qty += 1;
                return; // ຍຸດການເຮັດງານທີ່ນີ້
            } 

            
            this.ListOrder.push({
                id: item.id,
                ImagePath: item.ImagePath,
                ProductName: item.ProductName,
                PriceSell: item.PriceSell,
                Qty: 1,
            });
        },
        GetCate(){
            axios.get(`/api/categories`, {
                headers: {
                    Authorization: `Bearer ${this.authStore.token}`
                }
            })
            .then((response) => {
                this.CategoryList = response.data;
            })
            .catch((error) => {
                // console.error('Error fetching categories:', error);
                // console.log(error.response.status);
                if(error && error.response.status === 401){
                    this.authStore.logout();
                    this.$router.push({ name: 'Login' });
                }
            });
        },
        GetProducts(page=1){
            // get products logic here
            axios.get(`/api/products?page=${page}&perPage=${this.PerPage}&sort=${this.Sort}&search=${this.Search}&category=${this.CategorySelect}`, {
                headers: {
                    Authorization: `Bearer ${this.authStore.token}`
                }
            }).then((response) => {
                this.ProductsList = response.data;
            }).catch((error) => {
                console.error('Error fetching products:', error);
                if(error && error.response.status === 401){
                    this.authStore.logout();
                    this.$router.push({ name: 'Login' });
                }
            });
        },
    },
    created(){
        this.GetCate();
        this.GetProducts();
    },
    watch: {
        Search(newVal) {
            if (newVal === '') {
                this.GetProducts();
            }
        }
    }
}
</script>
<style scoped>
    .img-list{
        width: 70px;
    height: 70px;
    object-fit: cover;
    object-position: center;
    border-radius: 5px;
    border: 1px solid #b6b8b9;
    padding: 2px;
    }
    .num-list{
       position: absolute;
    background-color: blueviolet;
    color: white;
    padding: 5px;
    right: 0px;
    border-radius: 0px 5px;
    }

    .store-num{
      position: absolute;
    background-color: #ff000063;
    width: 100%;
    padding: 5px;
    color: white;
    font-weight: bold;
    text-align: center;
    top: 50px;
    }

    .img-pos{
            width: 100%;
    height: 120px;
    object-position: center;
    object-fit: cover;

    }
</style>