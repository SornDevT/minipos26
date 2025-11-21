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
                <td> 
                    <img v-if="product.ImagePath" :src="url + '/assets/img/products/'+product.ImagePath" class="imgpro" > 
                    <img v-else :src="url + '/assets/img/no-img.jpg'" class="imgpro" > 
                </td>
                <td>{{ product.ProductName }}</td>
                <td>{{ product.CategoryName }}</td>
                <td class="text-center">{{ FormatPrice(product.Qty) }}</td>
                <td class="text-end">{{ FormatPrice(product.PriceBuy) }} ກີບ</td>
                <td class="text-end">{{ FormatPrice(product.PriceSell) }} ກີບ</td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" @click="EditProduct(product.id)"><i class="icon-base bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                    <a class="dropdown-item" href="javascript:void(0);" @click="DeleteProduct(product.id)"><i class="icon-base bx bx-trash me-1"></i> ລຶບ</a>
                  </div>
                </div>
              </td>
            </tr>
           
          </tbody>
        </table>
        <Pagination :pagination="ProductsList" :offset="4" @paginate="GetProducts($event)" />
      </div>
      <button @click="showAlert">Hello world</button>
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
                            <div class="col-lg-4" style="position: relative;">
                                <button type="button" v-if="FormProduct.ImagePath" class="btn rounded-pill btn-icon btn-danger" style="position: absolute; top: 5px; right: 18px;" @click="RemoveImage()">
                                    <i class='bx bx-x'></i>
                                    </button>
                                <img :src="ImagePreview" alt="Product Image" class="img-fluid mb-3" @click="$refs.uploadimg.click()" />
                                <input type="file" class="form-control mb-3" ref="uploadimg" style="display: none;" @change="onSelect($event)" />

                                <!-- <cleave v-model="cardNumber"
                :options="options"
                class="form-control"
                name="card"/> -->

                            </div>
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
                                        <cleave  :options="options" v-model="FormProduct.Qty" class="form-control text-end " placeholder="......"/> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">ລາຄາຊື້:<span class=" text-danger">*</span></label>
                                        <cleave  :options="options" v-model="FormProduct.PriceBuy" class="form-control text-end" placeholder="......"/>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">ລາຄາຂາຍ:<span class=" text-danger">*</span></label>
                                        <cleave  :options="options" v-model="FormProduct.PriceSell" class="form-control text-end" placeholder="......"/>
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
import Cleave from 'vue-cleave-component';

export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    },
    data() {
        return {
            url: window.location.origin,
            ImagePreview: window.location.origin + '/assets/img/upload_img.jpg',
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
            // cardNumber: null,
            options: {
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: '.',
                  delimiter: ','
                }
        }
    },
    components: {
        Cleave,
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
        showAlert() {
      // Use sweetalert2
      this.$swal({
        title: "The Internet?",
        text: "That thing is still around?",
        icon: "error",
        });
    },
    RemoveImage(){
        this.FormProduct.ImagePath = '';
        this.ImagePreview = window.location.origin + '/assets/img/upload_img.jpg';
    },
    onSelect(e){
        // console.log(e.target.files[0]);
        if(e.target.files.length > 0){
            const file = e.target.files[0];
            this.FormProduct.ImagePath = file;
            // console.log(file)
            // Preview Image
            this.ImagePreview = URL.createObjectURL(file);
        } else{
            this.FormProduct.ImagePath = '';
            this.ImagePreview = window.location.origin + '/assets/img/upload_img.jpg';
        }
    },
     FormatPrice(value) {
             let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
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
            this.formType = false;
            this.EditID = id;
            // fetch product details and populate FormProduct
            axios.get(`/api/products/${id}`, {
                headers: {
                    Authorization: `Bearer ${this.authStore.token}`
                }
            }).then((response) => {
                this.FormProduct = response.data;

                // update image preview
                if(this.FormProduct.ImagePath){
                    this.ImagePreview = this.url + '/assets/img/products/' + this.FormProduct.ImagePath;
                } else {
                    this.ImagePreview = this.url + '/assets/img/upload_img.jpg';
                }
                $('#StoreModal').modal('show');
            }).catch((error) => {
                console.error('Error fetching product details:', error);
                if(error && error.response.status === 401){
                    this.authStore.logout();
                    this.$router.push({ name: 'Login' });
                }
            });
        },
        SaveProduct(){
            // save product logic here
            if(this.formType){
                // add product logic here
                axios.post('/api/products/add', this.FormProduct , {  headers: { "Content-Type":"multipart/form-data",  Authorization: `Bearer ${this.authStore.getToken}` }
                }).then(response => {

                    if(response.data.success){
                           
                            console.log('Product added successfully:', response.data);
                            $('#StoreModal').modal('hide');
                            
                            this.GetProducts();

                            this.$swal({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 2000
                            });


                    } else {
                        $('#StoreModal').modal('hide');
                        // console.log('Failed to add product:', response.data.message);
                        this.$swal({
                                title: "ຜິດຜາດ!",
                                text: response.data.message,
                                icon: "error",
                        });
                    }
                    

                }).catch(error => {
                    console.error('Error adding product:', error);
                    if(error && error.response.status === 401){
                        this.authStore.logout();
                        this.$router.push({ name: 'Login' });
                    }
                }); 

            }else{
                // update product logic here
                axios.post(`/api/products/update/${this.EditID}`, this.FormProduct , {  headers: { "Content-Type":"multipart/form-data", Authorization: `Bearer ${this.authStore.getToken}` }
                }).then(response => {

                    if(response.data.success){
                           
                            console.log('Product updated successfully:', response.data);
                            $('#StoreModal').modal('hide');
                            this.GetProducts();

                             this.$swal({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 2000
                            });

                    } else {
                        $('#StoreModal').modal('hide');
                        // console.log('Failed to update product:', response.data.message);
                        this.$swal({
                                title: "ຜິດຜາດ!",
                                text: response.data.message,
                                icon: "error",
                        });
                    }
                    

                }).catch(error => {
                    console.error('Error updating product:', error);
                    if(error && error.response.status === 401){
                    this.authStore.logout();
                    this.$router.push({ name: 'Login' });
                }
                });
            }
        },
        DeleteProduct(id){
            // delete product logic here

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
          
                    axios.delete(`/api/products/delete/${id}`, {
                    headers: {
                        Authorization: `Bearer ${this.authStore.token}`
                    }
                }).then((response) => {
                    if(response.data.success){
                        console.log('Product deleted successfully:', response.data);
                        this.GetProducts();
                        this.$swal({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                    } else {
                        // console.log('Failed to delete product:', response.data.message);
                        this.$swal({
                                title: "ຜິດຜາດ!",
                                text: response.data.message,
                                icon: "error",
                        });
                    }
                }).catch((error) => {
                    console.error('Error deleting product:', error);
                    if(error && error.response.status === 401){
                        this.authStore.logout();
                        this.$router.push({ name: 'Login' });
                    }
                });

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
<style>
    .imgpro{
        width: 80px;
    height: 80px;
    object-fit: cover;
    object-position: center;
    border-radius: 5px;
    border: 1px solid #bbbbbc;
    padding: 3px;
    }
</style>