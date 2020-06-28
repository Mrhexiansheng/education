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
            <el-row justify="center" type="flex">
                <el-col style="width: auto">
                    {{data.title}}
                </el-col>
            </el-row>
            <el-divider class="divider"></el-divider>
            <el-row justify="center" type="flex">
                <el-col style="width: auto">
                    {{data.time}}
                </el-col>
            </el-row>
            <el-divider class="divider"></el-divider>
            <el-row justify="center" align="middle" type="flex">
                <el-col class="box">
                    {{data.content}}
                </el-col>
            </el-row>
            <el-divider class="divider"></el-divider>
            <el-row justify="center" align="middle" type="flex">
                <el-col class="box">
                    附件：
                    <span v-for="item in data.file">
                        <el-link target="_blank" :href="item.url" :underline="false"
                         :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                    </span>
                </el-col>
            </el-row>
        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "Content",
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
                if (this.$route.query.types == "school") {
                    this.$axios.get(this.$api.SCHOOLNEWS, {
                        types: this.$route.query.types,
                        id: this.$route.query.id
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
                if (this.$route.query.types == "meeting") {
                    this.$axios.get(this.$api.MEETING, {
                        types: this.$route.query.types,
                        id: this.$route.query.id
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
                if (this.$route.query.types == "notice") {
                    this.$axios.get(this.$api.NOTICE, {
                        types: this.$route.query.types,
                        id: this.$route.query.id
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
                if (this.$route.query.types == "news") {
                    this.$axios.get(this.$api.NEWS, {
                        types: this.$route.query.types,
                        id: this.$route.query.id
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

</style>