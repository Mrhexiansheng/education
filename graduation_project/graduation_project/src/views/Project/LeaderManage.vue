<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>立项管理</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="项目分配" name="first">
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
                                <el-form-item label="项目材料">
                                    <span></span>
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
                            <el-button type="text" @click="distribution(cz.row.id)">分配</el-button>
                            <el-button type="text" @click="overDistribution(cz.row.id)">结束分配</el-button>
                            <el-dialog
                                    title="专家分配"
                                    :visible.sync="dialogVisible"
                                    width="40%"
                                    :before-close="handleClose">
                                <el-table
                                        ref="multipleTable"
                                        :data="tableData1"
                                        tooltip-effect="dark"
                                        style="width: 100%"
                                        :header-cell-style="{'text-align':'center'}"
                                        :cell-style="{'text-align':'center'}"
                                        @selection-change="handleSelectionChange"
                                        @select-all="all"
                                >
                                    <el-table-column
                                            type="selection"
                                            width="55"
                                    >
                                    </el-table-column>
                                    <el-table-column type="expand">
                                        <template slot-scope="props">
                                            <el-form label-position="left" inline class="demo-table-expand">
                                                <el-form-item label="专家简介">
                                                    <span>{{props.row.abstract}}</span>
                                                </el-form-item>
                                                <el-form-item label="在评项目">
                                                    <el-button type="text">{{props.row.experts_project}}</el-button>
                                                </el-form-item>
                                            </el-form>
                                        </template>
                                    </el-table-column>
                                    <el-table-column
                                            label="姓名"
                                            width="120"
                                            prop="realname"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                            prop="phone"
                                            label="电话"
                                            width="120">
                                    </el-table-column>
                                    <el-table-column
                                            prop="experts_type"
                                            label="专家类型"
                                            show-overflow-tooltip>
                                        <template slot-scope="experts_type">
                                            <el-button type="text" v-if="experts_type.row.experts_type === 1">教学综合改革类专家</el-button>
                                            <el-button type="text" v-if="experts_type.row.experts_type === 2">专业建设类专家</el-button>
                                            <el-button type="text" v-if="experts_type.row.experts_type === 3">人才培养改革类专家</el-button>
                                            <el-button type="text" v-if="experts_type.row.experts_type === 4">实践教学类专家</el-button>
                                            <el-button type="text" v-if="experts_type.row.experts_type === 5">创新创业类专家</el-button>
                                            <el-button type="text" v-if="experts_type.row.experts_type === 6">教学管理类专家</el-button>
                                            <el-button type="text" v-if="experts_type.row.experts_type === 7">师资队伍建设类专家</el-button>
                                            <el-button type="text" v-if="experts_type.row.experts_type === 8">新工科研究与实践类专家</el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                                <span slot="footer" class="dialog-footer">
                                        <el-button @click="dialogVisible = false">取 消</el-button>
                                        <el-button type="primary" @click="assign">分 配</el-button>
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
            <el-tab-pane label="项目审核" name="second">
                <el-table
                        :data="tableData1"
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
                                <el-form-item label="项目评分">
                                    <el-button type="text" v-for="item in props.row.score">{{item.name+":"+item.score}}
                                    </el-button>
                                </el-form-item>
                                <el-form-item label="项目总评分">
                                    <el-button type="text">{{TotalScore}}
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
                            <el-button type="text" @click="audit(cz.row.id)">审核</el-button>
                            <el-dialog
                                    title="项目审核"
                                    :visible.sync="dialogVisible1"
                                    width="30%"
                                    :before-close="handleClose">
                                <el-radio v-model="radio" label="1">审核通过</el-radio>
                                <el-radio v-model="radio" label="2">审核失败</el-radio>
                                <span slot="footer" class="dialog-footer">
                                        <el-button @click="dialogVisible1 = false">取 消</el-button>
                                        <el-button type="primary" @click="confirm(cz.row.id)">确 定</el-button>
                                </span>
                            </el-dialog>
                        </template>
                    </el-table-column>
                </el-table>
                <el-pagination
                        layout="prev, pager, next"
                        :page-size.sync="size1"
                        :current-page.sync="page1"
                        :total="total1"
                        @size-change="sizeChange1"
                        @current-change="currentChange1"
                >
                </el-pagination>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    export default {
        name: "LeaderManage",
        data() {
            return {
                activeName: "first",
                tableData: [],
                size: 10,
                page: 1,
                total: 0,
                size1: 10,
                page1: 1,
                total1: 0,
                message: "",
                update_number: 0,
                searchData: "",
                select: '',
                value1: '',
                value2: '',
                show: false,
                dialogVisible: false,
                dialogVisible1: false,
                tableData1: [],
                multipleSelection: [],
                pid:"",
                radio: "",
                TotalScore:""
            }
        },
        methods: {
            getData() {
                this.$axios.get(this.$api.PROJECT, {
                    size: this.size,
                    page: this.page,
                    size1: this.size1,
                    page1: this.page1,
                    username: sessionStorage.getItem("username"),
                    require: "personal"
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
                        let _this = this;
                        res.data.data1.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (value.score) {
                                value.score = JSON.parse(value.score);
                                let Tscore = 0;
                                value.score.forEach(function (val,index) {
                                    Tscore+=Number(val.score);
                                });
                                _this.TotalScore = Tscore/value.score.length;
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
                        this.tableData1 = res.data.data1;
                        this.total1 = res.data.total1;
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
            sizeChange1(val) {
                console.log(val);
                this.page1 = val;

            },
            currentChange1(val) {
                this.page1 = val;

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
            distribution(pid){
                this.pid = pid;
                this.dialogVisible = true;
                this.$axios.get(this.$api.getexpersData,{
                    username:sessionStorage.getItem("username"),
                    pid:this.pid
                }).then(res=>{
                    if (res.data.code === 200){
                        this.tableData1 = res.data.data;
                    } else {
                        this.$message.error("暂无专家信息。")
                    }
                })
            },
            assign(){
                let arr = [];
                let obj = {};
                for(let i = 0;i<this.multipleSelection.length;i++){
                    obj.id = this.multipleSelection[i].id;
                    obj.realname = this.multipleSelection[i].realname;
                    arr[i] = obj;
                    obj = {};
                }
                let arr1 = [];
                for (let i = 0; i < this.multipleSelection.length; i++) {
                    arr1.push(this.multipleSelection[i].id);
                }
                this.$confirm('是否选择这些专家进行评分?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$axios.put(this.$api.PROJECT,{
                        grade: "grade",
                        pid:this.pid,
                        research_experts:JSON.stringify(arr),
                    }).then(res=>{
                        if (res.data.code === 200){
                            this.$message.success(res.data.msg);
                            this.$axios.put(this.$api.updateExpertsProject, {
                                expertsProjectMsg: JSON.stringify(arr1),
                                pid: this.pid
                            }).then(res => {
                                if (res.data.code === 200) {
                                    this.getData();
                                    this.$message.success(res.data.msg);
                                } else {
                                    this.$message.error(res.data.msg)
                                }
                            })
                        } else {
                            this.$message.error(res.data.msg)
                        }
                    });
                    this.dialogVisible = false;
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消选择'
                    });
                });
                this.dialogVisible =  false;
            },
            all(selection){
                this.multipleSelection = selection;
            },
            overDistribution(pid){
                this.$confirm('是否选择结束对该项目的专家分配?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$axios.put(this.$api.PROJECT,{
                        overDistribution: "overDistribution",
                        pid:pid,
                    }).then(res=>{
                        if (res.data.code === 200){
                            this.$message.success(res.data.msg);
                            this.getData();
                        } else {
                            this.$message.error(res.data.msg)
                        }
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消选择'
                    });
                });
            },
            audit(){
                this.dialogVisible1 = true;
            },
            confirm(id){
                this.$confirm('是否选择该审核结果?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    let arr=[];
                    let obj={};
                    obj.id = id;
                    obj.name = name;
                    arr.push(obj);
                    arr = JSON.stringify(arr);
                    this.$axios.put(this.$api.PROJECT,{
                        state:this.radio,
                        id,
                        psh:arr
                    }).then(res=>{
                        if (res.data.code === 200){
                            this.$message.success(res.data.msg);
                            this.dialogVisible = false;
                            this.getData();
                        } else {
                            this.$message.error(res.data.msg);
                            this.dialogVisible = false;
                        }
                    });
                    this.dialogVisible = false;
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消选择'
                    });
                });
                this.dialogVisible = false;
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