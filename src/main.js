import { createApp } from 'vue';
import App from './App.vue';
import { createRouter, createWebHistory } from "vue-router";
import { BIconPencilSquare, BIconTrash } from "bootstrap-icons-vue";
import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css';

import FarmerPanel from "./components/FarmerPanel.vue";
import LoginPanel from "./components/LoginPanel.vue";
import CheckFarmer from "./components/CheckFarmer.vue";
import NutsCadaster from "./components/Cadaster.vue";
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
    },
    {
        path : "/cadaster",
        component : NutsCadaster
    }
]

const router = createRouter({
    history : createWebHistory(),
    routes : routes
});

const app = createApp(App);

app.component("BIconPencilSquare", BIconPencilSquare);
app.component("BIconTrash", BIconTrash);

app.use(router);
app.use(VueSweetalert2);

app.mount('#app');