<template>
    <div>
        <header-navigation></header-navigation>

        <div v-if="show" class="notify">
            <p>{{ this.message }}</p>
        </div>

        <div v-if="show_err" class="notify_error">
            <p>{{ this.message }}</p>
        </div>

        <div v-if="this.errors != false" class="notify_error">
            <p v-html="this.errors.errors?.current_password" v-show="this.errors.errors?.current_password"></p>
            <p v-html="this.errors.errors?.new_password" v-show="this.errors.errors?.new_password"></p>
        </div>

        <div class="container settings-block">
            <form method="post" @submit.prevent="Change_Password()">
                <table>
                    <tbody>
                        <tr>
                            <label for="current">მიმდინარე პაროლი</label>
                        </tr>
                        <tr>
                            <input type="password" v-model="current_password" id="current" name="current">
                        </tr>
                        <br>
                        <tr>
                            <label for="new">ახალი პაროლი</label>
                        </tr>
                        <tr>
                            <input type="password" v-model="new_password" id="new" name="new">
                        </tr>
                        <br>
                        <tr>
                            <button type="submit">შეცვლა</button>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</template>

<script>
    import HeaderNavigation from "./layouts/Header.vue";
    import axios, { Axios, AxiosError } from "axios";

    export default {
        name : "MySettings",

        components : {
            "header-navigation" : HeaderNavigation
        },

        data() {
            return {
                current_password : "",
                new_password : "",
                show : false,
                message : "",
                errors : false,
                show_err : false
            }
        },

        methods: {
            Change_Password : async function() {
                try {
                    const change = await axios.post("http://api.farmer.rda.gov.ge/change_password", {
                        current_password : this.current_password.trim(),
                        new_password : this.new_password.trim(),
                        id : Number.parseInt(window.localStorage.getItem("id"))
                    });

                    if(change.data.changed) {
                        this.show = true;
                        this.message = change.data.message;

                        setTimeout(() => {
                            this.show = false;
                        }, 3000);
                    }
                }catch(err) {
                    if(err instanceof AxiosError) {
                        this.errors = err?.response?.data;

                        setTimeout(() => {
                            this.errors = false;
                        }, 6000);

                        if(err?.response?.data?.changed === false) {
                            this.show_err = true;
                            this.message = err?.response?.data?.message;

                            setTimeout(() => {
                                this.show_err = false;
                            }, 3000);
                        }
                    }
                }
            }
        },

        mounted() {
            document.title = "პაროლის ცვლილება";

            let loggedin = window.localStorage.getItem("loggedin");

            if(!loggedin) this.$router.push("/");
        },
    }
</script>

<style scoped lang="scss">
    @font-face {
        font-family: "frutiger_geo_regular";
        src: url("../fonts/Linotype - Neue Frutiger Georgian Regular.otf");
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

    * {
        box-sizing: border-box;
        font-family: "frutiger_geo_regular";
    }

    .settings-block {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        align-content: center;
        background-color: #fff;
        border-radius: 4px;
        padding: 30px;
    }

    @media screen and(max-width: 768px) {
        .settings-block {
            table {
                margin-left: -100px !important;
            }
        }
    }

    input[type="password"] {
        width: 150%;
        height: 55px;
        padding: 0 15px;
        color: #3c3c3c;
        background-color: #f3f3f3;
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

        &:hover {
            background-color: #005019;
            color: #fff;
        }
    }

    .notify {
        padding: 10px;
        background-color: lighten(#005019, 15%);
        color: #fff;
        position: absolute;
        top: 0;
        right: 0;
        margin: 40px;
        border-radius: 4px;
        -webkit-animation: fade 0.5s;
        -o-animation: fade 0.5s;
        -ms-animation: fade 0.5s;
        -moz-animation: fade 0.5s;
        animation: fade 0.5s;

        p {
            padding-top: 10px;
        }
    }

    .notify_error {
        padding: 10px;
        background-color: #d9534f;
        color: #fff;
        position: absolute;
        top: 0;
        right: 0;
        margin: 40px;
        margin-top: 50px;
        border-radius: 4px;
        -webkit-animation: fade 0.5s;
        -o-animation: fade 0.5s;
        -ms-animation: fade 0.5s;
        -moz-animation: fade 0.5s;
        animation: fade 0.5s;

        p {
            padding-top: 10px;
        }
    }
</style>