<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>部门管理</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-table
                :data="tableData"
                style="width: 100%"
                :row-class-name="tableRowClassName"
        >
            <el-table-column
                    prop="id"
                    label="id"
                    width="100">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="部门名称"
                    width="180">
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="150">
                <template slot-scope="cz">
                    <el-button type="text" @click="view(cz.row.id)">查看</el-button>
                    <el-button type="text" @click="del(cz.row.id)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        name: "DepartmentManage",
        data(){
            return{
                tableData: []
            }
        },
        methods:{
            tableRowClassName({row, rowIndex}) {
                if (rowIndex === 1) {
                    return 'warning-row';
                } else if (rowIndex === 3) {
                    return 'success-row';
                }
                return '';
            },
            getData() {
                this.$axios.get(this.$api.DEPARTMENT).then(res => {
                    if (res.data.code === 200) {
                        this.tableData = res.data.data;
                    }else{
                        this.$message.error("获取失败")
                    }
                })
            },
            del(id){
                console.log(id);
            },
            view(id){
                console.log(id);
            },
        },
        mounted() {
            this.getData();
        }
    }
</script>

<style scoped>
    .el-table .warning-row {
        background: oldlace;
    }

    .el-table .success-row {
        background: #f0f9eb;
    }
</style>