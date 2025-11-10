<template lang="">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-bottom pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">ໝວດໝູ່ສິນຄ້າ</h5>
                    <button type="button" class="btn rounded-pill btn-icon btn-primary" @click="AddCat()">
                     <i class='bx bx-plus'></i>
                    </button>
                </div>

                <div class="card-body p-0">
                    <!-- {{ CategoryList }} -->
               <div class="list-group list-group-flush">
                  
                  <a href="javascript:void(0);" v-for="category in CategoryList" :key="category.id" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <span>{{ category.CategoryName }}</span>
                            <div>
                                <i class='bx bx-edit me-2 fs-4 text-warning' @click="EditCat(category.id)"></i>  
                                <i class='bx bx-trash fs-4 text-danger' @click="DeleteCat(category.id)"></i>
                            </div>
                        </div>
                    </a>

                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-top fade" id="ModalAddCat" tabindex="-1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog">
                    <form class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="ModalAddCatTitle">
                          <span v-if="FormType"> ເພີ່ມໝວດໝູ່</span> 
                          <span v-else> ແກ້ໄຂໝວດໝູ່</span> 
                            </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col ">
                            <label for="nameSlideTop" class="form-label">ຊື່ໝວດໝູ່:</label>
                            <input type="text" v-model="CategoryName" id="nameSlideTop" class="form-control" placeholder="Enter Name">
                          </div>
                        </div>
                    
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="SaveCat()" >ບັນທຶກ</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ປິດ</button>
                        
                      </div>
                    </form>
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
            CategoryList:[],
            CategoryName:'',
            FormType: true,
            EditID:'',
        }
    },
    methods:{
        AddCat(){
            this.FormType = true;
            this.CategoryName = '';
            $('#ModalAddCat').modal('show');
        },
        EditCat(id){
            this.FormType = false;
            this.EditID = id;

            // get data category by id 
            // `/api/categories/${id}`  
            axios.get('/api/categories/' + id  ,{
                headers: {
                  Authorization: `Bearer ${this.authStore.getToken}`
                }
            }).then(response => {
                this.CategoryName = response.data.CategoryName;
                $('#ModalAddCat').modal('show');
            }).catch(error => {
                console.error('Error fetching category:', error);
            });
        },
        SaveCat(){

            if(this.FormType){
                // ເພີ່ມໝວດໝູ່
                axios.post('/api/categories/add', {
                    name: this.CategoryName
                },{
                    headers: {
                      Authorization: `Bearer ${this.authStore.getToken}`
                    }
                }).then(response => {
                    if(response.data.success){
                        $('#ModalAddCat').modal('hide');
                        this.CategoryName = '';
                        this.GetCat();
                    } else {
                        console.log('Failed to add category:', response.data.message);
                    }
                    

                }).catch(error => {
                    console.error('Error adding category:', error);
                });

            } else {
                // ແກ້ໄຂໝວດໝູ່

                axios.post('/api/categories/update/' + this.EditID, {
                    name: this.CategoryName
                },{
                    headers: {
                      Authorization: `Bearer ${this.authStore.getToken}`
                    }
                }).then(response => {
                    if(response.data.success){

                        $('#ModalAddCat').modal('hide');
                        this.CategoryName = '';
                        this.GetCat();

                    } else {
                        console.log('Failed to update category:', response.data.message);
                    }
                    

                }).catch(error => {
                    console.error('Error updating category:', error);
                });

            }

        },
        DeleteCat(id){
         
                // ລຶບໝວດໝູ່
                axios.delete('/api/categories/delete/' + id ,{
                    headers: {
                      Authorization: `Bearer ${this.authStore.getToken}`
                    }
                }).then(response => {
                    if(response.data.success){
                        this.GetCat();
                    } else {
                        console.log('Failed to delete category:', response.data.message);
                    }
                    

                }).catch(error => {
                    console.error('Error deleting category:', error);
                });
      
        },
        GetCat(){
            // ດຶງຂໍ້ມູນໝວດໝູ່
            axios.get('/api/categories',{
                headers: {
                  Authorization: `Bearer ${this.authStore.getToken}`
                }
            }).then(response => {
                this.CategoryList = response.data;
            }).catch(error => {
                console.error('Error fetching categories:', error);
            });
        }
    },
    created(){
        this.GetCat();
    }
}
</script>
<style lang="">
    
</style>