<template>
    <div>
        <HeaderComponent />

        <div class="container mt-5">
            <div class="row gx-3 gy-4">
                <side-bar></side-bar>
                
                <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
                    <div class="container bg-white p-0 table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>სახელი</th>
                                    <th>ელ.ფოსტა</th>
                                    <th>როლი</th>
                                    <th>ქმედება</th>
                                </tr>
                            </thead>
                            <tbody class="p-2">
                                <tr v-for="(user_data, index) in users" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ user_data.name }}</td>
                                    <td>{{ user_data.email }}</td>
                                    <td>{{ user_data.role }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link class="btn btn-primary" :to="'/admin/user/edit/' + user_data.id"><BIconPencilSquare />&nbsp;&nbsp;რედაქტირება</router-link>
                                            <button type="button" class="btn btn-danger" :data-id="user_data.id" v-on:click="deleteUser($event)"><BIconTrash />&nbsp;&nbsp;წაშლა</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "../layouts/Header.vue";
    import SideBar from "../layouts/Sidebar.vue";
    import axios from "axios";

    export default {
        name : "AdminPanel",

        data() {
            return {
                users : []
            }
        },

        components : {
            HeaderComponent,
            SideBar
        },

        async mounted() {
            document.title = "dashboard";
            // axio რიქვესტის საშუალებით მოხდება მომხმარებლების სიის წამოღება ბაზიდან
            const users_list = await axios.get("http://api.farmer.rda.gov.ge/user/list", {
                headers : {
                    "Authorization" : `Bearer ${window.localStorage.getItem("token")}`
                }
            });

            this.users = users_list.data;

            const role = Number.parseInt(window.localStorage.getItem("role")); // ავტორიზირებული მომხმარებლის როლი
            if(role != 3) this.$router.back(); // თუ როლი არ დაემთხვა სუპერ ადმინისას ავტომატურად გადამისამართდება წინა გვერდზე
        },

        methods : {
            async deleteUser(event) {
                let id = event.target.getAttribute("data-id"); // ღილაკზე დაკლიკებისას წვდომა ხდება იმავე იუზერის აიდზე

                try {                
                    await axios.post("http://api.farmer.rda.gov.ge/user/delete/" + id, {}, {
                        headers : {
                            "Authorization" : `Bearer ${window.localStorage.getItem("token")}`
                        }
                    });

                    const users_list = await axios.get("http://api.farmer.rda.gov.ge/user/list", {
                        headers : {
                            "Authorization" : `Bearer ${window.localStorage.getItem("token")}`
                        }
                    });

                    this.users = users_list.data;
                }catch(err) {
                    console.log(err);
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .container {
        border-radius: 8px;
    }

    .btn, .nav-pills {
        font-family: "frutiger_geo_regular";
    }
</style>