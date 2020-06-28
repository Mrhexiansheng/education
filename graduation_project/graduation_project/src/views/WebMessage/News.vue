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
        <swiper :options="swiperOption" ref="mySwiper" class="swiper-container">
            <swiper-slide><img src="../../assets/1.jpg" alt=""></swiper-slide>
            <swiper-slide><img src="../../assets/2.jpg" alt=""></swiper-slide>
            <swiper-slide><img src="../../assets/3.jpg" alt=""></swiper-slide>
            <swiper-slide><img src="../../assets/5.png" alt=""></swiper-slide>
            <swiper-slide><img src="../../assets/4.jpg" alt=""></swiper-slide>
            <div class="swiper-pagination" slot="pagination"></div>
        </swiper>
        <el-main>
            <div class="firstBox">
                <div class="news">
                    <router-link :to="{path:'/allNews',query:{types:'gn'}}" tag="div" class="more">查看更多</router-link>
                    <el-tabs v-model="activeName" @tab-click="handleClick">
                        <el-tab-pane label="国内资讯" name="first">
                            <el-row  justify="space-around" type="flex">
                                <el-col :span="11" class="col" v-for="item in data3">
                                    <el-row>
                                        <router-link :to="{name: 'content',query:{id:item.id,types:item.logo}}" style="z-index: 2000"><img
                                                :src="item.thumb ? item.thumb[0].url:require('../../assets/5.png')" alt="" class="thumb"></router-link>
                                    </el-row>
                                    <el-row justify="space-around" type="flex">
                                        <el-col :span="18">
                                            <el-popover
                                                    placement="top-start"
                                                    width="200"
                                                    trigger="hover"
                                                    :content=item.description>
                                                <el-link :underline="false" slot="reference" href="">
                                                    <router-link
                                                            :to="{name:'content',query:{id:item.id,types:item.logo}}"
                                                            style="color: black">{{item.title}}
                                                    </router-link>
                                                </el-link>
                                            </el-popover>
                                        </el-col>
                                        <el-col :span="6">
                                            <el-link :underline="false" href="">{{item.time}}</el-link>
                                        </el-col>
                                    </el-row>
                                </el-col>
                                <el-col :span="12" class="col">
                                    <el-row justify="space-around" type="flex" class="li" v-for="item in data1">
                                        <el-col :span="15">
                                            <el-popover
                                                    placement="top-start"
                                                    width="200"
                                                    trigger="hover"
                                                    :content="item.description">
                                                <el-link :underline="false" slot="reference" href="" >
                                                    <router-link
                                                            :to="{name:'content',query:{id:item.id,types:item.logo}}"
                                                            style="color: black;">{{item.title}}
                                                    </router-link>
                                                </el-link>
                                            </el-popover>
                                        </el-col>
                                        <el-col :span="6">
                                            <el-link :underline="false">{{item.time}}</el-link>
                                        </el-col>
                                    </el-row>
                                </el-col>
                            </el-row>
                        </el-tab-pane>
                    </el-tabs>
                </div>
                <div class="notice">
                    <router-link :to="{path:'/allNews',query:{types:'gw'}}" tag="div" class="more">查看更多</router-link>
                    <el-tabs v-model="activeName1" @tab-click="handleClick1">
                        <el-tab-pane label="国外资讯" name="first">
                            <el-row justify="space-around" type="flex">
                                <el-col :span="11" class="col" v-for="item in data4">
                                    <el-row>
                                        <router-link :to="{name: 'content',query:{id:item.id,types:item.logo}}" style="z-index: 2000"><img
                                                :src="item.thumb ? item.thumb[0].url:require('../../assets/5.png')" alt="" class="thumb"></router-link>
                                    </el-row>
                                    <el-row justify="space-around" type="flex">
                                        <el-col :span="18">
                                            <el-popover
                                                    placement="top-start"
                                                    width="200"
                                                    trigger="hover"
                                                    :content=item.description>
                                                <el-link :underline="false" slot="reference" href="">
                                                    <router-link
                                                            :to="{name:'content',query:{id:item.id,types:item.logo}}"
                                                            style="color: black">{{item.title}}
                                                    </router-link>
                                                </el-link>
                                            </el-popover>
                                        </el-col>
                                        <el-col :span="6">
                                            <el-link :underline="false" href="">{{item.time}}</el-link>
                                        </el-col>
                                    </el-row>
                                </el-col>
                                <el-col :span="12" class="col">
                                    <el-row justify="space-around" type="flex" class="li" v-for="item in data2">
                                        <el-col :span="15" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            <el-popover
                                                    placement="top-start"
                                                    width="200"
                                                    trigger="hover"
                                                    :content="item.description">
                                                <el-link :underline="false" slot="reference" href="">
                                                    <router-link
                                                            :to="{name:'content',query:{id:item.id,types:item.logo}}"
                                                            style="color: black;">{{item.title}}
                                                    </router-link>
                                                </el-link>
                                            </el-popover>
                                        </el-col>
                                        <el-col :span="6">
                                            <el-link :underline="false">{{item.time}}</el-link>
                                        </el-col>
                                    </el-row>
                                </el-col>
                            </el-row>
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </div>
        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "Show",
        data() {
            return {
                activeName: "first",
                activeName1: "first",
                activeIndex: "News",
                searchData: "",
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
                category: "",
                data1: [],
                data2: [],
                data3: [],
                data4: [],
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
            getCategory() {
                this.$axios.get(this.$api.CATEGORY).then(res => {
                    if (res.data.code === 200) {
                        sessionStorage.setItem("category", JSON.stringify(res.data.data));
                        this.category = res.data.data;
                    } else {
                        this.$message.error("获取失败")
                    }
                })
            },
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClick(tab, event) {
                console.log(tab, event);
            },
            handleClick1(tab, event) {
                console.log(tab, event);
            },
            getDate() {
                this.localDate = new Date().toLocaleString();
            },
            getData() {
                this.$axios.get(this.$api.NEWS, {
                    type: "qt"
                }).then(res => {
                    if (res.data.code === 200) {
                        res.data.data1.forEach(function (value, index) {
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                            if (value.time) {
                                value.time = value.time.slice(0, value.time.indexOf("午") - 1)
                            }
                        });
                        res.data.data2.forEach(function (value, index) {
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                            if (value.time) {
                                value.time = value.time.slice(0, value.time.indexOf("午") - 1)
                            }
                        });
                        res.data.data3.forEach(function (value, index) {
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                            if (value.time) {
                                value.time = value.time.slice(0, value.time.indexOf("午") - 1)
                            }
                        });
                        res.data.data4.forEach(function (value, index) {
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                            if (value.time) {
                                value.time = value.time.slice(0, value.time.indexOf("午") - 1)
                            }
                        });
                        this.data1 = res.data.data1;
                        this.data2 = res.data.data2;
                        this.data3 = res.data.data3;
                        this.data4 = res.data.data4;
                    }
                });
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
            this.getData();
            setInterval(this.getDate, 1000);
            this.swiper.activeIndex = null;
            this.swiper.slideTo(3, 1000, false);
            if (!sessionStorage.getItem("category")) {
                this.getCategory();
            } else {
                this.category = JSON.parse(sessionStorage.getItem("category"))
            }
        },
    }
</script>

<style scoped lang="scss">
    * {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .router-link-active {
        text-decoration: none;
    }

    a {
        text-decoration: none;
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

    .el-col {
        text-align: center !important;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
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
        width: 47.5%;
        height: auto;
        float: right;
        padding: 20px 20px;
        box-sizing: border-box;
        position: relative;
    }

    .news {
        width: 47.5%;
        height: auto;
        margin-right: 5%;
        float: left;
        padding: 20px 20px;
        box-sizing: border-box;
        position: relative;
    }

    .thumb {
        width: 100%;
        height: 260px;
        display: block;
        margin-bottom: 20px;
    }

    .col {
        height: 300px;
        /*padding: 0 20px;*/
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

    .more {
        display: block;
        position: absolute;
        line-height: 40px;
        font-size: 14px;
        right: 20px;
        color: #409EFF;
        cursor: pointer;
        overflow: hidden;
        z-index: 2000;
    }

    .more1 {
        display: block;
        position: absolute;
        line-height: 40px;
        font-size: 14px;
        right: 20px;
        color: #409EFF;
        cursor: pointer;
        z-index: 2000;
    }

</style>