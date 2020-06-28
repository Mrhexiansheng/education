<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item>前台信息管理</el-breadcrumb-item>
            <el-breadcrumb-item>导航管理</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-row>
            <el-col :span="14">
                <el-tabs v-model="activeName" @tab-click="handleClick">
                    <el-tab-pane label="导航信息" name="first">
                        <el-table
                                :data="tableData"
                                style="width: 100%"
                                :header-cell-style="{'text-align':'center'}"
                                :cell-style="{'text-align':'center'}"
                                @cell-dblclick="tableDbEdit"
                        >
                            <el-table-column
                                    prop="id"
                                    label="id"
                                    width="180">
                            </el-table-column>
                            <el-table-column
                                    prop="catname"
                                    label="导航名称"
                                    width="180">
                            </el-table-column>
                            <el-table-column
                                    prop="enname"
                                    label="导航英文名称"
                                    width="180">
                            </el-table-column>
                            <el-table-column
                                    label="操作"
                                    width="180">
                                <template slot-scope="cz">
                                    <el-button type="text" @click="del(cz.row.id)">删除</el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-tab-pane>
                    <el-tab-pane label="导航信息添加" name="second">
                        <el-row>
                            <el-col :span="14">
                                <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="100px"
                                         class="demo-ruleForm">
                                    <el-form-item label="导航名称" prop="catname">
                                        <el-input type="text" v-model="ruleForm.catname"></el-input>
                                    </el-form-item>
                                    <el-form-item label="导航英文名称" prop="enname">
                                        <el-input v-model.number="ruleForm.enname"></el-input>
                                    </el-form-item>
                                    <el-form-item>
                                        <el-button type="primary" @click="submitForm('ruleForm')">添加</el-button>
                                        <el-button @click="resetForm('ruleForm')">重置</el-button>
                                    </el-form-item>
                                </el-form>
                            </el-col>
                        </el-row>
                    </el-tab-pane>
                </el-tabs>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        name: "NavigationManagement",
        data() {
            var validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入导航名称'));
                } else {
                    callback();
                }
            };
            var validatePass2 = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入导航英文名称'));
                } else {
                    callback();
                }
            };
            return {
                tableData: [],
                activeName: 'first',
                ruleForm: {
                    catname: '',
                    enname: '',
                },
                rules: {
                    catname: [
                        {validator: validatePass, trigger: 'blur'}
                    ],
                    enname: [
                        {validator: validatePass2, trigger: 'blur'}
                    ],
                }
            }
        },
        methods: {
            handleClick(tab, event) {
                // console.log(tab, event);
            },
            getData() {
                this.$axios.get(this.$api.CATEGORY).then(res => {
                    if (res.data.code === 200) {
                        this.tableData = res.data.data;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            tableDbEdit(row, column, cell, event) {
                if (column.label != "id") {
                    if (column.property == "catname") {
                        event.target.innerHTML = "";
                        let input = document.createElement("input");
                        input.setAttribute("type", "text");
                        input.value = row.catname;
                        input.style.width = "80%";
                        input.style.height = "80%";
                        cell.appendChild(input);
                        let _this = this;
                        input.onblur = function () {
                            cell.removeChild(input);
                            if (input.value != row.catname) {
                                event.target.innerHTML = input.value;
                                row.catname = input.value;
                                _this.update(row.id, row.catname, row.enname);
                            } else {
                                event.target.innerHTML = row.catname;
                            }
                        }
                    }
                    if (column.property == "enname") {
                        event.target.innerHTML = "";
                        let input = document.createElement("input");
                        input.setAttribute("type", "text");
                        input.value = row.enname;
                        input.style.width = "80%";
                        input.style.height = "80%";
                        cell.appendChild(input);
                        let _this = this;
                        input.onblur = function () {
                            cell.removeChild(input);
                            if (input.value != row.enname) {
                                event.target.innerHTML = input.value;
                                row.enname = input.value;
                                _this.update(row.id, row.catname, row.enname);
                            } else {
                                event.target.innerHTML = row.enname;
                            }
                        }
                    }
                }
            },
            update(id, catname, enname) {
                this.$axios.put(this.$api.CATEGORY, {
                    id: id,
                    catname: catname,
                    enname: enname
                }).then(res => {
                    if (res.data.code === 200) {
                        this.$message.success(res.data.msg);
                        this.getData();
                    } else {
                        this.$message.error(res.data.msg);
                    }
                })
            },
            del(id) {
                this.$confirm('是否选择删除该导航?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$axios.delete(this.$api.CATEGORY, {id}).then(res => {
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
                        message: '已取消删除'
                    });
                });
            },
            submitForm(formName) {
                this.$refs[formName].validate((val) => {
                    if (val) {
                        this.$confirm('是否选择添加该导航?', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            type: 'warning'
                        }).then(() => {
                            this.$axios.post(this.$api.CATEGORY, this.ruleForm).then(res => {
                                if (res.data.code === 200) {
                                    this.getData();
                                    this.ruleForm.catname = "";
                                    this.ruleForm.enname = "";
                                    this.$message.success(res.data.msg);
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
                    } else {
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>

<style scoped>

</style>