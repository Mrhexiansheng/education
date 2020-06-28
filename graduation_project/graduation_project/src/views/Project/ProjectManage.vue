<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>立项管理</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="项目评分" name="first">
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
                                <el-form-item label="项目名称">
                                    <span>{{ props.row.name }}</span>
                                </el-form-item>
                                <el-form-item label="项目类别">
                                    <el-button type="text">{{props.row.type}}</el-button>
                                </el-form-item>
                                <el-form-item label="项目负责人">
                                    <el-button type="text">{{ props.row.realname }}</el-button>
                                </el-form-item>
                                <el-form-item label="审核状态">
                                    <el-button type="text" v-if="props.row.states === 1">审核通过</el-button>
                                    <el-button type="text" v-if="props.row.states === 2">审核失败</el-button>
                                    <el-button type="text" v-if="props.row.states === 3">未审核</el-button>
                                    <el-button type="text" v-if="props.row.states === 4">审核中</el-button>
                                </el-form-item>
                                <el-form-item label="项目成员">
                                    <el-button type="text" v-for="item in props.row.member">{{item.realname}}
                                    </el-button>
                                </el-form-item>
                                <el-form-item label="项目关键词">
                                    <span>{{ props.row.keywords }}</span>
                                </el-form-item>
                                <el-form-item label="项目类型">
                                    <el-button type="text" v-if="props.row.level === 1">重点项目</el-button>
                                    <el-button type="text" v-if="props.row.level === 2">一般项目</el-button>
                                    <el-button type="text" v-if="props.row.level === 3">小额</el-button>
                                </el-form-item>
                                <el-form-item label="项目描述">
                                    <span>{{ props.row.description }}</span>
                                </el-form-item>
                                <el-form-item label="项目申请时间">
                                    <span>{{ props.row.time }}</span>
                                </el-form-item>
                                <el-form-item label="项目在评专家">
                                    <el-button type="text" v-for="item in props.row.research_experts">{{item.realname}}
                                    </el-button>
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
                            </el-form>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="project_number"
                            label="项目编号"
                            width="200">
                    </el-table-column>
                    <el-table-column
                            prop="realname"
                            label="负责人姓名"
                            width="100">
                    </el-table-column>
                    <el-table-column
                            prop="college"
                            label="所属学院"
                            width="160">
                    </el-table-column>
                    <el-table-column
                            prop="teachers_title"
                            label="职称"
                            width="100">
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
                            width="100">
                        <template slot-scope="degree">
                            <el-button type="text" v-if="degree.row.degree === 1">学士</el-button>
                            <el-button type="text" v-if="degree.row.degree === 2">硕士</el-button>
                            <el-button type="text" v-if="degree.row.degree === 3">博士</el-button>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="申报项目"
                            width="285">
                    </el-table-column>
                    <el-table-column
                            prop="phone"
                            label="联系电话"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            label="操作"
                            width="120">
                        <template slot-scope="cz">
                            <el-button type="text" @click="grade(cz.row.id)">项目评分</el-button>
                            <el-dialog
                                    title="项目评分"
                                    :visible.sync="dialogVisible"
                                    width="20%"
                                    :before-close="handleClose">
                                <el-input v-model="score" placeholder="请对该项目进行评分"></el-input>
                                <span slot="footer" class="dialog-footer">
                                        <el-button @click="dialogVisible = false" size="small">取 消</el-button>
                                        <el-button type="primary" size="small"
                                                   @click="submit(cz.row.id)">确 定</el-button>
                                </span>
                            </el-dialog>
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
        name: "ProjectManage",
        data() {
            return {
                activeName: "first",
                tableData: [],
                size: 10,
                page: 1,
                total: 0,
                message: "",
                update_number: 0,
                searchData: "",
                select: '',
                value1: '',
                value2: '',
                show: false,
                dialogVisible: false,
                tableData1: [],
                multipleSelection: [],
                pid: "",
                score: ""
            }
        },
        methods: {
            getData() {
                this.$axios.get(this.$api.PROJECT, {
                    size: this.size,
                    page: this.page,
                    username: sessionStorage.getItem("username"),
                    require: "experts"
                }).then(res => {
                    if (res.data.code === 200) {
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
                        });
                        this.tableData = res.data.data;
                        this.total = res.data.total;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            sizeChange(val) {
                console.log(val);
                this.page = val;
                this.getData();
            },
            currentChange(val) {
                this.page = val;
                this.getData();
            },
            handleClick(tab, event) {
                console.log(tab, event);
            },
            tableRowClassName({row, rowIndex}) {
                if (rowIndex === 1) {
                    return 'warning-row';
                } else if (rowIndex === 3) {
                    return 'success-row';
                }
                return '';
            },
            handleClose(done) {
                this.$confirm('确认关闭？')
                    .then(_ => {
                        done();
                    })
                    .catch(_ => {
                    });
            },
            toggleSelection(rows) {
                if (rows) {
                    rows.forEach(row => {
                        this.$refs.multipleTable.toggleRowSelection(row);
                    });
                } else {
                    this.$refs.multipleTable.clearSelection();
                }
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            grade(id) {
                this.dialogVisible = true;
            },
            submit(id) {
                let arr = [];
                let obj = {};
                obj.score = this.score;
                obj.name = sessionStorage.getItem("realname");
                arr.push(obj);
                arr = JSON.stringify(arr);
                this.$axios.put(this.$api.PROJECT, {
                    score: arr,
                    id,
                    name: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        this.$message.success(res.data.msg);
                        this.score = "";
                        this.dialogVisible = false;
                    } else {
                        this.$message.error(res.data.msg);
                        this.score = "";
                        this.dialogVisible = false;
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

    .el-select .el-input {
        width: 130px;
    }

    .select {
        width: 130px;
    }

    .input-with-select .el-input-group__prepend {
        background-color: #fff;
    }


</style>