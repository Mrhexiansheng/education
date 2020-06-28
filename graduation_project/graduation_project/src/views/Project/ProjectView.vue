<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>项目查看</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="审核通过" name="first">
                <el-table
                        :data="tableData1"
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
                                            <el-button type="text">{{ props.row.description }}</el-button>
                                        </el-form-item>
                                        <el-form-item label="项目申请时间">
                                            <el-button type="text">{{ props.row.time }}</el-button>
                                        </el-form-item>
                                        <el-form-item label="项目图片">
                                    <span v-for="item in props.row.thumb">
                                        <el-link target="_blank" :href="item.url" :underline="false"
                                                 :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                                    </span>
                                        </el-form-item>
                                        <el-form-item label="项目材料">
                                    <span v-for="item in props.row.file">
                                        <el-link target="_blank" :href="item.url" :underline="false"
                                                 :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                                    </span>
                                        </el-form-item>
                                    </el-form>
                                </el-col>
                            </el-row>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="项目名称"
                            width="300">
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
                            <el-button type="text" v-if="states.row.states === 4">审核中</el-button>
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
            </el-tab-pane>
            <el-tab-pane label="审核失败" name="third">
                <el-table
                        :data="tableData2"
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
                                            <el-button type="text">{{ props.row.description }}</el-button>
                                        </el-form-item>
                                        <el-form-item label="项目申请时间">
                                            <el-button type="text">{{ props.row.time }}</el-button>
                                        </el-form-item>
                                        <el-form-item label="项目图片">
                                    <span v-for="item in props.row.thumb">
                                        <el-link target="_blank" :href="item.url" :underline="false"
                                                 :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                                    </span>
                                        </el-form-item>
                                        <el-form-item label="项目材料">
                                    <span v-for="item in props.row.file">
                                        <el-link target="_blank" :href="item.url" :underline="false"
                                                 :download="item.name"><el-button type="text">{{item.name}}</el-button></el-link><br>
                                    </span>
                                        </el-form-item>
                                    </el-form>
                                </el-col>
                            </el-row>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="项目名称"
                            width="300">
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
                            <el-button type="text" v-if="states.row.states === 4">审核中</el-button>
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
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    export default {
        name: "ProjectView",
        data() {
            return {
                time: "",
                search1: "",
                search2: "",
                search3: "",
                size: 10,
                page: 1,
                total: 0,
                tableData1: [],
                tableData2: [],
                reverse: true,
                activeName: 'first'
            }
        },
        methods: {
            sizeChange(val) {
                this.page = val;
            },
            currentChange(val) {
                this.page = val;
            },
            getData() {
                this.$axios.get(this.$api.PROJECT, {
                    size: this.size,
                    page: this.page,
                    username: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        res.data.data1.forEach(function (value, index) {
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
                        });
                        res.data.data2.forEach(function (value, index) {
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
                        });
                        this.tableData1 = res.data.data1;
                        this.tableData2 = res.data.data2;
                        // this.total = res.data.total;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            handleClick(tab, event) {
                // console.log(tab, event);
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>

<style scoped>
    .form {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-around;
    }

    .el-form-item {
        width: 50%;
        box-sizing: border-box;
    }

    .el-timeline {
        margin-top: 10px;
    }

    .el-form-item__content {
        width: 100%;
    }
</style>