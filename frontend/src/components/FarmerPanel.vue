<template>
    <div>
        <header-navigation></header-navigation>

        <div class="data-block container">
            <div class="forms">
                <form @submit.prevent="getData()">
                    <div class="form-group">
                        <label for="check">საჯარო რეესტრში შემოწმება</label>
                        <input type="text" placeholder="შეიყვანეთ პირადი ნომერი / საიდენტიფიკაციო კოდი ..." v-model="value">
                    </div><br>
                    <div class="form-group">
                        <button type="submit">ძებნა</button>
                    </div>
                </form>
            </div>
            <br>
            <div class="data">
                <center><div v-if="loading" class="spinner-border text-success"></div></center>
                <div v-for="item in data?.properties" :key="item">
                    <div class="contents">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>რეგისტრაციის თარიღი</td>
                                    <td>{{ item?.registered }}</td>
                                </tr>
                                <tr>
                                    <td>მიწის ნაკვეთის საკადასტრო კოდი</td>
                                    <td>{{ item?.cadastral }}</td>
                                </tr>
                                <tr>
                                    <td>მიწის ნაკვეთის ფართობი</td>
                                    <td>{{ item?.area + " კვ.მ " }} 
                                        <span v-if="item?.documented !== undefined">
                                            {{ `(ძველი მონაცემები: ${item?.documented} კვ.მ)` }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>მიწის ნაკვეთის საკუთრების სტატუსი</td>
                                    <td>{{ item?.ownership }}</td>
                                </tr>
                                <tr>
                                    <td>მიწის ნაკვეთის მესაკუთრეები</td>
                                    <td>
                                        <ul v-for="ownerships in item?.ownerships" :key="ownerships">
                                            <li v-if="ownerships?.company" v-html="''" id="hide"></li>
                                            
                                            <li v-else>
                                                <span v-show="ownerships?.personal != null">
                                                    {{ ownerships?.personal + ' - '}}
                                                </span>
                                                {{ ownerships?.firstname + ' ' + ownerships?.lastname }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>მიწის ნაკვეთის სტატუსი</td>
                                    <td>{{ item?.status }}</td>
                                </tr>
                                <tr>
                                    <td>მიწის ნაკვეთის კატეგორია</td>
                                    <td>{{ item?.category }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center"><p id="demo"></p></div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import HeaderNavigation from "./layouts/Header.vue";

    export default {
        data() {
            return {
                value : "",
                data : [],
                loading : ""
            }
        },

        components : {
            "header-navigation" : HeaderNavigation
        },

        methods : {
            async getData() {
                try {
                    this.loading = true; // ლოუდერის გამოჩენა

                    const res = await axios.post("http://api.farmer.rda.gov.ge/get_farmer", { personal : this.value.trim() }, {
                    headers : {
                        "Authorization" : `Bearer ${window.localStorage.getItem("token")}`
                    }
                });

                    this.data = res?.data?.data?.data;
                    
                    if(Number.parseInt(this.data.properties.length) == 0) {
                        document.getElementById("demo").innerHTML = "ინფორმაცია ვერ მოიძებნა";
                    }else {
                        document.getElementById("demo").innerHTML = "";
                    }
                    this.loading = false; // ლოუდერის გაქრობა
                }catch(err) {
                    this.loading = false; // ლოუდერის გაქრობა
                }
                
            },
        },

        mounted() {
            document.title = "საჯარო რეესტრში ძებნა";
            
            let loggedin = window.localStorage.getItem("loggedin");
            let role = window.localStorage.getItem("role");

            if(!loggedin) this.$router.push("/");

            if(role == 1) this.$router.push("/farmer_check");
        }
    }
</script>

<style scoped lang="scss">
    @font-face {
        font-family: "frutiger_geo_regular";
        src: url("../fonts/Linotype - Neue Frutiger Georgian Regular.otf");
    }

    @font-face {
        font-family: "frutiger_geo";
        src: url("../fonts/Linotype - Neue Frutiger Georgian Black.otf");
    }

    .contents {
        border: 3px solid #005019;
        padding: 6px;
        font-family: "frutiger_geo_regular";
        margin-top: 20px;
    }

    td {
        font-family: "frutiger_geo_regular";
    }

    td:last-child {
        margin-bottom: 0;
    }

    #hide {
        display: none !important;
    }

    label {
        color: #3c3c3c;
        font-family: "frutiger_geo";
    }

    .data-block {
        margin-top: 40px;
        background-color: #fff;
        padding: 20px;
        overflow: hidden;
        font-family: "frutiger_geo_regular";
    }

    input[type="text"] {
        width: 100%;
        height: 55px;
        padding: 0 15px;
        color: #3c3c3c;
        background-color: #f3f3f3;
        border: 1px solid transparent;
        border-radius: 4px;
        outline: none;
        margin-top: 10px;
        font-family: "frutiger_geo_regular";
    }

    button {
        width: 100%;
        height: 55px;
        padding: 0 15px;
        border: none;
        color: #005019;
        background-color: #82be00;
        text-transform: uppercase;
        font-weight: 900;
        cursor: pointer;
        border-radius: 4px;
        font-family: "frutiger_geo_caps" !important;
        font-size: 20px;

        &:hover {
            color: #fff;
            background-color: #005019;
        }
    }
</style>