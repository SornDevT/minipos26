import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import Sidebar from './Components/Sidebar.vue';
import { createPinia } from 'pinia';

const pinia = createPinia();

const app = createApp(App);
app.component('sidebar', Sidebar);
app.use(router);
app.use(pinia);
app.mount('#app-vue');