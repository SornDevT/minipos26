import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import Sidebar from './Components/Sidebar.vue';
import { createPinia } from 'pinia';
import Pagination from './Components/Pagination.vue';

const pinia = createPinia();

const app = createApp(App);
app.component('sidebar', Sidebar);
app.use(router);
app.use(pinia);
app.component('Pagination', Pagination);
app.mount('#app-vue');