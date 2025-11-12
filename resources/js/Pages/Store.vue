<template lang="">
    <div class="card">
    <h5 class="card-header">ລາຍການສິນຄ້າ</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 d-flex align-items-center mb-3">
                <div class="me-2" @click="Sort = (Sort === 'asc') ? 'desc' : 'asc'; GetProducts(); " style="cursor: pointer;">
                    <i class='bx bx-sort-up fs-4' v-if="Sort === 'asc'"></i>
                    <i class='bx bx-sort-down fs-4' v-else></i>
                </div>
                <select class="form-select w-auto me-2" v-model="PerPage" @change="GetProducts()">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>

                <select class="form-select w-auto" v-model="CategorySelect" @change="GetProducts()">
                    <option value="all">ໝວດໝູ່ທັງໝົດ</option>
                    <option :value="category.id" v-for="category in CategoryList" :key="category.id">{{ category.CategoryName }}</option>
                </select>

            </div>
            <div class="col-lg-6 mb-3 d-flex justify-content-end align-items-center">
                <div class="input-group input-group-merge w-auto me-2">
                    <input type="text" v-model="Search" class="form-control w-auto" placeholder="ຄົ້ນຫາ..." @keyup.enter="GetProducts()" />
                    <span class="input-group-text" id="basic-addon-search31"><i class="icon-base bx bx-search"></i></span>
                </div>
                <button type="button" class="btn btn-primary" @click="AddProduct()" >ເພີ່ມໃໝ່</button>
            </div>
        </div> 
        <!-- {{ CategoryList }} -->
      <div class="table-responsive text-nowrap"> 
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>ຮູບພາບ</th>
              <th>ຊື່ສິນຄ້າ</th>
              <th>ໝວດໝູ່</th>
              <th>ຈຳນວນ</th>
              <th>ລາຄາຊື້</th>
              <th>ລາຄາຂາຍ</th>
              <th>ຈັດການ</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in ProductsList.data" :key="product.id">
              
                <td>{{product.id}} </td>
                <td></td>
                <td>{{ product.ProductName }}</td>
                <td>{{ product.CategoryName }}</td>
                <td>{{ product.Qty }}</td>
                <td>{{ product.PriceBuy }}</td>
                <td>{{ product.PriceSell }}</td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
           
          </tbody>
        </table>
        <Pagination :pagination="ProductsList" :offset="4" @paginate="GetProducts($event)" />
      </div>
    </div>
  </div>

  <div class="modal modal-top fade" id="StoreModal" tabindex="-1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <form class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTopTitle">
                            <span>ເພີ່ມສິນຄ້າໃໝ່</span>
                            <span>ແກ້ໄຂສິນຄ້າ</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-4">Image</div>
                            <div class="col-lg-8">
                                   <div class="row">
                                    <div class="col-lg-8 mb-3">
                                        <label class="form-label">ຊື່ສິນຄ້າ:<span class=" text-danger">*</span> </label>
                                        <input type="text" v-model="FormProduct.ProductName" class="form-control" placeholder="......">
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label class="form-label">ໝວດໝູ່:<span class=" text-danger">*</span></label>
                                        <select class="form-select" v-model="FormProduct.CategoryID">
                                            <option :value="category.id" v-for="category in CategoryList" :key="category.id">{{ category.CategoryName }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <label class="form-label">ຈຳນວນ:<span class=" text-danger">*</span></label>
                                        <input type="number" v-model="FormProduct.Qty" class="form-control" placeholder="......"> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">ລາຄາຊື້:<span class=" text-danger">*</span></label>
                                        <input type="number" v-model="FormProduct.PriceBuy" class="form-control" placeholder="......">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">ລາຄາຂາຍ:<span class=" text-danger">*</span></label>
                                        <input type="number" v-model="FormProduct.PriceSell" class="form-control" placeholder="......">
                                    </div>
                                </div>
                            </div>
                        </div>

                     
           
                      </div>
                      <div class="modal-footer"> 
                          <button type="button" class="btn btn-primary me-2" :disabled="isFormvalidate" @click="SaveProduct()">ບັນທຶກ</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ຍົກເລີກ</button>
                      
                      </div>
                    </form>
                  </div>
                </div>

</template>
<script>
import { useAuthStore } from '../Stores/Auth';
import axios from 'axios';
import Category from './Category.vue';

export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    },
    data() {
        return {
            CategoryList: [],
            ProductsList: [],
            formType: true,
            EditID: '',
            FormProduct: {
                ProductName: '',
                CategoryID: '',
                ImagePath: '',
                Qty: 0,
                PriceBuy: 0,
                PriceSell: 0,
            },
            Sort: 'asc',
            PerPage: 10,
            CategorySelect: 'all',
            Search: '',
        }
    },
    computed: {
        isFormvalidate() {
            if(this.FormProduct.ProductName == "" || this.FormProduct.CategoryID == "" || this.FormProduct.Qty <= 0 || this.FormProduct.PriceBuy <= 0 || this.FormProduct.PriceSell <= 0){
                return true;
            } else {
                return false;
            }
        }  
    },
    methods: {
        AddProduct(){
             this.FormProduct = {
                                ProductName: '',
                                CategoryID: '',
                                ImagePath: '',
                                Qty: 0,
                                PriceBuy: 0,
                                PriceSell: 0,
                            };
            this.formType = true;

            $('#StoreModal').modal('show');
        },
        EditProduct(id){
            // edit product logic here
        },
        SaveProduct(){
            // save product logic here
            if(this.formType){
                // add product logic here
                axios.post('/api/products/add', this.FormProduct , {  headers: { Authorization: `Bearer ${this.authStore.getToken}` }
                }).then(response => {

                    if(response.data.success){
                           
                            console.log('Product added successfully:', response.data);
                            $('#StoreModal').modal('hide');
                            this.GetProducts();
                    } else {
                        console.log('Failed to add product:', response.data.message);
                    }
                    

                }).catch(error => {
                    console.error('Error adding product:', error);
                }); 

            }else{
                // update product logic here
            }
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
                console.error('Error fetching categories:', error);
            });
        }
    },
    created() {
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
<style lang="">
    
</style>