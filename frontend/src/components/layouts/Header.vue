<template>
    <div class="navigation">
            <div class="container">
                <ul>
                    <li>
                        <a href="#"><img src="../../assets/RDA-Logo-Geo.png" style="width: 120px;"></a>
                    </li>
                    <li class="i">
                        <a href="javascript:void(0)" title="სისტემიდან გასვლა" v-on:click="LogOut()"><img src="../../assets/icons/log-out.svg"></a>
                    </li>
                    <li class="i" v-show="this.role == 2">
                        <a href="javascript:void(0)" v-on:click="this.$router.push('/farmer_check')">ფერმერის გადამოწმება</a>
                    </li>
                    <li class="i" v-show="this.role == 2">
                        <a href="javascript:void(0)" v-on:click="this.$router.push('/panel')">საჯარო რეესტრი</a>
                    </li>
                    <li class="i">
                        <a href="https://rda.gov.ge" target="_blank"><img src="../../assets/icons/home.svg"></a>
                    </li>
                </ul>
            </div>
        </div>
</template>

<script>
    import axios from "axios";

    export default {
        name : "HeaderNavigation",

        data() {
            return {
                role : ""
            }
        },

        methods: {
            async LogOut() {

                try {
                    await axios.post("http://api.farmer.rda.gov.ge/logout"); // გაიგზავნება მოთხოვნა სისტემიდან გამოსასვლელად
                    
                    this.$router.push("/"); // გადამისამართდება მთავარ (ავტორიზაციის) გვერდზე
                    window.localStorage.removeItem("loggedin");

                    console.clear(); // მოცემული ბრძანება გაასუფთავებს კონსოლის ფანჯარას არსებული შეტყობინებებისგან
                }catch(err) {
                    return false;
                }
            }
        },

        mounted() {
            let loggedin = window.localStorage.getItem("loggedin");

            if(!loggedin) this.$router.push("/");

            this.role = window.localStorage.getItem("role");
        },
    }
</script>

<style scoped lang="scss">
    @font-face {
        font-family: "frutiger_geo_regular";
        src: url("../../fonts/Linotype - Neue Frutiger Georgian Regular.otf");
    }

    @font-face {
        font-family: "frutiger_geo";
        src: url("../../fonts/Linotype - Neue Frutiger Georgian Black.otf");
    }

    .navigation {
        width: 100%;
        margin: 0;
        padding: 0;
        background-color: #fff;
        overflow: hidden;

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;

            li.i {
                float: right;

                a {
                    padding: 15px 18px;
                    display: block;
                    text-decoration: none;
                    text-align: center;
                    color: #202020;
                    font-family: "frutiger_geo_regular";

                    &:hover {
                        background-color: lighten(gray, 40);
                    }
                }
            }

            li {
                float: left;
            }
        }
    }
</style>