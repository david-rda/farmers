<template>
    <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
        <div class="container p-3 bg-white">
            <ul class="d-flex flex-column nav nav-pills">
                <li class="nav-item mb-3">
                    <router-link class="nav-link" to="/admin/">Dashboard</router-link>
                </li>
                <li class="nav-item mb-3">
                    <router-link class="nav-link" to="/admin/user/add">მომხმარებლის დამატება</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/settings">პარამეტრები</router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name : "SideBar"
    }
</script>

<style scoped lang="scss">
    .nav-pills {
        border-radius: 4px;
        font-family: "frutiger_geo_regular";

        & * {
            color: #202020 !important;
        }

        & .nav-link {
            background-color: #F7F7F7;
            border-radius: 4px;

            &:hover {
                background-color: #104f27;
                color: #fff !important;
            }
        }
    }
</style>
