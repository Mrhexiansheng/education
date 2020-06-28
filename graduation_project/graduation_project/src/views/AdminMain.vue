<template>
    <div class="around">
        <el-container>
            <el-aside width="200px">
                <el-menu>
                    <el-submenu :index="item.name" v-for="item in routeData" :key="item.name">
                        <template #title>
                            <i class="el-icon-apple"></i>
                            <span>{{item.meta.title}}</span>
                        </template>
                        <el-menu-item :index="navItem.name" v-for="navItem in item.children" :key="navItem.name">
                            <router-link :to="{name:navItem.name}" tag="div">{{navItem.meta.title}}</router-link>
                        </el-menu-item>
                    </el-submenu>
                </el-menu>
            </el-aside>
            <el-main>
                <el-row>
                    <el-col :span="4" class="message">
                        <el-avatar :src="avatar"></el-avatar>
                        <el-tag type="success">{{realname}}</el-tag>
                        <el-button type="text" @click="back" class="bank">退出登录</el-button>
                    </el-col>
                </el-row>
                <router-view></router-view>
            </el-main>
        </el-container>
    </div>

</template>

<script>
    export default {
        name: "AdminMain",
        data: () => ({
            routeData: [],
            realname:sessionStorage.getItem("realname"),
            avatar:sessionStorage.getItem("avatar"),
        }),
        methods: {
            back() {
                sessionStorage.removeItem("username");
                sessionStorage.removeItem("realname");
                sessionStorage.removeItem("avatar");
                sessionStorage.removeItem("route");
                this.$router.replace({name:"Show"});
                location.reload();
            }
        },
        mounted() {
            this.routeData = this.$store.state.routeData[0].children;  //从vuex中获取数据
        }
    }
</script>

<style scoped>
    .around{

    }

    .bank {
        color: #333;
    }

    .bank:hover {
        color: #409EFF;
    }

    .el-dropdown {
        margin-right: 20px;
    }

    .message{
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-left: 80%;
    }
    .el-avatar{
        margin-right: 10px;
    }
    .el-tag{
        margin-right: 10px;
    }

</style>