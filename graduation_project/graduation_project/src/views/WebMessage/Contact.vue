<template>
    <el-container>
        <el-header>
            <el-row justify="space-around" type="flex">
                <el-col :span="4">
                    <span class="span">中北大学教育改革项目管理系统</span>
                </el-col>
                <el-col :span="4">
                    <el-input v-model="search" placeholder="请输入您要搜索的文章名" class="search">
                        <el-button slot="append" icon="el-icon-search"></el-button>
                    </el-input>
                </el-col>
                <el-col :span="4">
                    <audio controls="controls" loop="loop" controlsList="nodownload">
                        <source src="../../assets/audio.mp3" type="audio/mp3"/>
                        <source src="../../assets/audio.mp3" type="audio/mp3"/>
                        <source src="../../assets/audio.mp3" type="audio/mp3"/>
                    </audio>
                </el-col>
                <el-col :span="10">
                    <span class="span">您好，现在时间是&nbsp;{{localDate}}，</span>
                    <span class="span">{{date}}好，</span>
                    <span class="span">请   <router-link :to="{name:'login'}" tag="span" class="login">登录。</router-link></span>
                    &nbsp;
                    <span class="span">没有账号？<router-link :to="{name: 'Registered'}" tag="span"
                                                         class="cz">注册一个。</router-link></span>
                </el-col>
            </el-row>
        </el-header>
        <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect"
                 background-color="#F8F8F8">
            <el-menu-item v-for="item in category" :key="item.id" :index="item.enname">
                <router-link :to="{name:item.enname}" tag="div">{{item.catname}}</router-link>
            </el-menu-item>
        </el-menu>
        <el-main>

        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "Contact",
        data() {
            return {
                activeName: "first",
                activeName1: "first",
                activeIndex: "Contact",
                search: "",
                date: "",
                localDate: "",
                category: JSON.parse(sessionStorage.getItem("category")),
            }
        },
        methods: {
            callback() {

            },
            getDate() {
                this.localDate = new Date().toLocaleString();
            },
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClick(tab, event) {
                console.log(tab, event);
            },
            handleClick1(tab, event) {
                console.log(tab, event);
            }
        },
        computed: {},
        beforeMount() {
            this.date = new Date().toLocaleTimeString();
            this.date = this.date.slice(0, 2);
            this.localDate = new Date().toLocaleString();
        },
        mounted() {
            this.date = this.date.slice(0, 2);
            setInterval(this.getDate, 1000);
        },
    }
</script>
<style scoped lang="scss">
    * {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .el-header {
        border-bottom: 1px solid #e5e5e5;
        background-color: rgba(248, 248, 248, .4);
        height: 40px !important;
    }

    .login {
        color: #409EFF;
        cursor: pointer;
    }

    .zc {
        color: #409EFF;
        cursor: pointer;
    }

    .span {
        line-height: 40px;
        text-align: center;
    }


    .el-container {
        width: 100%;
        height: 100%;
        background: url("../../assets/bg.jpg") no-repeat 0px 0px;
    }

    img {
        width: 100%;
        height: 100%;
    }

    .el-menu-demo {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
    }

    .el-main {
        width: 100%;
        height: 100%;
        padding: 20px 10%;
    }

    .col {
        height: 300px;
        padding: 0 20px;
    }

    .li {
        margin-bottom: 10px;
    }

    audio {
        width: 100%;
        height: 100%;
        border: none;
        outline: none;
    }

    .el-col {
        text-align: center !important;
    }
</style>