<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>资讯管理</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="资讯信息" name="first">
                <el-row>
                    <el-col :span="24">
                        <el-table
                                :data="tableData"
                                style="width: 100%"
                                :header-cell-style="{'text-align':'center'}"
                                :cell-style="{'text-align':'center'}"
                                @cell-dblclick="tableDbEdit"
                        >
                            <el-table-column type="expand">
                                <template slot-scope="props">
                                    <el-form label-position="left" inline class="demo-table-expand">
                                        <el-form-item label="资讯描述">
                                            <span>{{ props.row.description }}</span>
                                        </el-form-item>
                                        <el-form-item label="资讯申请时间">
                                            <span>{{ props.row.time }}</span>
                                        </el-form-item>
                                        <el-form-item label="资讯图片">
                                    <span v-for="item in props.row.thumb">
                                        <el-link target="_blank" :href="item.url" :underline="false"
                                                 :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                                    </span>
                                        </el-form-item>
                                        <el-form-item label="资讯材料">
                                    <span v-for="item in props.row.file">
                                        <el-link target="_blank" :href="item.url" :underline="false"
                                                 :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                                    </span>
                                        </el-form-item>
                                    </el-form>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    prop="id"
                                    label="id"
                                    width="180">
                            </el-table-column>
                            <el-table-column
                                    prop="title"
                                    label="资讯名称"
                                    width="180">
                            </el-table-column>
                            <el-table-column
                                    prop="abroad"
                                    label="资讯类型"
                                    width="180">
                                <template slot-scope="abroad">
                                    <el-button type="text" v-if="abroad.row.abroad === 1">国内</el-button>
                                    <el-button type="text" v-if="abroad.row.abroad === 2">国外</el-button>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="操作"
                                    width="180">
                                <template slot-scope="cz">
                                    <el-button type="text" @click="del(cz.row.id)">删除</el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-col>
                </el-row>
            </el-tab-pane>
            <el-tab-pane label="资讯信息添加" name="second">
                <el-row>
                    <el-col :span="10">
                        <el-form :model="form" status-icon :rules="rules" ref="ruleForm" label-width="120px"
                                 class="demo-ruleForm"
                                 :hide-required-asterisk="true"
                                 :status-icon="true">
                            <el-form-item label="资讯名称" prop="title">
                                <el-input type="text" v-model="form.title"></el-input>
                            </el-form-item>
                            <el-form-item label="资讯类别" prop="abroad">
                                <el-radio v-model="form.abroad" label="1">国内</el-radio>
                                <el-radio v-model="form.abroad" label="2">国外</el-radio>
                            </el-form-item>
                            <el-form-item label="资讯简介" prop="description">
                                <el-input placeholder="请输入资讯简介" v-model="form.description" type="textarea"
                                          :rows="2"></el-input>
                            </el-form-item>
                            <el-form-item label="资讯内容" prop="content">
                                <el-input placeholder="请输入资讯简介" v-model="form.content" type="textarea"
                                          :rows="2"></el-input>
                            </el-form-item>
                            <el-form-item label="资讯图片" prop="thumb">
                                <el-upload
                                        class="upload-demo"
                                        :action="upload"
                                        :on-remove="handleRemove"
                                        :on-success="handleAvatarSuccess1"
                                        :before-upload="beforePhoneUpload"
                                        :file-list="form.thumb"
                                        list-type="picture">
                                    <el-button>点击上传(可选择上传)</el-button>
                                </el-upload>
                            </el-form-item>
                            <el-form-item label="资讯附属文件" prop="file">
                                <el-upload
                                        class="upload-demo"
                                        :action="uploadFile"
                                        :on-remove="handleRemove1"
                                        :before-upload="beforeFileUpload"
                                        :on-success="handleFileSuccess"
                                        :file-list="form.file">
                                    <el-button>点击上传(可选择上传)</el-button>
                                </el-upload>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" @click="add">添加</el-button>
                                <el-button @click="reset()">重置</el-button>
                            </el-form-item>
                        </el-form>
                    </el-col>
                </el-row>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>
<script>
    export default {
        name: "NewsManage",
        data() {
            return {
                activeName: 'first',
                uploadFile: this.$api.UPLOADFILE,
                upload: this.$api.UPLOAD,
                form: {
                    abroad: "",
                    title: "",
                    file: [],
                    thumb: [],
                    description: "",
                    content: "",
                    time: new Date().toLocaleString(),
                },
                value: "",
                rules: {
                    title: [
                        {required: true, message: '请输入资讯标题', trigger: 'blur'},
                    ],
                    abroad: [
                        {required: true, message: '请选择资讯类型', trigger: 'blur'},
                    ],
                    content: [
                        {required: true, message: '请输入资讯内容', trigger: 'blur'},
                    ],
                    description: [
                        {required: true, message: '请输入资讯简介', trigger: 'blur'},
                    ],
                },
                tableData: []
            }
        },
        methods: {
            getData() {
                this.$axios.get(this.$api.NEWS, {
                    type: "ht"
                }).then(res => {
                    if (res.data.code === 200) {
                        res.data.data.forEach(function (value, index) {
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                        });
                        this.tableData = res.data.data;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            handleRemove1(file) {
                for (let i = 0; i < this.form.file.length; i++) {
                    if (file.name === this.form.file[i].name) {
                        this.form.file.splice(i, i + 1)
                    }
                }
            },
            handleRemove(file) {
                for (let i = 0; i < this.form.thumb.length; i++) {
                    if (file.name === this.form.thumb[i].name) {
                        this.form.thumb.splice(i, i + 1)
                    }
                }
            },
            beforePhoneUpload(file) {
                const typeArr = ["image/jpeg", "image/jpg", "image/png"];
                const isLt5M = file.size / 1024 / 1024 < 2;
                if (!typeArr.includes(file.type)) {
                    this.$message.error("上传的图片格式有误，请重新上传！");
                    return false;
                }
                if (!isLt5M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                    return false;
                }
            },
            beforeFileUpload(file) {
                const typeArr = ["application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/zip"];
                const isLt5M = file.size / 1024 / 1024 < 5;
                if (!typeArr.includes(file.type)) {
                    this.$message.error("上传的文件格式有误，请重新上传！");
                    return false;
                }
                if (!isLt5M) {
                    this.$message.error('上传文件大小不能超过 5MB!');
                    return false;
                }
            },
            handleFileSuccess(res, file) {
                if (res === "error") {
                    this.$message.error("上传失败")
                } else {
                    let a = file.name.lastIndexOf(".");
                    let obj = {};
                    obj.name = file.name.slice(0, a);
                    obj.url = res;
                    this.form.file.push(obj);
                }
            },
            handleAvatarSuccess1(res, file) {
                if (res === "error") {
                    this.$message.error("上传失败")
                } else {
                    let a = file.name.lastIndexOf(".");
                    let obj = {};
                    obj.name = file.name.slice(0, a);
                    obj.url = res;
                    this.form.thumb.push(obj);
                }
            },
            handleClick(tab, event) {
                // console.log(tab, event);
            },
            reset() {
                this.$refs.ruleForm.resetFields();
                this.form.abroads = "";
            },
            add() {
                this.$refs.ruleForm.validate((val) => {
                    if (val) {
                        this.$confirm('是否选择添加该资讯?', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            type: 'warning'
                        }).then(() => {
                            if (this.form.file) {
                                this.form.file = JSON.stringify(this.form.file);
                            }
                            if (this.form.thumb) {
                                this.form.thumb = JSON.stringify(this.form.thumb);
                            }
                            this.$axios.post(this.$api.NEWS, this.form).then(res => {
                                if (res.data.code === 200) {
                                    this.$message.success(res.data.msg);
                                    this.reset();
                                    this.getData();
                                } else {
                                    this.$message.error(res.data.msg);
                                    this.reset();
                                    this.getData();
                                }
                            })
                        }).catch(() => {
                            this.$message({
                                type: 'info',
                                message: '已取消添加'
                            });
                        });
                    } else {
                        return false;
                    }
                });
            },
            tableDbEdit(row, column, cell, event) {
                if (column.label != "id") {
                    if (column.property == "title") {
                        event.target.innerHTML = "";
                        let input = document.createElement("input");
                        input.setAttribute("type", "text");
                        input.value = row.title;
                        input.style.width = "80%";
                        input.style.height = "80%";
                        cell.appendChild(input);
                        let _this = this;
                        input.onblur = function () {
                            cell.removeChild(input);
                            if (input.value != row.title) {
                                event.target.innerHTML = input.value;
                                row.title = input.value;
                                _this.$axios.put(_this.$api.NEWS, {
                                    type: "title",
                                    title: row.title,
                                    id: row.id
                                }).then(res => {
                                    if (res.data.code === 200) {
                                        _this.getData();
                                        _this.$message.success(res.data.msg)
                                    } else {
                                        _this.$message.error(res.data.msg)
                                    }
                                })
                            } else {
                                event.target.innerHTML = row.title;
                            }
                        }
                    }
                    if (column.property == "abroad") {
                        this.$confirm('是否选择修改该资讯类型?', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            type: 'warning'
                        }).then(() => {
                            let a = "";
                            if (row.abroad === 1) {
                                a = 2;
                            } else {
                                a = 1;
                            }
                            this.$axios.put(this.$api.NEWS, {
                                a,
                                type: "abroad",
                                id: row.id
                            }).then(res => {
                                if (res.data.code === 200) {
                                    this.getData();
                                    this.$message.success(res.data.msg)
                                } else {
                                    this.$message.error(res.data.msg)
                                }
                            })
                        }).catch(() => {
                            this.$message({
                                type: 'info',
                                message: '已取消添加'
                            });
                        });
                    }
                }
            },
            del(id) {
                this.$confirm('是否选择删除该信息?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$axios.delete(this.$api.NEWS, {id}).then(res => {
                        if (res.data.code === 200) {
                            this.$message.success(res.data.msg);
                            this.getData();
                        } else {
                            this.$message.error(res.data.msg);
                            this.getData();
                        }
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消添加'
                    });
                });
            },
            edit() {

            }
        },
        mounted() {
            this.getData();
        }
    }
</script>

<style scoped lang="scss">

    .el-form-item__label {
        text-align: center !important;
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

    .el-row {
        margin-bottom: 20px;
    }

    .el-table .warning-row {
        background: oldlace;
    }

    .el-table .success-row {
        background: #f0f9eb;
    }

    .demo-table-expand {
        font-size: 0;
    }

    .demo-table-expand label {
        width: 90px;
        color: #99a9bf;
    }

    .demo-table-expand .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 100%;
    }

</style>