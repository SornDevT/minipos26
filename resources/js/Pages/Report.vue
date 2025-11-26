<template lang="">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
    <h5 class="card-header">ລາຍງານ</h5>
    <div class="card-body">

        <div class="d-flex justify-content-between">
            <div class=" d-flex align-items-center mb-3">
          
            </div>
            <div class="  mb-3 d-flex justify-content-end align-items-center">
                
                <div class="btn-group me-2" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary" @click="month_type = 'm'"><i class='bx bx-chevron-right' v-if="month_type === 'm'"></i> ເດືອນ</button>
                  <button type="button" class="btn btn-secondary" @click="month_type = 'y'"><i class='bx bx-chevron-right' v-if="month_type === 'y'"></i> ປີ</button>
                </div>
                <input type="date" v-model="dmy" class="form-control w-auto" />  
            </div>
        </div> 

        <LineChart :chart-data="chdata" :options="choption" />
      
      </div>

    </div>

    </div>
        <div class="col-lg-4">

            <div class="card mb-4">
                    <div class="card-body">
                        <div class=" d-flex justify-content-between">
                            <span> <i class='bx bx-download fs-4'></i> <br> ລາຍຮັບ </span>
                            <span> {{ FormatPrice(sum_income) }} ກີບ </span>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class=" d-flex justify-content-between">
                            <span> <i class='bx bx-trending-down fs-4'></i> <br> ລາຍຈ່າຍ </span>
                            <span> {{  FormatPrice(sum_expense)  }} ກີບ </span>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class=" d-flex justify-content-between">
                            <span> <i class='bx bxs-objects-vertical-bottom fs-4'></i> <br> ກຳໄລ </span>
                            <span> {{ FormatPrice(sum_income-sum_expense) }} ກີບ </span>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</template>
<script>


import { LineChart } from 'vue-chart-3';

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);


import { useAuthStore } from '../Stores/Auth';
import axios from 'axios';
export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    },
    data() {
        return {
            sum_income:0,
            sum_expense:0,
            month_type:"m",
            dmy: new Date().toISOString().substr(0, 10),
            testData: {
                labels: ['Paris', 'Nîmes', 'Toulon', 'Perpignan', 'Autre'],
                datasets: [
                        {
                        data: [30, 40, 60, 70, 5],
                        backgroundColor: ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
                        },
                    ],
                },
                chdata:{},
                choption:{
                plugins:{
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                            return (
                                Number(tooltipItem.raw) .toFixed(0) .replace(/./g, function (c, i, a) { return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c; }) + " ກີບ" );
                            },
                        },
                        mode: "index",
                        intersect: false,
                        },
              },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y:{
                            ticks: {
                                display: true,
                                beginAtZero: false,
                                callback: function (value, index, values) {
                                return ( Number(value) .toFixed(0) .replace(/./g, function (c, i, a) { return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c; }) + " ກີບ" );
                                },
                            },
                            gridLines: {
                                show: true,
                            },
                            },
                    },
                    
            },

        }
    },
    components:{
        LineChart
    },
    methods: {
        FormatPrice(value) {
             let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        GetReport(){
            axios.get(`/api/report?dmy=${this.dmy}&month_type=${this.month_type}`,{
                headers: {
                    Authorization: `Bearer ${this.authStore.token}`,
                },
            }).then((response)=>{
                

                this.chdata = {
                        labels: response.data.labels,
                        datasets:[
                            {
                                label: "ລາຍຮັບ",
                                fill: false,
                                borderColor: "#3fc3ee",
                                data: response.data.income,
                                backgroundColor: "#9BD0F5"
                            },
                            {
                                label: "ລາຍຈ່າຍ",
                                fill: false,
                                borderColor: "#f1556c",
                                data: response.data.expense,
                                backgroundColor: "#FFB1C1"
                            }
                        ]

                    };

                    this.sum_income = response.data.sum_income;
                    this.sum_expense = response.data.sum_expense;



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
        this.GetReport();
    },
    watch: {
        dmy(newVal, oldVal) {
            this.GetReport();
        },
        month_type(newVal, oldVal) {
            this.GetReport();
        }
    }
}
</script>
<style lang="">
    
</style>