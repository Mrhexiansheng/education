<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>资料修改</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-form :model="form" label-width="80px" :rules="rules" ref="updateForm" :hide-required-asterisk="true"
                 :status-icon="true">
            <el-form-item label="真实姓名" prop="realname">
                <el-input v-model="form.realname" placeholder="请输入真实姓名" clearable></el-input>
            </el-form-item>
            <el-form-item label="职称" prop="teachers_title">
                <el-input v-model="form.teachers_title" clearable disabled></el-input>
            </el-form-item>
            <el-form-item label="学位" prop="degree">
                <el-input v-model="form.degree" clearable disabled></el-input>
            </el-form-item>
            <el-form-item label="所属学院" prop="college">
                <el-input v-model="form.college" placeholder="请选择所属部门" clearable disabled></el-input>
            </el-form-item>
            <el-form-item label="职位" prop="position">
                <el-input v-model="form.position" placeholder="请勿乱输入职位" v-if="form.role === 2" clearable></el-input>
                <el-input v-model="form.position" placeholder="请勿乱输入职位" v-else disabled></el-input>
            </el-form-item>
            <el-form-item label="所属部门" prop="depart_number">
                <el-input v-model="form.depart_number" placeholder="请选择所属部门" clearable disabled></el-input>
            </el-form-item>
            <el-form-item label="联系电话" prop="phone">
                <el-input v-model="form.phone" placeholder="请输入联系电话" clearable></el-input>
            </el-form-item>
            <el-form-item label="个人头像" prop="password">
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
            <el-form-item>
                <el-button @click="dialogVisible = true">修改密码</el-button>
                <el-button @click="update">确认修改</el-button>
            </el-form-item>
        </el-form>
        <el-dialog
                title="提示"
                :visible.sync="dialogVisible"
                width="30%">
            <el-form>
                <el-form-item label="原密码" prop="password">
                    <el-input v-model="form.password1" placeholder="请输入原密码" clearable></el-input>
                </el-form-item>
                <el-form-item label="新密码" prop="password1">
                    <el-input v-model="form.password2" placeholder="请输入新密码" clearable></el-input>
                </el-form-item>
                <el-form-item label="新密码" prop="password2">
                    <el-input v-model="form.password3" placeholder="请确认新密码" clearable></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        name: "ChangeInformation",
        data() {
            return {
                form: {
                    password1: "",
                    password2: "",
                    password3: "",
                    username: sessionStorage.getItem("username"),
                    avatar: "",
                    realname: "",
                    phone: "",
                    depart_number: "",
                    position:""
                },
                dialogVisible: false,
                upload: this.$api.UPLOAD,
                rules: {
                    password: {required: true, message: "请输入原密码", trigger: "blur"},
                    password1: {required: true, message: "请输入新密码", trigger: "blur"},
                    password2: {required: true, message: "请输入新密码", trigger: "blur"}
                },
            }
        },
        methods: {
            update() {
                this.$confirm('修改完成会重新加载，请注意保存未保存的信息！', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                    this.$refs.updateForm.validate(val => {
                        if (val) {
                            this.$axios.put(this.$api.CHANGE, {
                                realname: this.form.realname,
                                username: sessionStorage.getItem("username"),
                                phone: this.form.phone,
                                avatar: this.form.avatar,
                                password1: this.form.password1,
                                password2: this.form.password2,
                                password3: this.form.password3,
                                position:this.form.position
                            }).then(res => {
                                if (res.data.code === 200) {
                                    this.$router.replace({name: "Show"});
                                    sessionStorage.removeItem("username");//修改成功，直接返回登录页，但是数据都要清掉，重新加载，前面导航守卫设置没有session才会重载，所以都清掉
                                    sessionStorage.removeItem("realname");
                                    sessionStorage.removeItem("avatar");
                                    sessionStorage.removeItem("route");
                                    location.reload();  //及时清理掉vuex里面的数据
                                } else {
                                    this.$message.error(res.data.msg)
                                }
                            })
                        } else {
                            this.$message.error("修改失败")
                        }
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消修改'
                    });
                });
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
            getData() {
                this.$axios.get(this.$api.GETCHANGEDATA, {username: sessionStorage.getItem("username")}).then(res => {
                    if (res.data.code === 200) {
                        if (res.data.data.teachers_title === 1) {
                            res.data.data.teachers_title = "助教"
                        }
                        if (res.data.data.teachers_title === 2) {
                            res.data.data.teachers_title = "讲师"
                        }
                        if (res.data.data.teachers_title === 3) {
                            res.data.data.teachers_title = "副教授"
                        }
                        if (res.data.data.teachers_title === 4) {
                            res.data.data.teachers_title = "教授"
                        }
                        if (res.data.data.degree === 1) {
                            res.data.data.degree = "学士"
                        }
                        if (res.data.data.degree === 2) {
                            res.data.data.degree = "硕士"
                        }
                        if (res.data.data.degree === 3) {
                            res.data.data.degree = "博士"
                        }
                        this.form = res.data.data;
                    } else {
                        this.$message.error("获取失败");
                    }
                })
            },
        },
        mounted() {
            this.getData();
        }
    }
</script>

<style scoped>
    .el-input {
        width: 300px;
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