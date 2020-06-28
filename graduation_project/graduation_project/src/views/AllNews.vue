<template>
    <el-container>
        <el-header>
            <el-row justify="space-between" type="flex">
                <el-col :span="4" :offset="1">
                    <span class="span">不了解网站？<router-link :to="{name: 'Show'}" tag="span" class="cz">网站简介。</router-link></span>
                </el-col>
                <el-col :span="11">
                    <span class="span">您好，现在时间是&nbsp;{{localDate}}，</span>
                    <span class="span">{{date}}好，</span>
                    <span class="span">请   <router-link :to="{name:'login'}" tag="span" class="login">登录。</router-link></span>
                    &nbsp;
                    <span class="span">没有账号？<router-link :to="{name: 'Registered'}" tag="span"
                                                         class="cz">注册一个。</router-link></span>
                </el-col>
            </el-row>
        </el-header>
        <el-main>
            <div v-for="item in data">
                <el-row justify="center" type="flex" class="li">
                    <el-col :span="10">
                        <el-popover
                                placement="top-start"
                                width="200"
                                trigger="hover"
                                :content="item.description">
                            <el-link :underline="false" slot="reference" href="">
                                <router-link :to="{name:'content',query:{id:item.id,types:item.logo}}"
                                             style="color: black">
                                    {{item.title}}
                                </router-link>
                            </el-link>
                        </el-popover>
                    </el-col>
                    <el-col :span="4">
                        <el-link :underline="false">{{item.time}}</el-link>
                    </el-col>
                </el-row>
                <el-divider class="divider"></el-divider>
            </div>
        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "AllNews",
        data: () => ({
            date: "",
            localDate: "",
            data: ""
        }),
        methods: {
            getDate() {
                this.localDate = new Date().toLocaleString();
            },
            getData() {
                if (this.$route.query.types == "yj") {
                    this.$axios.get(this.$api.SCHOOLNEWS, {
                        types: this.$route.query.types,
                    }).then(res => {
                        if (res.data.code === 200) {
                            if (res.data.data.file) {
                                res.data.data.file = JSON.parse(res.data.data.file)
                            }
                            if (res.data.data.thumb) {
                                res.data.data.thumb = JSON.parse(res.data.data.thumb)
                            }
                            this.data = res.data.data;
                        }
                    })
                }
                if (this.$route.query.types == "xj") {
                    this.$axios.get(this.$api.SCHOOLNEWS, {
                        types: this.$route.query.types,
                    }).then(res => {
                        if (res.data.code === 200) {
                            if (res.data.data.file) {
                                res.data.data.file = JSON.parse(res.data.data.file)
                            }
                            if (res.data.data.thumb) {
                                res.data.data.thumb = JSON.parse(res.data.data.thumb)
                            }
                            this.data = res.data.data;
                        }
                    })
                }
                if (this.$route.query.types == "gn") {
                    this.$axios.get(this.$api.NEWS, {
                        types: this.$route.query.types,
                    }).then(res => {
                        if (res.data.code === 200) {
                            if (res.data.data.file) {
                                res.data.data.file = JSON.parse(res.data.data.file)
                            }
                            if (res.data.data.thumb) {
                                res.data.data.thumb = JSON.parse(res.data.data.thumb)
                            }
                            this.data = res.data.data;
                        }
                    })
                }
                if (this.$route.query.types == "gw") {
                    this.$axios.get(this.$api.NEWS, {
                        types: this.$route.query.types,
                    }).then(res => {
                        if (res.data.code === 200) {
                            if (res.data.data.file) {
                                res.data.data.file = JSON.parse(res.data.data.file)
                            }
                            if (res.data.data.thumb) {
                                res.data.data.thumb = JSON.parse(res.data.data.thumb)
                            }
                            this.data = res.data.data;
                        }
                    })
                }
                if (this.$route.query.types == "lx") {
                    this.$axios.get(this.$api.NOTICE, {
                        types: this.$route.query.types,
                    }).then(res => {
                        if (res.data.code === 200) {
                            if (res.data.data.file) {
                                res.data.data.file = JSON.parse(res.data.data.file)
                            }
                            if (res.data.data.thumb) {
                                res.data.data.thumb = JSON.parse(res.data.data.thumb)
                            }
                            this.data = res.data.data;
                        }
                    })
                }
                if (this.$route.query.types == "sh") {
                    this.$axios.get(this.$api.NOTICE, {
                        types: this.$route.query.types,
                    }).then(res => {
                        if (res.data.code === 200) {
                            if (res.data.data.file) {
                                res.data.data.file = JSON.parse(res.data.data.file)
                            }
                            if (res.data.data.thumb) {
                                res.data.data.thumb = JSON.parse(res.data.data.thumb)
                            }
                            this.data = res.data.data;
                        }
                    })
                }
                if (this.$route.query.types == "xjhy") {
                    this.$axios.get(this.$api.MEETING, {
                        types: this.$route.query.types,
                    }).then(res => {
                        if (res.data.code === 200) {
                            if (res.data.data.file) {
                                res.data.data.file = JSON.parse(res.data.data.file)
                            }
                            if (res.data.data.thumb) {
                                res.data.data.thumb = JSON.parse(res.data.data.thumb)
                            }
                            this.data = res.data.data;
                        }
                    })
                }
                if (this.$route.query.types == "yjhy") {
                    this.$axios.get(this.$api.MEETING, {
                        types: this.$route.query.types,
                    }).then(res => {
                        if (res.data.code === 200) {
                            if (res.data.data.file) {
                                res.data.data.file = JSON.parse(res.data.data.file)
                            }
                            if (res.data.data.thumb) {
                                res.data.data.thumb = JSON.parse(res.data.data.thumb)
                            }
                            this.data = res.data.data;
                        }
                    })
                }
            }
        },
        beforeMount() {
            this.date = new Date().toLocaleTimeString();
            this.date = this.date.slice(0, 2);
            this.localDate = new Date().toLocaleString();
        },
        mounted() {
            if (this.$route.params.data){
                this.data = this.$route.params.data;
            }
            this.getData();
            this.date = this.date.slice(0, 2);
            setInterval(this.getDate, 1000);
        },
    }
</script>

<style scoped lang="scss">
    .el-container {
        width: 100%;
        height: 100%;
        background: url("../assets/bg.jpg") no-repeat 0px 0px;
    }

    .el-main {
        padding: 50px 160px;
    }

    .el-row {
        width: 100%;
    }

    .box {
        height: auto;
        /*background: rgba(255, 255, 255, .2);*/
        padding: 30px;
    }

    h1 {
        font-size: 30px;
        line-height: 50px;
        text-align: center;
        margin: 20px 0;
        color: #000;
        font-weight: normal;
    }

    .el-button {
        width: 100%;
        background: rgba(255, 255, 255, .2) !important;
        border: none !important;
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
    }

    .title .time {
        text-align: center !important;

    }

    .divider {
        margin: 12px 0;
    }

    .router-link-active {
        text-decoration: none;
    }

    a {
        text-decoration: none;
    }
</style>