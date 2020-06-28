<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>资料修改</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-form :model="form" label-width="80px" :rules="rules" ref="updateForm" :hide-required-asterisk="true"
                 :status-icon="true">
            <el-form-item label="原密码" prop="password">
                <el-input v-model="form.password1" placeholder="请输入原密码" clearable></el-input>
            </el-form-item>
            <el-form-item label="新密码" prop="password1">
                <el-input v-model="form.password2" placeholder="请输入新密码" clearable></el-input>
            </el-form-item>
            <el-form-item label="新密码" prop="password2">
                <el-input v-model="form.password3" placeholder="请确认新密码" clearable></el-input>
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
                <el-button @click="update">确认修改</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    export default {
        name: "RootInformation",
        data() {
            return {
                form: {
                    password1: "",
                    password2: "",
                    password3: "",
                    username: sessionStorage.getItem("username"),
                    avatar: "",
                },
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
                                username: sessionStorage.getItem("username"),
                                avatar: this.form.avatar,
                                password1: this.form.password1,
                                password2: this.form.password2,
                                password3: this.form.password3,
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
                this.$axios.get(this.$api.GETROOTDATA, {username: sessionStorage.getItem("username")}).then(res => {
                    if (res.data.code === 200) {
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