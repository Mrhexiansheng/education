<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>个人项目查看</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
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
                                    <el-button type="text" v-for="item in props.row.member">{{item.realname}}
                                    </el-button>
                                </el-form-item>
                                <el-form-item label="项目简述">
                                    <el-button type="text">{{ props.row.description}}</el-button>
                                </el-form-item>
                                <el-form-item label="项目申请时间">
                                    <el-button type="text">{{ props.row.time}}</el-button>
                                </el-form-item>
                                <el-form-item label="项目图片">
                                    <span v-for="item in props.row.thumb">
                                        <el-link target="_blank" :href="item.url" :underline="false" :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                                    </span>
                                </el-form-item>
                                <el-form-item label="项目材料">
                                    <span v-for="item in props.row.file">
                                        <el-link target="_blank" :href="item.url" :underline="false" :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                                    </span>
                                </el-form-item>
                                <el-form-item label="项目审核进度">
                                    <el-steps :active="state" :simple="false">
                                        <el-step title="未审核" icon="el-icon-close"></el-step>
                                        <el-step title="正在审核" icon="el-icon-loading"></el-step>
                                        <el-step :title=final icon="el-icon-check"></el-step>
                                    </el-steps>
                                </el-form-item>
                            </el-form>
                        </el-col>
                    </el-row>
                </template>
            </el-table-column>
            <el-table-column
                    prop="project_number"
                    label="项目编号"
                    width="170">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="项目名称"
                    width="260">
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
                    prop="teachers_title"
                    label="职称"
                    width="70">
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
                    width="80">
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
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="states"
                    label="审核状态"
                    width="80">
                <template #default="states">
                    <el-button type="text" v-if="states.row.states === 1">审核通过</el-button>
                    <el-button type="text" v-if="states.row.states === 2">审核失败</el-button>
                    <el-button type="text" v-if="states.row.states === 3">未审核</el-button>
                    <el-button type="text" v-if="states.row.states === 4">审核中</el-button>
                </template>
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="80">
                <template #default="cz">
                    <el-button type="text" @click="submit(cz.row.id)">提交审核</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        name: "PersonalProject",
        data() {
            return {
                research_project: [],
                tableData: [],
                state:1,
                final:"审核结果",
            }
        },
        methods: {
            getData() {
                this.$axios.get(this.$api.PROJECT, {
                    username: sessionStorage.getItem("username"),
                    view:"view"
                }).then(res => {
                    if (res.data.code === 200) {
                        let _this = this;
                        res.data.data.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (value.score) {
                                value.score = JSON.parse(value.score)
                            }
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                            if (value.states === 1){
                                _this.state = 3;
                                _this.final = "审核成功"
                            }
                            if (value.states === 2){
                                _this.state = 3;
                                _this.final = "审核失败"
                            }
                            if (value.states === 3){
                                _this.state = 1;
                                _this.final = "审核失败"
                            }
                            if (value.states === 4){
                                _this.state = 2;
                                _this.final = "审核中"
                            }
                        });
                        this.tableData = res.data.data;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            submit(id) {
                this.$axios.put(this.$api.PROJECT, {
                    id: id,
                    username: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        this.$message.success(res.data.msg)
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

<style scoped>

</style>