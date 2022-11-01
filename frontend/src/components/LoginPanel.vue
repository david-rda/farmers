<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-xs-12 col-sm-12 offset-md-3 offset-lg-3">
                <div class="header-logo">
                    <img src="../assets/RDA-Logo-Geo.png" />
                </div>
                <form @submit.prevent="Login_To_Panel()">
                    <div class="mb-3">
                        <label for="email">ელ.&nbsp;ფოსტა</label>
                        <input type="email" v-model="email" id="email" class="form-control" v-bind:class="(email_validate == 1) ? 'error' : ''">
                    </div>
                    <div class="mb-3">
                        <label for="password">პაროლი</label>
                        <input type="password" v-model="password" id="password" class="form-control" v-bind:class="(password_validate == 1) ? 'error' : ''">
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit">შესვლა</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="error-block" v-if="show">
            <span>ელფოსტა ან პაროლი არასწორია</span>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                email : "",
                password : "",
                show : false,
                loading : true,

                email_validate : 0,
                password_validate : 0
            }
        },

        methods : {
            Login_To_Panel : function() {
                if(this.email.length == 0 || this.email == "") {
                    this.email_validate = 1;
                }else if(this.password.length == 0 || this.password == "") {
                    this.password_validate = 1;
                    this.email_validate = 0;
                }else {
                    this.password_validate = 0;
                    this.email_validate = 0;

                    axios.post("http://api.farmer.rda.gov.ge/login", {
                        email : this.email,
                        password : this.password
                    }).then((response) => {
                        let role = response.data.role;
                        let id = response.data.id;
                        let token = response.data.token;

                        window.localStorage.setItem("role", role); // მომხმარებლის როლი
                        window.localStorage.setItem("id", id); // მომხმარებლის აიდი
                        window.localStorage.setItem("token", token);
                        window.localStorage.setItem("loggedin", true);

                        if(Number.parseInt(role) === 1) {
                            this.$router.push("/farmer_check");
                        }else if(Number.parseInt(role) === 2) {
                            this.$router.push("/panel");
                        }else if(Number.parseInt(role) === 3) {
                            this.$router.push("/admin");
                        }

                    }).catch((err) => {
                        this.$router.push("/");
                        window.localStorage.removeItem("loggedin");
                        this.show = true;

                        setTimeout(() => {
                            this.show = false;
                        }, 3000);
                    });
                }
            }
        },

        mounted() {
            document.title = "სისტემაში შესვლა";
            
            let loggedin = window.localStorage.getItem("loggedin");
            let role = window.localStorage.getItem("role");

            if(!loggedin) this.$router.push("/");

            if(loggedin && role == 1) this.$router.push("/farmer_check");
            if(loggedin && role == 2) this.$router.push("/panel");
            if(loggedin && role == 3) this.$router.push("/admin");
        }
    }
</script>

<style scoped >
    /**
        ღია მწვანე: #82be00
        მუქი მწვანე: #005019
        background : #F3F3F3
        font #3c3c3c
    */
    @font-face {
        font-family: "frutiger_geo";
        src: url("../fonts/Linotype - Neue Frutiger Georgian Black.otf");
    }

    @font-face {
        font-family: "frutiger_geo_regular";
        src: url("../fonts/Linotype - Neue Frutiger Georgian Regular.otf");
    }

    @font-face {
        font-family: "frutiger_geo_caps";
        src: url("../fonts/NeueFrutigerGeorgianCAPS-Black.ttf");
    }

    * {
        font-family: "frutiger_geo";
        box-sizing: border-box;
    }

    .header-logo {
        width: 100% !important;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 100px;
    }

    .header-logo > img {
        height: 100px;
        margin-left: 40px !important;
    }

    label {
        color: #3c3c3c;
    }

    input[type="email"], input[type="password"] {
        height: 55px;
        padding: 0 15px;
        color: #3c3c3c;
        background-color: #ffffff;
        border: 1px solid transparent;
        border-radius: 4px;
        outline: none;
        font-family: "frutiger_geo_regular";
        margin-top: 10px;
    }

    .form-control:focus {
        box-shadow: none !important;
        outline: none !important;
    }

    button {
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
    }

    button:hover {
        background-color: #005019;
        color: #fff;
    }

    .error {
        border: 1px solid #d9534f !important;
    }

    .success {
        border: 1px solid #2a8b37 !important;
    }

    @-webkit-keyframes fade {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    @-o-keyframes fade {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    @-ms-keyframes fade {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    @-moz-keyframes fade {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    @keyframes fade {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    .error-block {
        padding: 20px;
        background-color: #d9534f;
        position: absolute;
        top: 0;
        right: 0;
        margin: 20px;
        border-radius: 4px;
        color: #fff;
        -webkit-animation: fade 0.5s;
        -o-animation: fade 0.5s;
        -ms-animation: fade 0.5s;
        -moz-animation: fade 0.5s;
        animation: fade 0.5s;
    }
</style>