import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import Sidebar from './Components/Sidebar.vue';
import { createPinia } from 'pinia';
import Pagination from './Components/Pagination.vue';
import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar';
import 'vue3-perfect-scrollbar/style.css';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const pinia = createPinia();

const app = createApp(App);
app.use(PerfectScrollbarPlugin);
app.component('sidebar', Sidebar);
app.use(router);
app.use(pinia);
app.component('Pagination', Pagination);
app.use(VueSweetalert2);
app.mount('#app-vue');