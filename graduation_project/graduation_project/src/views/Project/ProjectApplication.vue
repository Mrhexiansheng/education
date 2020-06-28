<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>项目申请</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-tabs v-model="activeName">
            <el-tab-pane label="申请项目" name="first">
                <el-row>
                    <el-col :span="8">
                        <el-form label-width="100px" :model="form" :rules="rules" ref="applyForm"
                                 :hide-required-asterisk="true"
                                 :status-icon="true">
                            <el-form-item label="项目申报人" prop="realname">
                                <el-input placeholder="请输入项目申报人" v-model="form.realname" disabled></el-input>
                            </el-form-item>
                            <el-form-item label="项目名称" prop="name">
                                <el-input placeholder="请输入项目名称" v-model="form.name"></el-input>
                            </el-form-item>
                            <el-form-item label="项目简介" prop="description">
                                <el-input placeholder="请输入项目简介" v-model="form.description" type="textarea"
                                          :rows="2"></el-input>
                            </el-form-item>
                            <el-form-item label="项目关键词" prop="keywords">
                                <el-input placeholder="请输入项目关键词" v-model="form.keywords"></el-input>
                            </el-form-item>
                            <el-form-item label="项目类型" prop="level">
                                <el-select v-model="form.level" placeholder="请选择">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="项目类别" prop="type">
                                <el-select v-model="form.type" placeholder="请选择">
                                    <el-option
                                            v-for="item in options1"
                                            :key="item.id"
                                            :label="item.type"
                                            :value="item.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="项目文件" prop="file">
                                <el-upload
                                        class="upload-demo"
                                        :action="uploadFile"
                                        :on-remove="handleRemove1"
                                        :before-upload="beforeFileUpload"
                                        :on-success="handleFileSuccess"
                                        :file-list="form.file">
                                    <el-button>点击上传</el-button>
                                </el-upload>
                            </el-form-item>
                            <el-form-item label="项目相关图片" prop="thumb">
                                <el-upload
                                        class="upload-demo"
                                        :action="upload"
                                        :on-remove="handleRemove"
                                        :on-success="handleAvatarSuccess1"
                                        :before-upload="beforePhoneUpload"
                                        :file-list="form.thumb"
                                        list-type="picture">
                                    <el-button>点击上传</el-button>
                                </el-upload>
                            </el-form-item>
                            <el-form-item>
                                <el-button style="width: 80%" @click="apply">提交</el-button>
                            </el-form-item>
                        </el-form>
                    </el-col>
                </el-row>
            </el-tab-pane>
            <el-tab-pane label="加入项目" name="second">
                <el-row>
                    <el-col :span="8">
                        <el-input placeholder="请输入您要搜索的项目秘钥(请勿泄露)" v-model="search_number">
                            <el-button slot="append" icon="el-icon-search" @click="search"></el-button>
                        </el-input>
                    </el-col>
                </el-row>
                <el-table
                        :data="tableData"
                        style="width: 100%"
                        :header-cell-style="{'text-align':'center'}"
                        :cell-style="{'text-align':'center'}">
                    <el-table-column type="expand">
                        <template slot-scope="props">
                            <el-row>
                                <el-col>
                                    <el-form label-position="left" class="demo-table-expand">
                                        <el-form-item label="项目成员">
                                            <el-button type="text" v-for="item in props.row.member" :key="item.index">
                                                {{item}}
                                            </el-button>
                                        </el-form-item>
                                        <el-form-item label="项目简述">
                                            <el-button type="text">{{ props.row.description }}</el-button>
                                        </el-form-item>
                                        <el-form-item label="项目申请时间">
                                            <el-button type="text">{{ props.row.time }}</el-button>
                                        </el-form-item>
                                        <el-form-item label="项目审核进度">
                                            <el-steps :active="1" :simple="false">
                                                <el-step title="未审核" icon="el-icon-close"></el-step>
                                                <el-step title="正在审核" icon="el-icon-loading"></el-step>
                                                <el-step title="审核成功" icon="el-icon-check"></el-step>
                                            </el-steps>
                                        </el-form-item>
                                    </el-form>
                                </el-col>
                            </el-row>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="项目名称"
                            width="220">
                    </el-table-column>
                    <el-table-column
                            prop="realname"
                            label="项目负责人"
                            width="100">
                    </el-table-column>
                    <el-table-column
                            prop="college"
                            label="所属学院"
                            width="140">
                    </el-table-column>
                    <el-table-column
                            prop="role"
                            label="职称"
                            width="100">
                        <template slot-scope="role">
                            <el-button type="text" v-if="role.row.teachers_title === 1">助教</el-button>
                            <el-button type="text" v-if="role.row.teachers_title === 2">讲师</el-button>
                            <el-button type="text" v-if="role.row.teachers_title === 3">副教授</el-button>
                            <el-button type="text" v-if="role.row.teachers_title === 4">教授</el-button>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="level"
                            label="项目类型"
                            width="180">
                        <template #default="level">
                            <el-button type="text" v-if="level.row.level === 1">重点项目</el-button>
                            <el-button type="text" v-if="level.row.level === 2">一般项目</el-button>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="type"
                            label="项目类别"
                            width="140">
                    </el-table-column>
                    <el-table-column
                            prop="phone"
                            label="联系电话"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            prop="states"
                            label="审核状态"
                            width="100">
                        <template #default="states">
                            <el-button type="text" v-if="states.row.states === 1">审核通过</el-button>
                            <el-button type="text" v-if="states.row.states === 2">审核失败</el-button>
                            <el-button type="text" v-if="states.row.states === 3">未审核</el-button>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="操作"
                            width="80">
                        <template #default="cz">
                            <el-button type="text" @click="join(cz.row.id)">申请</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    export default {
        name: "ProjectApplication",
        data() {
            return {
                activeName: 'first',
                count: 0,
                form: {
                    time: new Date().toLocaleString(),
                    name: "",
                    file: [],
                    thumb: [],
                    keywords: "",
                    description: "",
                    type: "",
                    level: "",
                    realname: sessionStorage.getItem("realname"),
                    project_number: "",
                    search_number: this.$md5(Math.floor(new Date().getTime() / (Math.floor(Math.random() * 10 + 1)))),
                    username: sessionStorage.getItem("username"),
                    member: [],
                },
                rules: {
                    realname: [
                        {required: true, message: '请输入项目负责人', trigger: 'blur'},
                    ],
                    name: [
                        {required: true, message: '请输入项目名称', trigger: 'blur'},
                    ],
                    file: [
                        {required: true, message: '请上传项目所需文件', trigger: 'blur'},
                    ],
                    thumb: [
                        {required: true, message: '请选择项目有关图片', trigger: 'blur'},
                    ],
                    keywords: [
                        {required: true, message: '请输入项目关键词', trigger: 'blur'},
                    ],
                    description: [
                        {required: true, message: '请输入项目简述', trigger: 'blur'},
                    ],
                    type: [
                        {required: true, message: '请选择项目类别', trigger: 'blur'},
                    ],
                    level: [
                        {required: true, message: '请选择项目类型', trigger: 'blur'},
                    ],
                },
                uploadFile: this.$api.UPLOADFILE,
                upload: this.$api.UPLOAD,
                options: [{
                    value: 1,
                    label: '重点项目'
                }, {
                    value: 2,
                    label: '一般项目'
                }],
                options1: [],
                value: '',
                tableData: [],
                search_number: "",
                oldmember: [],
                flag: true,
                flag1: true,
                research_project: [], // 服务于项目申请人
                research_project1: [],  // 服务于除项目申请人之外的用户
                id: "",  //接收一下此时搜索到的要申请的项目的id和名称
                name: ""
            }
        },
        methods: {
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
            handleRemove(file) {
                for (let i = 0; i < this.form.thumb.length; i++) {
                    if (file.name === this.form.thumb[i].name) {
                        this.form.thumb.splice(i, i + 1)
                    }
                }
            },
            handleRemove1(file) {
                for (let i = 0; i < this.form.file.length; i++) {
                    if (file.name === this.form.file[i].name) {
                        this.form.file.splice(i, i + 1)
                    }
                }
            },
            apply() {
                this.$confirm("是否确定申请该项目？", '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                    this.$refs.applyForm.validate(val => {
                        if (val) {
                            let year = new Date().getFullYear();
                            let month = new Date().getMonth();
                            let day = new Date().getDate();
                            if (month < 10) {
                                month = month + 1;
                                this.form.project_number = "NU" + year + "0" + month + day + this.form.type + this.form.level + this.count + "ER";
                            } else {
                                month = month + 1;
                                this.form.project_number = "NU" + year + month + day + this.form.type + this.form.level + this.count + "ER";
                            }
                            console.log(this.form.project_number);
                            this.form.file = JSON.stringify(this.form.file);
                            this.form.thumb = JSON.stringify(this.form.thumb);
                            //转化当前申请人的个人信息
                            let obj = {};
                            obj.username = sessionStorage.getItem("username");
                            obj.realname = sessionStorage.getItem("realname");
                            this.form.member.push(obj);
                            this.form.member = JSON.stringify(this.form.member);
                            this.$axios.post(this.$api.PROJECT, this.form).then(res => {
                                if (res.data.code === 200) {
                                    this.open();
                                    this.updateResearchProject(res.data.data);
                                    this.$message.success(res.data.msg);
                                    this.$refs.applyForm.resetFields();
                                } else {
                                    this.$message.error(res.data.msg);
                                    this.$refs.applyForm.resetFields();
                                }
                            })
                        } else {
                            this.$message.error("请检查内容是否输入正确！")
                        }
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消申请'
                    });
                })
            },
            getProjectType() {
                this.$axios.get(this.$api.PROJECT_TYPE).then(res => {
                    if (res.data.code === 200) {
                        this.options1 = res.data.data;
                        this.count = res.data.count + 1;
                    } else {
                        this.$message.error("获取失败")
                    }
                })
            },
            //打开搜索秘钥
            open() {
                this.$notify({
                    title: '请务必记住搜索秘钥，关闭以后将不再提示，如不慎丢失，请联系管理员。',
                    message: "搜索秘钥:" + this.form.search_number,
                    duration: 0,
                    type: 'success'
                });
            },
            //拿到秘钥进行搜索，此时就把当前用户信息添加到oldmember
            search() {
                if (!this.search_number) {
                    this.$message.error("请正确输入搜索秘钥！")
                } else {
                    this.$axios.put(this.$api.PROJECT, {
                        search_number: this.search_number,
                        username: sessionStorage.getItem("username")
                    }).then(res => {
                        if (res.data.code === 200) {
                            let arr1 = [];
                            if (res.data.data[0].member) {
                                let arr = (JSON.parse(res.data.data[0].member));
                                arr.forEach(function (value, index) {
                                    arr1.push(++index + "." + " " + value.realname + " ");
                                });
                            }
                            res.data.data[0].member = arr1;
                            this.tableData = res.data.data;
                            this.id = res.data.data[0].id;
                            this.name = res.data.data[0].name;
                            this.$message.success(res.data.msg);
                            this.oldmember = JSON.parse(res.data.member);  //从数据库中获取到的原始数据
                            this.research_project1 = JSON.parse(res.data.research_project)
                        } else {
                            this.tableData = [];
                            this.$message.error(res.data.msg);
                        }
                    })
                }
            },
            join(id) {
                this.$confirm("是否确认加入该项目", '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                    this.$axios.get(this.$api.PROJECT, {
                        id: id,
                        yzsq: "验证申请"
                    }).then(res => {
                        if (res.data.code === 200) {
                            let obj = {};
                            obj.username = sessionStorage.getItem("username");
                            obj.realname = sessionStorage.getItem("realname");
                            //数组filter去重不好去，用一个flag来控制是否push进去
                            for (let i = 0; i < this.oldmember.length; i++) {
                                if (obj.realname === this.oldmember[i].realname) {
                                    this.flag = false;
                                }
                            }
                            if (this.flag === true) {
                                this.oldmember.push(obj)
                            }
                            let obj1 = {};
                            obj1.id = this.id;
                            obj1.name = this.name;
                            for (let i = 0; i < this.research_project1.length; i++) {
                                if (obj1.id === this.research_project1[i].id) {
                                    this.flag1 = false;
                                }
                            }
                            if (this.flag === true) {
                                this.research_project1.push(obj1)
                            }
                            //判断此时的oldmember长度，如果 <= 5 ,正常操作，否则，直接报错
                            if (this.oldmember.length <= 5 && this.research_project1.length <= 2) {
                                this.oldmember = JSON.stringify(this.oldmember);
                                this.research_project1 = JSON.stringify(this.research_project1);
                                this.$axios.put(this.$api.PROJECT, {
                                    member: this.oldmember,
                                    id,
                                    username: sessionStorage.getItem("username")
                                }).then(res => {
                                    if (res.data.code === 200) {
                                        this.$message.success(res.data.msg);  //反正也不会添加，报成功也可以
                                        this.updateResearchProject1(this.research_project1);
                                    } else {
                                        this.$message.error(res.data.msg)
                                    }
                                })
                            } else {
                                if (this.oldmember.length > 5) {
                                    this.$message.error("对不起，此科研小组成员已满，请重新申请！")
                                }
                                if (this.research_project1.length > 2) {
                                    this.$message.error("对不起，每人至多只能参与两个项目！")
                                }
                            }
                        } else {
                            this.$message.error(res.data.msg)
                        }
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消申请'
                    });
                });
            },
            //更新项目申请人的参研项目
            updateResearchProject(data) {
                console.log(data);
                let obj = {};
                obj.id = data.id;
                obj.name = data.name;
                this.research_project.push(obj);
                this.$axios.put(this.$api.UPDATERESEARCHPROJECT, {
                    research_project: JSON.stringify(this.research_project),
                    username: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        this.$message.success("参研项目更新成功")
                    } else {
                        this.$message.error("参研项目更新失败")
                    }
                })
            },
            //更新其他用户的参研项目信息
            updateResearchProject1(data) {
                this.$axios.put(this.$api.UPDATERESEARCHPROJECT, {
                    research_project: data,
                    username: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        this.$message.success("参研项目更新成功")
                    } else {
                        this.$message.error("参研项目更新失败")
                    }
                })
            },
        },
        mounted() {
            this.getProjectType();
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
</style>