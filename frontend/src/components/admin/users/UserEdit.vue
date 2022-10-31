<template>
    <div>
        <HeaderComponent />

        <div class="container mt-5">
            <div class="row gx-3 gy-4">
                <SideBar />

                <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
                    <div class="container p-3 bg-white">
                        <form method="POST" @submit.prevent="editUser()">
                            <div class="mb-3">
                                <label for="name" class="mb-2">სახელი</label>
                                <input type="text" name="name" id="name" v-model="this.name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="mb-2">ელ.&nbsp;ფოსტა</label>
                                <input type="text" name="email" id="email" v-model="this.email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="mb-2">პაროლი</label>
                                <input type="password" name="password" id="password" v-model="this.password">
                            </div>
                            <div class="mb-3">
                                <label for="role" class="mb-2">როლი</label>
                                <select v-model="this.role" id="role" name="role">
                                    <option value="1">მომხმარებელი</option>
                                    <option value="2">ადმინი</option>
                                    <option value="3">სუპერ ადმინი</option>
                                </select>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit">რედაქტირება</button>
                            </div>
                            <div class="d-grid text-center">
                                <div class="message" v-if="success">
                                    <p>{{ message }}</p>
                                </div>
                            </div>
                            <div class="d-grid text-center">
                                <div class="message_error" v-if="error">
                                    <p v-for="(item, index) in message" :key="index">
                                        <span>{{ item[0] }}</span>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "../../layouts/Header.vue";
    import SideBar from "../../layouts/Sidebar.vue";
    import axios, { AxiosError } from "axios";

    export default {
        name : "UserEdit",

        data() {
            return {
                name : "",
                email : "",
                password : "",
                role : "",

                message : "",

                success : false,
                error : false
            }
        },

        components : {
            HeaderComponent,
            SideBar
        },

        async mounted() {
            let id = this.$route.params.id; // მომხმარებლის აიდი

            const data = await axios.get("http://api.farmer.rda.gov.ge/user/get/" + id, {
                headers : {
                    "Authorization" : `Bearer ${window.localStorage.getItem("token")}`
                }
            });

            this.name = data.data.name;
            this.email = data.data.email;
            this.password = data.data.password;
            this.role = data.data.role;
        },

        methods : {
            async editUser() {
                try {
                    const data = await axios.post("http://api.farmer.rda.gov.ge/user/edit/" + this.$route.params.id, {
                        name : this.name,
                        email : this.email,
                        password : (this.password != "") ? this.password : "",
                        role : this.role
                    }, {
                        headers : {
                            "Authorization" : `Bearer ${window.localStorage.getItem("token")}`
                        }
                    });

                    this.success = true;
                    this.error = false;

                    this.message = data.data.message;
                }catch(err) {
                    if(err instanceof AxiosError) {
                        this.success = false;
                        this.error = true;
                        this.message = err.response.data.errors;
                    }
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    button, input, label, option, select {
        font-family: "frutiger_geo_regular";
    }

    button[type="submit"] {
        background-color: #82be00;
        color: #104f27;
        font-family: "frutiger_geo_caps";
        padding: 15px 18px;
        border: none;
        outline: none;
        border-radius: 4px;
        
        &:hover {
            background-color: #104f27;
            color: #fff;
        }
    }

    input, select {
        padding: 15px 18px;
        width: 100%;
        border: none;
        background-color: #F7F7F7;
        outline: none;
        border-radius: 4px;
        color: #3c3c3c;
    }

    .message {
        padding: 10px 18px;
        color: #fff;
        font-family: "frutiger_geo_regular";
        border-radius: 4px;
        background-color: #104f27;
    }

    .message_error {
        padding: 10px 18px;
        color: #fff;
        font-family: "frutiger_geo_regular";
        border-radius: 4px;
        background-color: #d9534f;
    }
</style>