<template>
    <div>
        <div class="header-logo">
            <img src="../assets/RDA-Logo-Geo.png" />
        </div>
        <br>
        <div class="login-form d-flex justify-content-center">
            <form @submit.prevent="Login_To_Panel()">
                <div class="form-group">
                    <label for="email">ელფოსტა</label>
                    <input type="email" v-model="email" id="email" v-bind:class="(email_validate == 1) ? 'error' : ''">
                </div><br>
                <div class="form-group">
                    <label for="password">პაროლი</label>
                    <input type="password" v-model="password" id="password" v-bind:class="(password_validate == 1) ? 'error' : ''">
                </div>
                <br>
                <div class="form-group">
                    <button type="submit">შესვლა</button>
                </div>
            </form>
            <br>
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

                    axios.post("http://localhost:8000/login", {
                        email : this.email,
                        password : this.password
                    }).then((response) => {
                        let role = response.data.role;
                        let id = response.data.id;

                        window.localStorage.setItem("role", role); // მომხმარებლის როლი
                        window.localStorage.setItem("id", id); // მომხმარებლის აიდი

                        if(Number.parseInt(role) === 1) {
                            this.$router.push("/farmer_check");
                            window.localStorage.setItem("loggedin", true);
                        }else if(Number.parseInt(role) === 2) {
                            this.$router.push("/panel");
                            window.localStorage.setItem("loggedin", true);
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
        }
    }
</script>

<style scoped>
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

    @media screen and (max-width: 768px) {
        .login-form {
            margin: 20px;
            margin-left: 30px;
        }

        .header-logo > img {
            margin-right: 50px;
        }
    }

    @media only screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) {
        .login-form {
            margin: 20px;
            margin-left: 30px;
        }
    }

    * {
        font-family: "frutiger_geo";
        box-sizing: border-box;
    }

    .login-form {
        margin-right: 140px !important;
    }

    .header-logo {
        width: 100% !important;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 100px;
    }

    .header-logo > img {
        width: 250;
        height: 100px;
        margin-left: 40px !important;
    }

    label {
        color: #3c3c3c;
    }

    input[type="email"], input[type="password"] {
        width: 150%;
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

    button {
        width: 150%;
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