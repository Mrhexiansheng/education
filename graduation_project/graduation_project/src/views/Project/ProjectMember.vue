<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>项目成员查看</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-table
                :data="tableData"
                style="width: 100%"
                :header-cell-style="{'text-align':'center'}"
                :cell-style="{'text-align':'center'}"
        >
            <el-table-column
                    prop="realname"
                    label="姓名"
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="college"
                    label="所属学院"
                    width="200">
            </el-table-column>
            <el-table-column
                    prop="teachers_title"
                    label="职称"
                    width="200">
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
                    width="200">
                <template slot-scope="degree">
                    <el-button type="text" v-if="degree.row.degree === 1">学士</el-button>
                    <el-button type="text" v-if="degree.row.degree === 2">硕士</el-button>
                    <el-button type="text" v-if="degree.row.degree === 3">博士</el-button>
                </template>
            </el-table-column>
            <el-table-column
                    prop="phone"
                    label="联系电话"
                    width="200">
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="200"
            >
                <template slot-scope="cz">
                    <el-button type="text" @click="del(cz.row.username)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        name: "ProjectMember",
        data() {
            return {
                tableData: [],
                id: "",   //这里指的是p.id
                length: 0
            }
        },
        methods: {
            //获取参研项目信息  获取项目信息，获取项目成员信息  分开展示
            getData() {
                this.$axios.get(this.$api.USER, {
                    username_member: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        this.tableData = res.data.data;
                    } else {
                        this.$message.error(res.data.msg);
                    }
                })
            },
            del(username) {
                this.$confirm("是否确认删除该用户", '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                    this.$axios.delete(this.$api.USER, {
                        username: sessionStorage.getItem("username"),
                        delusername: username
                    }).then(res => {
                        if (res.data.code === 200) {
                            this.$message.success(res.data.msg);
                            this.getData();
                        } else {
                            this.$message.error(res.data.msg)
                        }
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
        },
        mounted() {
            this.getData();
        }
    }
</script>

<style scoped>

</style>