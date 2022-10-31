import { createApp } from 'vue';
import App from './App.vue';
import { createRouter, createWebHistory } from "vue-router";

import FarmerPanel from "./components/FarmerPanel.vue";
import LoginPanel from "./components/LoginPanel.vue";
import CheckFarmer from "./components/CheckFarmer.vue";
import MySettings from "./components/Settings.vue";
import AdminPanel from "./components/admin/Panel.vue";
import UserAdd from "./components/admin/users/UserAdd.vue";
import UserEdit from "./components/admin/users/UserEdit.vue";

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
    },
    {
        path : "/admin",
        component : AdminPanel,
    },
    {
        path : "/admin/user/add",
        component : UserAdd
    },
    {
        path : "/admin/user/edit/:id",
        component : UserEdit
    }
]

const router = createRouter({
    history : createWebHistory(),
    routes : routes
});

createApp(App).use(router).mount('#app')