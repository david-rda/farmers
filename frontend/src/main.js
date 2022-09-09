import { createApp } from 'vue';
import App from './App.vue';
import { createRouter, createWebHistory } from "vue-router";

import FarmerPanel from "./components/FarmerPanel.vue";
import LoginPanel from "./components/LoginPanel.vue";
import CheckFarmer from "./components/CheckFarmer.vue";
import MySettings from "./components/Settings.vue";

const routes = [
    {
        path : "/",
        component : LoginPanel
    },
    {
        path : "/panel",
        component : FarmerPanel
    },
    {
        path : "/farmer_check",
        component : CheckFarmer
    },
    {
        path : "/settings",
        component : MySettings
    }
]

const router = createRouter({
    history : createWebHistory(),
    routes : routes
});

createApp(App).use(router).mount('#app')