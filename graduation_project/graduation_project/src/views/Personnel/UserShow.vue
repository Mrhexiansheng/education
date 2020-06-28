<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>用户管理</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-row>
            <el-col :span="6">
                <el-form :model="form">
                    <el-form-item>
                        <el-input placeholder="请输入您要搜索的名字" v-model="form.search">
                            <el-button icon="el-icon-search" circle slot="append" @click="search"></el-button>
                        </el-input>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
        <el-table
                :data="tableData"
                style="width: 100%"
                :row-class-name="tableRowClassName"
                :header-cell-style="{'text-align':'center'}"
                :cell-style="{'text-align':'center'}"
        >
            <el-table-column type="expand">
                <template slot-scope="props">
                    <el-form label-position="left" inline class="demo-table-expand">
                        <el-form-item label="职位">
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            <el-button type="text">{{props.row.position}}</el-button>
                        </el-form-item>
                    </el-form>
                </template>
            </el-table-column>
            <el-table-column
                    prop="realname"
                    label="姓名"
                    width="80">
            </el-table-column>
            <el-table-column
                    prop="college"
                    label="所属学院"
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="teachers_title"
                    label="职称"
                    width="110">
                <template slot-scope="teachers_title">
                    <el-button type="text" v-if="teachers_title.row.teachers_title === 1">助教</el-button>
                    <el-button type="text" v-if="teachers_title.row.teachers_title === 2">讲师</el-button>
                    <el-button type="text" v-if="teachers_title.row.teachers_title === 3">副教授</el-button>
                    <el-button type="text" v-if="teachers_title.row.teachers_title === 4">教授</el-button>
                </template>
            </el-table-column>
            <el-table-column
                    prop="degree"
                    label="学位"
                    width="110">
                <template slot-scope="degree">
                    <el-button type="text" v-if="degree.row.degree === 1">学士</el-button>
                    <el-button type="text" v-if="degree.row.degree === 2">硕士</el-button>
                    <el-button type="text" v-if="degree.row.degree === 3">博士</el-button>
                </template>
            </el-table-column>
            <el-table-column
                    prop="phone"
                    label="联系电话"
                    width="150">
            </el-table-column>
            <el-table-column
                    prop="state"
                    label="账号状态"
                    width="110">
                <template slot-scope="state">
                    <el-button type="text" v-if="state.row.state === 1">白名单</el-button>
                    <el-button type="text" v-if="state.row.state === 2">黑名单</el-button>
                </template>
            </el-table-column>
            <el-table-column
                    prop="last_login_time"
                    label="上次登录时间"
                    width="210">
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="250">
                <template slot-scope="cz">
                    <el-button type="text" @click="changeState(cz.row.id,cz.row.state)" v-if="cz.row.state === 1">加入黑名单
                    </el-button>
                    <el-button type="text" @click="changeState(cz.row.id,cz.row.state)" v-if="cz.row.state === 2">加入白名单
                    </el-button>
                    <el-button type="text" @click="del(cz.row.id)">删除</el-button>
                    <el-button type="text" @click="reset(cz.row.id)">密码重置</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
                layout="prev, pager, next"
                :page-size.sync="size"
                :current-page.sync="page"
                :total="total"
                @size-change="sizeChange"
                @current-change="currentChange"
        >
        </el-pagination>
    </div>
</template>

<script>
    export default {
        name: "UserShow",
        data() {
            return {
                tableData: [],
                size: 7,
                page: 1,
                total: 0,
                message: "",
                number: 0,
                memberLength: 0,
                form: {
                    search: "",
                }
            }
        },
        methods: {
            tableRowClassName({row, rowIndex}) {
                if (rowIndex === 1) {
                    return 'warning-row';
                } else if (rowIndex === 3) {
                    return 'success-row';
                }
                return '';
            },
            getData() {
                this.$axios.get(this.$api.USER, {
                    size: this.size,
                    page: this.page
                }).then(res => {
                    if (res.data.code === 200) {
                        this.tableData = res.data.data;
                        this.total = res.data.total;
                    } else {
                        this.$message.error("获取失败")
                    }
                })
            },
            del(id) {
                this.$confirm("是否确认删除该用户", '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                    this.$axios.delete(this.$api.DELETEUSER, {id}).then(res => {
                        if (res.data.code === 200) {
                            this.$message.success(res.data.msg);
                            this.getData();
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
            changeState(id, state) {
                if (state === 1) {
                    this.message = "确认加入黑名单吗？"
                } else {
                    this.message = "确认重新加入白名单吗？"
                }
                if (state === 1) {
                    state = 2;
                } else {
                    state = 1;
                }
                this.$confirm(this.message, '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                    this.$axios.put(this.$api.USER, {id, state}).then(res => {
                        if (res.data.code === 200) {
                            this.$message.success("修改成功");
                            this.getData();
                        } else {
                            this.$message.error(res.data.msg)
                        }
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消修改'
                    });
                });
            },
            reset(id) {
                this.$confirm("是否确认重置密码", '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                    this.$axios.post(this.$api.RESETPASS, {id}).then(res => {
                        if (res.data.code === 200) {
                            this.$message.success("重置成功");
                        } else {
                            this.$message.error(res.data.msg)
                        }
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消重置'
                    });
                });
            },
            sizeChange(val) {
                this.page = val;
                this.getData();
            },
            currentChange(val) {
                this.page = val;
                this.getData();
            },
            search() {
                this.$axios.get(this.$api.USER, this.form).then(res => {
                    if (res.data.code === 200) {
                        this.tableData = res.data.data;
                        this.total = 1;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>

<style scoped lang="scss">
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
        width: 50%;
    }
</style>