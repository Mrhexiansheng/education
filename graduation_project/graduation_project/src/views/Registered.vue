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
                    <h1>账号注册</h1>
                    <el-form label-width="80px" :model="form" :rules="rules" ref="registeredForm"
                             :hide-required-asterisk="true"
                             :status-icon="true">
                        <el-form-item label="用户名" prop="username">
                            <el-input placeholder="请输入用户名(请用职工号注册)" v-model="form.username" clearable></el-input>
                        </el-form-item>
                        <el-form-item label="密码" prop="password1">
                            <el-input placeholder="请输入密码" v-model="form.password1" clearable type="password"></el-input>
                        </el-form-item>
                        <el-form-item label="密码" prop="password2">
                            <el-input placeholder="请再次输入密码" v-model="form.password2" clearable
                                      type="password"></el-input>
                        </el-form-item>
                        <el-form-item label="职工性质" prop="role">
                            <el-select v-model="form.role" placeholder="请选择职工性质">
                                <el-option
                                        v-for="item in options1"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <div v-if="form.role === 3">
                            <el-form-item label="专家类型" prop="experts_type">
                                <el-select v-model="form.experts_type" placeholder="请选择专家类型">
                                    <el-option
                                            v-for="item in experts_options"
                                            :key="item.id"
                                            :label="item.type"
                                            :value="item.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                        <div v-if="form.role !== 3">
                            <el-form-item label="所属学院" prop="college">
                                <el-select v-model="form.college" placeholder="请选择所属学院">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.id"
                                            :label="item.college"
                                            :value="item.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="职称" prop="teachers_title">
                                <el-select v-model="form.teachers_title" placeholder="请选择你的职称">
                                    <el-option
                                            v-for="item in options3"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="学位" prop="degree">
                                <el-select v-model="form.degree" placeholder="请选择你的学位">
                                    <el-option
                                            v-for="item in options4"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="所属部门" prop="depart_number">
                                <el-select v-model="form.depart_number" placeholder="请选择职工部门">
                                    <el-option
                                            v-for="item in options2"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="手机号" prop="phone">
                                <el-input placeholder="请输入手机号" v-model="form.phone" clearable
                                          type="number"></el-input>
                            </el-form-item>
                            <el-form-item label="头像" prop="avatar">
                                <el-upload
                                        class="avatar-uploader"
                                        :action="upload"
                                        :show-file-list="false"
                                        :on-success="handleAvatarSuccess"
                                        :before-upload="beforeAvatarUpload">
                                    <img v-if="form.avatar" :src="form.avatar" class="avatar">
                                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                            </el-form-item>
                        </div>
                        <el-form-item>
                            <el-button plain @click="beforeregistered">注册</el-button>
                        </el-form-item>
                    </el-form>
                </el-col>
            </el-row>
        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "Registered",
        data() {
            return {
                upload: this.$api.UPLOAD,
                flag: false,
                form: {
                    username: "",
                    password1: "",
                    password2: "",
                    phone: "",
                    avatar: "",
                    last_login_time: new Date().toLocaleString(),
                    role: "",
                    college: "",
                    depart_number: "",
                    degree: "",
                    teachers_title: "",
                    experts_type: ""
                },
                date: "",
                localDate: "",
                rules: {
                    username: [
                        {required: true, message: '请输入用户名', trigger: 'blur'},
                    ],
                    password1: [
                        {required: true, message: '请输入密码', trigger: 'blur'},
                        {min: 6, max: 15, message: '长度在 6 到 12 个字符', trigger: 'blur'}
                    ],
                    password2: [
                        {required: true, message: '请输入密码', trigger: 'blur'},
                        {min: 6, max: 15, message: '长度在 6 到 12 个字符', trigger: 'blur'}
                    ],
                    phone: [
                        {required: true, message: '请输入手机号', trigger: 'blur'},
                    ],
                    avatar: [
                        {required: true, message: '请上传头像', trigger: 'blur'},
                    ],
                    role: [
                        {required: true, message: '请选择职工性质', trigger: 'blur'},
                    ],
                    college: [
                        {required: true, message: '请选择所属学院', trigger: 'blur'},
                    ],
                    depart_number: [
                        {required: true, message: '请选择职工部门', trigger: 'blur'},
                    ],
                    experts_type: [
                        {required: true, message: '请选择专家类型', trigger: 'blur'},
                    ],
                },
                options: [],
                options1: [{
                    value: 2,
                    label: '领导'
                }, {
                    value: 3,
                    label: '专家'
                }, {
                    value: 4,
                    label: '教师'
                },],
                options2: [{
                    value: 1,
                    label: '纪检部门'
                }, {
                    value: 2,
                    label: '后勤部门'
                }, {
                    value: 3,
                    label: '审核部门'
                }, {
                    value: 4,
                    label: '财务部门'
                }],
                options3: [{
                    value: 1,
                    label: '助教'
                }, {
                    value: 2,
                    label: '讲师'
                }, {
                    value: 3,
                    label: '副教授'
                }, {
                    value: 4,
                    label: '教授'
                }],
                options4: [{
                    value: 1,
                    label: '学士'
                }, {
                    value: 2,
                    label: '硕士'
                }, {
                    value: 3,
                    label: '博士'
                },],
                value: '',
                experts_options: ""
            }
        },
        methods: {
            beforeregistered() {
                this.$refs.registeredForm.validate(val => {
                    if (val) {
                        this.$axios.get(this.$api.beforeRegistered, this.form).then(res => {
                            if (res.data.code === 200) {
                                this.$axios.post(this.$api.REGISTERED, this.form).then(res => {
                                    if (res.data.code === 200) {
                                        this.$refs.registeredForm.resetFields();
                                        this.$message.success("恭喜您注册成功,登录之后，请注意完善个人资料。")
                                    } else {
                                        this.$message.error("注册失败")
                                    }
                                })
                            }else {
                                this.$message.error(res.data.msg)
                            }
                        });

                    } else {
                        this.$message.error("请填写表单")
                    }
                })
            },
            handleAvatarSuccess(res) {
                if (res === "error") {
                    this.$message.error("上传失败")
                } else {
                    this.form.avatar = res;
                }
            },
            beforeAvatarUpload(file) {
                const typeArr = ["image/jpeg", "image/jpg", "image/png"];
                const isLt5M = file.size / 1024 / 1024 < 5;

                if (!typeArr.includes(file.type)) {
                    this.$message.error("上传的图片格式有误，请重新上传！")
                }
                if (!isLt5M) {
                    this.$message.error('上传头像图片大小不能超过 5MB!');
                }
            },
            getDate() {
                this.localDate = new Date().toLocaleString();
            },
            getCollege() {
                this.$axios.get(this.$api.COLLEGE).then(res => {
                    if (res.data.code === 200) {
                        this.options = res.data.data;
                    }
                })
            },
            getexperts_type() {
                this.$axios.get(this.$api.PROJECT_TYPE).then(res => {
                    if (res.data.code === 200) {
                        this.experts_options = res.data.data;
                    } else {
                        this.$message.error("获取失败")
                    }
                })
            },
        },
        beforeMount() {
            this.date = new Date().toLocaleTimeString();
            this.date = this.date.slice(0, 2);
            this.localDate = new Date().toLocaleString();
        },
        mounted() {
            this.date = this.date.slice(0, 2);
            setInterval(this.getDate, 1000);
            this.getCollege();
            this.getexperts_type();
        },
    }
</script>

<style scoped lang="scss">

    .el-container {
        width: 100%;
        min-height: 100%;
        background: url("../assets/bg.jpg") no-repeat 0px 0px;
    }

    .main {
        height: 100%;
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

    .avatar-uploader .el-upload {
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .avatar-uploader-icon:hover {
        border-color: #409EFF;
    }

    .avatar-uploader-icon {
        border: 1px dashed #d9d9d9;
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }

    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>