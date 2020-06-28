<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>课题研究</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
    </div>
</template>

<script>
    export default {
        name: "SubjectManage"
    }
</script>

<style scoped>

</style>