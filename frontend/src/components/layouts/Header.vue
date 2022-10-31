<template>
    <div>
        <div v-bind:class="this.layer_show ? 'layer' : ''" @click="closeNav"></div>
        <nav v-bind:class="this.sidenav_show ? 'sideNav mg' : 'none'">
            <ul>
                <li>
                    <a href="https://rda.gov.ge">მთავარი</a>
                </li>
                <li v-show="this.role == 2 || this.role == 3">
                    <router-link to="/farmer_check">ფერმერის გადამოწმება</router-link>
                </li>
                <li v-show="this.role == 2 || this.role == 3">
                    <router-link to="/panel">საჯარო რეესტრი</router-link>
                </li>
                <li>
                    <router-link to="/settings" title="პარამეტრები">
                        <span>პარამეტრები</span>
                    </router-link>
                </li>
                <li>
                    <a href="javascript:void(0)" title="სისტემიდან გასვლა" v-on:click="LogOut()">
                        <span>გასვლა</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="navigation">
            <div class="container">
                <ul>
                    <li>
                        <router-link to="/">
                            <img src="../../assets/RDA-Logo-Geo.png" style="width: 120px;">
                        </router-link>
                    </li>
                    <li class="burger-menu">
                        <a href="javascript:void(0)" v-on:click="openSideNav()">
                            <img src="../../assets/icons/burger-menu.svg">
                        </a>
                    </li>
                    <li class="i">
                        <a href="javascript:void(0)" title="სისტემიდან გასვლა" v-on:click="LogOut()">
                            <img src="../../assets/icons/log-out.svg">
                        </a>
                    </li>
                    <li class="i">
                        <router-link to="/settings" title="პარამეტრები">
                            <img src="../../assets/icons/settings.png">
                        </router-link>
                    </li>
                    <li class="i" v-show="this.role == 3">
                        <router-link to="/admin">ადმინ პანელი</router-link>
                    </li>
                    <li class="i" v-show="this.role == 2 || this.role == 3">
                        <router-link to="/farmer_check">ფერმერის გადამოწმება</router-link>
                    </li>
                    <li class="i" v-show="this.role == 2 || this.role == 3">
                        <router-link to="/panel">საჯარო რეესტრი</router-link>
                    </li>
                    <li class="i">
                        <a href="https://rda.gov.ge" target="_blank">
                            <img src="../../assets/icons/home.svg">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name : "HeaderNavigation",

        data() {
            return {
                role : "",
                layer_show : false,
                sidenav_show : false
            }
        },

        methods: {
            async LogOut() {
                try {
                    await axios.post("http://api.farmer.rda.gov.ge/logout"); // გაიგზავნება მოთხოვნა სისტემიდან გამოსასვლელად
                    
                    this.$router.push("/"); // გადამისამართდება მთავარ (ავტორიზაციის) გვერდზე
                    window.localStorage.removeItem("loggedin");
                    window.localStorage.removeItem("role"); // ავტორიზირებული მომხმარებლის როლის შენახვა
                    window.localStorage.removeItem("id"); // ავტორიზირებული მომხმარებლის აიდის შენახვა
                    window.localStorage.removeItem("token"); // access ტოკენის წაშლა სტორიჯიდან

                    console.clear(); // მოცემული ბრძანება გაასუფთავებს კონსოლის ფანჯარას არსებული შეტყობინებებისგან
                }catch(err) {
                    return false;
                }
            },

            openSideNav() {
                this.layer_show = true;
                this.sidenav_show = true;
            },

            closeNav() {
                this.layer_show = false;
                this.sidenav_show = false;
            }
        },

        mounted() {
            let loggedin = window.localStorage.getItem("loggedin");

            if(!loggedin) this.$router.push("/");

            this.role = window.localStorage.getItem("role");
            console.log(this.role);
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

    .burger-menu {
        display: none;
    }

    .layer {
        position: fixed;
        overflow: hidden;
        margin: 0;
        padding: 0;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(#202020, 0.5);
    }

    @-webkit-keyframes sidenav {
        from {margin-left: -250px;}
        to {margin-left: 0px;}
    }

    @-o-keyframes sidenav {
        from {margin-left: -250px;}
        to {margin-left: 0px;}
    }

    @-ms-keyframes sidenav {
        from {margin-left: -250px;}
        to {margin-left: 0px;}
    }

    @-moz-keyframes sidenav {
        from {margin-left: -250px;}
        to {margin-left: 0px;}
    }

    @keyframes sidenav {
        from {margin-left: -250px;}
        to {margin-left: 0px;}
    }

    .sideNav {
        width: 60%;
        height: 100%;
        margin: 0;
        top: 0;
        margin-left: -250px;
        position: fixed;
        overflow: hidden;
        background-color: #fff;
        -webkit-animation: sidenav 0.3s;
        -o-animation: sidenav 0.3s;
        -ms-animation: sidenav 0.3s;
        -moz-animation: sidenav 0.3s;
        animation: sidenav 0.3s;
        display: block !important;

        ul {
            margin: 0;
            padding: 0;

            li {
                text-align: center;

                a {
                    display: block;
                    padding: 12px 14px;
                    text-decoration: none;
                    font-family: "frutiger_geo_regular";
                    color: #202020;

                    &:hover {
                        background-color: lightgray;
                    }
                }
            }
        }
    }

    .none {
        display: none !important;
    }

    .mg {
        margin-left: 0px;
    }

    @media screen and (max-width: 768px) {
        li.i {
            display: none;
        }

        .burger-menu {
            display: block;
            float: right !important;
            padding: 10px;

            &:hover {
                background-color: lightgray;
            }
        }
    }
</style>