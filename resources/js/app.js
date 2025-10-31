import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import Sidebar from './Components/Sidebar.vue';

const app = createApp(App);
app.component('sidebar', Sidebar);
app.use(router);
app.mount('#app-vue');