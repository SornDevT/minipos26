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
                                    <div class="card cursor-pointer" style="position: relative;" @click="AddOrder(item)">
                                        <span v-for="order in ListOrder" :key="order.id">
                                            <span class="num-list" v-if="order.id === item.id">{{ order.Qty }}</span>
                                        </span>
                                        
                                       
                                        <span class="store-num" v-if="item.Qty === 0">ສິນຄ້າໝົດ</span>
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
                        <input type="text" class="form-control mb-3" v-model="customer_name" placeholder="ຊື່ລູກຄ້າ...">
                        <label>ເບີໂທ:</label>
                        <input type="text" class="form-control mb-3" v-model="customer_phone" placeholder="ເບີໂທ...">
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
                                        <div class="text-end">{{ item.Qty }} x {{ FormatPrice(item.PriceSell) }} ກີບ</div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class='bx bxs-plus-circle text-success cursor-pointer ' @click="AddOrder(item)"></i> | 
                                                <i class='bx bxs-minus-circle text-warning cursor-pointer' @click="RemoveOrder(item)"></i>  | 
                                                <i class='bx bxs-trash text-danger cursor-pointer' @click="DeleteOrder(item)"></i></span>
                                            <span>{{ FormatPrice(item.PriceSell * item.Qty) }} ກີບ</span>
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
                        <span>ລວມທັງໝົດ:</span> <span>{{ FormatPrice(SumTotal) }} ກີບ</span>
                    </div>
                    <div class="p-2">
                        <button type="button" @click="ConfirmOrder()" class="btn rounded-pill btn-success w-100" :disabled="SumTotal === 0" >ຊຳລະເງິນ</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

        <div class="modal modal-top fade" id="ConfirmOrder" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog">
                    <form class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTopTitle">ຍືນບັນຊຳລະເງິນ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                        
                         <div class="row">
                        <div class="col-md-6">
                            <div class=" d-flex justify-content-between">
                                <span>ລວມຍອດເງິນ:</span>
                                <span>{{ FormatPrice(SumTotal) }} ກີບ</span>
                            </div>
                            <div class=" d-flex justify-content-between text-danger" v-if="(CashAmount-SumTotal)>0">
                                <span>ເງິນທອນ:</span>
                                <span>{{ FormatPrice(CashAmount-SumTotal) }} ກີບ</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <label>ຮັບເງິນນຳລູກຄ້າ</label>
                                <cleave :options="options" v-model="CashAmount" class=" form-control text-end" />
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <!-- <button type="button" class=" btn btn-primary w-100" @click="AddNum(500)" >500</button> -->
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-danger w-100"  @click="CashAmount = SumTotal">{{FormatPrice(SumTotal)}}</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-primary w-100" @click="AddNum(500)" >500</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-primary w-100"  @click="AddNum(1000)">1,000</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-primary w-100"  @click="AddNum(2000)" >2,000</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-primary w-100"  @click="AddNum(5000)">5,000</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-primary w-100"  @click="AddNum(10000)">10,000</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-primary w-100"  @click="AddNum(20000)" >20,000</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-primary w-100"  @click="AddNum(50000)">50,000</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class=" btn btn-primary w-100"  @click="AddNum(100000)" >100,000</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                      </div>
                      <div class="modal-footer">
                       
                        <button type="button" class="btn btn-success" @click="Pay()" :disabled="CashAmount < SumTotal">ຍືນຍັນຊຳລ່ະ</button>
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ປິດ</button>
                      </div>
                    </form>
                  </div>
                </div>


</template>
<script>
import { useAuthStore } from '../Stores/Auth';
import axios from 'axios';

export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    },
    data() {
        return {
            url: window.location.origin,
            customer_name: '',
            customer_phone: '',
             CategoryList: [],
             ProductsList: [],
             ListOrder: [],
             CategorySelect: 'all',
            Search: '', 
            Sort: 'asc',
            PerPage: 'all',
            options: {
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: '.',
                  delimiter: ','
                },
            CashAmount: 0,
        }
    },
    computed: {
        SumTotal(){
            let total = 0;
            this.ListOrder.forEach(item => {
                total += item.PriceSell * item.Qty;
            });
            return total;
        }
    },
    methods: {
        async openLink(link){
            const response = await fetch(`${link}`,{ headers:{ Authorization:`Bearer ${this.authStore.token}`}});
            const html = await response.text();
            const blob = new Blob([html],{ type: "text/html"});
            const blobUrl = URL.createObjectURL(blob);
            window.open(blobUrl, "_blank");
        },
        Pay(){
            axios.post('/api/pos/pay', {
                orders: this.ListOrder,
                customer_name: this.customer_name,
                customer_phone: this.customer_phone,
            }, {
                headers: {
                    Authorization: `Bearer ${this.authStore.token}`
                }
            }).then((response) => {
                
                if(response.data.success){
                        this.ListOrder = [];
                        this.CashAmount = 0;
                        $('#ConfirmOrder').modal('hide');
                        this.GetProducts();

                        this.$swal({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 2000
                            });

                    // open new tab to print bill
                    // const billWindow = window.open(`${this.url}/api/bill/print/${response.data.bill_id}`, '_blank');
                    // billWindow.focus();
                    this.openLink(`${this.url}/api/bill/print/${response.data.bill_id}`);

                } else {
                     $('#ConfirmOrder').modal('hide');
                     this.$swal({
                                title: "ຜິດຜາດ!",
                                text: response.data.message,
                                icon: "error",
                        });
                   
                }

               
            }).catch((error) => {
                console.error('Error processing payment:', error);
                if(error && error.response.status === 401){
                    this.authStore.logout();
                    this.$router.push({ name: 'Login' });
                }
            });
        },
        AddNum(amount){
            this.CashAmount = parseFloat(this.CashAmount?this.CashAmount:0) + amount;
        },
        FormatPrice(value) {
             let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        AddOrder(item){
            // console.log(item);

            let exist = this.ListOrder.find(order => order.id === item.id);

            // check qty on ProductsList if qty = 0 alert and return
            let product = this.ProductsList.find(prod => prod.id === item.id);
            if(product && product.Qty <= 0){
                this.$swal("ສິນຄ້າຫມົດແລ້ວ!", "ບໍ່ສາມາດເພີ່ມສິນຄ້າໄດ້", "error");
                return;
            }
            
            // check existing item in ListOrder qty > qty in ProductsList alert and return
            if(exist && product && exist.Qty >= product.Qty){
                this.$swal("ບໍ່ສາມາດເພີ່ມສິນຄ້າໄດ້!", "ຈຳນວນສິນຄ້າໃນສາງບໍ່ພຽງພໍ", "error");
                return;
            }


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
        RemoveOrder(item){
            let exist = this.ListOrder.find(order => order.id === item.id);

            if(exist && exist.Qty > 1){
                exist.Qty -= 1;
            } else {
                this.DeleteOrder(item);
            }
        },
        DeleteOrder(item){
            this.$swal({
            title: "ທ່ານແນ່ໃຈບໍ່?",
            text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ແມ່ນ, ລຶບມັນ!",
            cancelButtonText: "ຍົກເລີກ"
            }).then((result) => {
            if (result.isConfirmed) {

                this.ListOrder = this.ListOrder.filter(order => order.id !== item.id);
            }
            });
        },
        ConfirmOrder(){
            // confirm order logic here
            $('#ConfirmOrder').modal('show');
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