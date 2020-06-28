<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>科研成果</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
    </div>
</template>

<script>
    export default {
        name: "ScientificManage"
    }
</script>

<style scoped>

</style>