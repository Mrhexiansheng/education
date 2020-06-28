<template>
    <el-container>
        <el-header>
            <el-row justify="space-around" type="flex">
                <el-col :span="4">
                    <span class="span">中北大学教育改革项目管理系统</span>
                </el-col>
                <el-col :span="4">
                    <el-input v-model="searchData" placeholder="请输入您要搜索的文章名" class="search">
                        <el-button slot="append" icon="el-icon-search" @click="search"></el-button>
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
            <el-header><div id="about"></div></el-header>

        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "About",
        data() {
            return {
                activeName: "first",
                activeName1: "first",
                activeIndex: "About",
                searchData: "",
                date: "",
                localDate: "",
                category: JSON.parse(sessionStorage.getItem("category")),
                str: "该网站主要是一个项目管理系统网站，主要用于中北大学教育改革项目管理系统的申请和审核！如果你已经看完了，那我就不写了...再见！"
            }
        },
        methods: {
            search() {
                if (this.searchData) {
                    this.$axios.get(this.$api.SCHOOLNEWS, {
                        search: this.searchData
                    }).then(res => {
                        if (res.data.code === 200) {
                            this.$router.push({name: "allNews", params: {data: res.data.data}})
                        } else {
                            this.$message.error(res.data.msg)
                        }
                    })
                } else {
                    this.$message.error("请正确填写搜索信息")
                }
            },
            callback() {

            },
            getDate() {
                this.localDate = new Date().toLocaleString();
            },
            handleSelect(key, keyPath) {
                // console.log(key, keyPath);
            },
            handleClick(tab, event) {
                // console.log(tab, event);
            },
            handleClick1(tab, event) {
                // console.log(tab, event);
            },
            about() {
                let about = document.getElementById("about");
                let i = 0;
                let timer = 0;
                let times = 0;
                let str = this.str;
                let a = str.length;
                typing();
                function typing() {
                    if (i <= str.length) {
                        about.innerHTML = str.slice(0, i++) + "_";
                        timer = setTimeout(typing, 200);
                    } else {
                        about.innerHTML = str; //结束打字,移除 _ 光标
                        clearTimeout(timer);
                        del();
                    }
                }
                function del() {
                    if (a>0) {
                        about.innerHTML = str.slice(0, a--) + "|";
                        times = setTimeout(del, 200);
                    }
                    if (a === 0) {
                        about.innerHTML = ""; //结束打字,移除 _ 光标
                        clearTimeout(times);
                    }
                }

            },
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
            this.about();
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

    .router-link-active {
        text-decoration: none;
    }

    a {
        text-decoration: none;
    }

    .login {
        color: #409EFF;
        cursor: pointer;
    }

    .cz {
        color: #409EFF;
        cursor: pointer;
    }

    .span {
        line-height: 40px;
        text-align: center;
    }

    .el-col {
        text-align: center !important;
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

    .el-container {
        width: 100%;
        height: 100%;
        background: url("../../assets/bg.jpg") no-repeat 0px 0px;
    }

    .swiper-container {
        width: 80%;
        height: 300px;
        margin: 0 auto;
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

    .el-header{
        line-height: 40px;
        background: none;
        border-bottom: none;
    }
</style>