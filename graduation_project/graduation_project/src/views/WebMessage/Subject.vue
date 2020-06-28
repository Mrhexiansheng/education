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
        <swiper :options="swiperOption" ref="mySwiper" @someSwiperEvent="callback" class="swiper-container">
            <!-- slides -->
            <swiper-slide><img src="../../assets/1.jpg" alt=""></swiper-slide>
            <swiper-slide><img src="../../assets/2.jpg" alt=""></swiper-slide>
            <swiper-slide><img src="../../assets/3.jpg" alt=""></swiper-slide>
            <swiper-slide><img src="../../assets/5.png" alt=""></swiper-slide>
            <swiper-slide><img src="../../assets/4.jpg" alt=""></swiper-slide>
            <!-- Optional controls -->
            <div class="swiper-pagination" slot="pagination"></div>
        </swiper>
        <el-main>
            <div class="firstBox">
                <div class="news">
                    <el-tabs v-model="activeName" @tab-click="handleClick">
                        <el-tab-pane label="新闻资讯" name="first">新闻资讯</el-tab-pane>
                        <el-tab-pane label="校内资讯" name="second">校内资讯</el-tab-pane>
                    </el-tabs>
                </div>
                <div class="notice">
                    <el-tabs v-model="activeName1" @tab-click="handleClick1">
                        <el-tab-pane label="通知公告" name="first">通知公告</el-tab-pane>
                        <el-tab-pane label="战略合作" name="second">战略合作</el-tab-pane>
                    </el-tabs>
                </div>
            </div>
            <!--            <p>上面对学校略微展示。
                            下方对中央、地区政府教改文件展示，关于教改的最新消息展示。（或者是学校文件）</p>-->
        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "Subject",
        data() {
            return {
                activeName: "first",
                activeName1: "first",
                activeIndex: "Subject",
                search: "",
                date: "",
                localDate: "",
                swiperOption: {
                    observer: true,             //修改swiper自己或子元素时，自动初始化swiper
                    observeParents: true,       //修改swiper的父元素时，自动初始化swiper
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    loop: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false
                    },
                    effect: 'fade',
                },
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
        computed: {
            swiper() {
                return this.$refs.mySwiper.swiper
            }
        },
        beforeMount() {
            this.date = new Date().toLocaleTimeString();
            this.date = this.date.slice(0, 2);
            this.localDate = new Date().toLocaleString();
        },
        mounted() {
            // current swiper instance
            // 然后你就可以使用当前上下文内的swiper对象去做你想做的事了
            console.log('this is current swiper instance object', this.swiper);
            this.swiper.slideTo(3, 1000, false);
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

    .cz {
        color: #409EFF;
        cursor: pointer;
    }

    .span {
        line-height: 40px;
        text-align: center;
    }


    .el-container {
        width: 100%;
        height: auto;
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
        padding: 20px 10%;
    }

    .firstBox {
        width: 100%;
        margin: 0 auto;
        height: auto;
        overflow: hidden;
    }

    .notice {
        width: 45%;
        height: auto;
        float: right;
        padding: 20px 20px;
        box-sizing: border-box;
    }

    .news {
        width: 50%;
        height: auto;
        margin-right: 5%;
        float: left;
        padding: 20px 20px;
        box-sizing: border-box;
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