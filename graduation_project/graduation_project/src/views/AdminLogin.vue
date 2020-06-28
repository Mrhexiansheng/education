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
            <el-row justify="center" align="middle" type="flex">
                <el-col :span="8" class="box">
                    <h1>教育改革项目管理系统</h1>
                    <el-form label-width="80px" :model="form" :rules="rules" ref="loginForm"
                             :hide-required-asterisk="true"
                             :status-icon="true">
                        <el-form-item label="用户名" prop="username">
                            <el-input placeholder="请输入用户名" v-model="form.username" clearable></el-input>
                        </el-form-item>
                        <el-form-item label="密码" prop="password">
                            <el-input placeholder="请输入密码" v-model="form.password" clearable type="password"></el-input>
                        </el-form-item>
                        <el-form-item label="验证码" prop="yzm">
                            <el-row justify="space-between" type="flex">
                                <el-col :span="15">
                                    <el-input placeholder="请输入验证码" v-model="form.yzm" clearable></el-input>
                                </el-col>
                                <el-col :span="7" :pull="1">
                                    <img :src="src" alt="" @click="changesrc" style="width: 100%;height: 100%">
                                </el-col>
                            </el-row>
                        </el-form-item>
                        <el-form-item>
                            <el-button plain @click="submit">登录</el-button>
                        </el-form-item>
                    </el-form>
                </el-col>
            </el-row>
        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "AdminLogin",
        data: () => ({
            src: "/api/admin/yz",
            form: {
                username: "",
                password: "",
                yzm: "",
                last_login_time:new Date().toLocaleString()
            },
            rules: {
                username: [
                    {required: true, message: '请输入用户名', trigger: 'blur'},
                ],
                password: [
                    {required: true, message: '请输入密码', trigger: 'blur'},
                    {min: 6, max: 15, message: '长度在 6 到 12 个字符', trigger: 'blur'}
                ],
                yzm: [
                    {required: true, message: '请输入验证码', trigger: 'blur'},
                ]
            },
            date: "",
            localDate: "",
        }),
        methods: {
            changesrc() {
                this.src = "/api/admin/yz?t" + new Date();
            },
            submit() {
                this.$refs.loginForm.validate(val => {
                    if (val) {
                        this.$axios.post(this.$api.LOGIN, this.form).then(res => {
                            if (res.data.code === 200) {
                                sessionStorage.setItem("username", this.form.username);  //在清空表单之前，把用户名保存下来，唯一索引
                                sessionStorage.setItem("avatar", res.data.avatar);  //取到用户头像
                                sessionStorage.setItem("realname", res.data.realname);  //取到用户头像
                                this.$store.commit("updateRouteData", res.data.route);  //向vuex发送数据
                                this.$refs.loginForm.resetFields();
                                this.$message.success(res.data.msg);
                            } else {
                                this.$message.error(res.data.msg);
                            }
                        })
                    } else {
                        this.$message.error("登录失败")
                    }
                })
            },
            getDate() {
                this.localDate = new Date().toLocaleString();
            },
        },
        beforeMount(){
            this.date = new Date().toLocaleTimeString();
            this.date =  this.date.slice(0, 2);
            this.localDate = new Date().toLocaleString();
        },
        mounted() {
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

    .el-row {
        width: 100%;
        height: 100%;
    }

    .box {
        height: auto;
        /*background: rgba(255, 255, 255, .2);*/
        padding: 30px;
        border-radius: 10px;
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

    .el-row {
        width: 100%;
        height: 100%;
    }

    .span {
        line-height: 40px;
    }
</style>