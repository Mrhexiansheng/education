<template>
    <div>
        <el-breadcrumb separator="/" width="100%">
            <el-breadcrumb-item :to="{ path: '/' }">管理员管理</el-breadcrumb-item>
            <el-breadcrumb-item>项目库管理</el-breadcrumb-item>
        </el-breadcrumb>
        <el-divider></el-divider>
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="未审核" name="first">
                <transition name="el-fade-in">
                    <el-row style="margin-bottom: 20px">
                        <el-col :span="8">
                            <el-input placeholder="请输入搜索内容" v-model="searchData" class="input-with-select">
                                <el-select v-model="select" slot="prepend" placeholder="选择搜索类型" class="select">
                                    <el-option label="项目编号" value="project_number"></el-option>
                                    <el-option label="项目名称" value="name"></el-option>
                                    <el-option label="项目负责人" value="username"></el-option>
                                </el-select>
                            </el-input>
                        </el-col>
                        <!--                        <el-col :span="7">
                                                    <el-date-picker
                                                            v-model="value2"
                                                            type="daterange"
                                                            align="right"
                                                            unlink-panels
                                                            range-separator="至"
                                                            start-placeholder="开始日期"
                                                            end-placeholder="结束日期"
                                                            :picker-options="pickerOptions">
                                                    </el-date-picker>
                                                </el-col>-->
                        <el-button icon="el-icon-search" @click="search" circle></el-button>
                    </el-row>
                </transition>
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
                                    <span>{{ props.row.realname }}</span>
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
                            width="180">
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
                            width="80">
                        <template slot-scope="cz">
                            <el-button type="text" @click="del(cz.row.id)">删除</el-button>
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
            <el-tab-pane label="审核中" name="second">
                <transition name="el-fade-in">
                    <el-row style="margin-bottom: 20px">
                        <el-col :span="8">
                            <el-input placeholder="请输入搜索内容" v-model="searchData1" class="input-with-select">
                                <el-select v-model="select1" slot="prepend" placeholder="选择搜索类型" class="select">
                                    <el-option label="项目编号" value="project_number"></el-option>
                                    <el-option label="项目名称" value="name"></el-option>
                                    <el-option label="项目负责人" value="username"></el-option>
                                </el-select>
                            </el-input>
                        </el-col>
                        <!--                        <el-col :span="7">
                                                    <el-date-picker
                                                            v-model="value2"
                                                            type="daterange"
                                                            align="right"
                                                            unlink-panels
                                                            range-separator="至"
                                                            start-placeholder="开始日期"
                                                            end-placeholder="结束日期"
                                                            :picker-options="pickerOptions">
                                                    </el-date-picker>
                                                </el-col>-->
                        <el-button icon="el-icon-search" @click="search1" circle></el-button>
                    </el-row>
                </transition>
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
                                    <span>{{ props.row.realname }}</span>
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
                                <el-form-item label="项目评分">
                                    <el-button type="text" v-for="item in props.row.score">{{item.name}} :
                                        {{item.score}}
                                    </el-button>
                                </el-form-item>
                                <el-form-item label="项目总评分">
                                    <el-button type="text">{{ props.row.totalscore }}
                                    </el-button>
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
                            width="180">
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
                            width="80">
                        <template slot-scope="cz">
                            <el-button type="text" @click="del(cz.row.id)">删除</el-button>
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
            <el-tab-pane label="审核通过" name="third">
                <transition name="el-fade-in">
                    <el-row style="margin-bottom: 20px">
                        <el-col :span="8">
                            <el-input placeholder="请输入搜索内容" v-model="searchData2" class="input-with-select">
                                <el-select v-model="select2" slot="prepend" placeholder="选择搜索类型" class="select">
                                    <el-option label="项目编号" value="project_number"></el-option>
                                    <el-option label="项目名称" value="name"></el-option>
                                    <el-option label="项目负责人" value="username"></el-option>
                                </el-select>
                            </el-input>
                        </el-col>
                        <!--                        <el-col :span="7">
                                                    <el-date-picker
                                                            v-model="value2"
                                                            type="daterange"
                                                            align="right"
                                                            unlink-panels
                                                            range-separator="至"
                                                            start-placeholder="开始日期"
                                                            end-placeholder="结束日期"
                                                            :picker-options="pickerOptions">
                                                    </el-date-picker>
                                                </el-col>-->
                        <el-button icon="el-icon-search" @click="search2" circle></el-button>
                    </el-row>
                </transition>
                <el-table
                        :data="tableData2"
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
                                    <span>{{ props.row.realname }}</span>
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
                                <el-form-item label="项目评分">
                                    <el-button type="text" v-for="item in props.row.score">{{item.name}} :
                                        {{item.score}}&nbsp&nbsp&nbsp&nbsp
                                    </el-button>
                                </el-form-item>
                                <el-form-item label="项目总评分">
                                    <el-button type="text">{{ props.row.totalscore }}
                                    </el-button>
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
                            width="180">
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
                            width="80">
                        <template slot-scope="cz">
                            <el-button type="text" @click="del(cz.row.id)">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <el-pagination
                        layout="prev, pager, next"
                        :page-size.sync="size2"
                        :current-page.sync="page2"
                        :total="total2"
                        @size-change="sizeChange2"
                        @current-change="currentChange2"
                >
                </el-pagination>
            </el-tab-pane>
            <el-tab-pane label="审核失败" name="fourth">
                <transition name="el-fade-in">
                    <el-row style="margin-bottom: 20px">
                        <el-col :span="8">
                            <el-input placeholder="请输入搜索内容" v-model="searchData3" class="input-with-select">
                                <el-select v-model="select3" slot="prepend" placeholder="选择搜索类型" class="select">
                                    <el-option label="项目编号" value="project_number"></el-option>
                                    <el-option label="项目名称" value="name"></el-option>
                                    <el-option label="项目负责人" value="username"></el-option>
                                </el-select>
                            </el-input>
                        </el-col>
                        <!--                        <el-col :span="7">
                                                    <el-date-picker
                                                            v-model="value2"
                                                            type="daterange"
                                                            align="right"
                                                            unlink-panels
                                                            range-separator="至"
                                                            start-placeholder="开始日期"
                                                            end-placeholder="结束日期"
                                                            :picker-options="pickerOptions">
                                                    </el-date-picker>
                                                </el-col>-->
                        <el-button icon="el-icon-search" @click="search3" circle></el-button>
                    </el-row>
                </transition>
                <el-table
                        :data="tableData3"
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
                                    <span>{{ props.row.realname }}</span>
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
                                <el-form-item label="项目评分">
                                    <el-button type="text" v-for="item in props.row.score">
                                        {{item.name}}:{{item.score}}&nbsp
                                    </el-button>
                                </el-form-item>
                                <el-form-item label="项目总评分">
                                    <el-button type="text">{{ props.row.totalscore }}
                                    </el-button>
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
                            width="180">
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
                            width="80">
                        <template slot-scope="cz">
                            <el-button type="text" @click="del(cz.row.id)">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <el-pagination
                        layout="prev, pager, next"
                        :page-size.sync="size3"
                        :current-page.sync="page3"
                        :total="total3"
                        @size-change="sizeChange3"
                        @current-change="currentChange3"
                >
                </el-pagination>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    export default {
        name: "ProjectLibrary",
        data() {
            return {
                activeName: "first",
                tableData: [],
                tableData1: [],
                tableData2: [],
                tableData3: [],
                size: 10,
                page: 1,
                total: 0,
                message: "",
                update_number: 0,
                searchData: "",
                searchData1: "",
                searchData2: "",
                searchData3: "",
                select: '',
                select1: '',
                select2: '',
                select3: '',
                pickerOptions: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
                value1: '',
                value2: '',
                show: false,
                size1: 10,
                page1: 1,
                total1: 0,
                size2: 10,
                page2: 1,
                total2: 0,
                size3: 10,
                page3: 1,
                total3: 0,
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
                this.$axios.get(this.$api.PROJECT, {
                    size: this.size,
                    page: this.page,
                    size1: this.size1,
                    page1: this.page1,
                    size2: this.size2,
                    page2: this.page2,
                    size3: this.size3,
                    page3: this.page3,
                    username: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        let _this = this;
                        //获取未审核的项目
                        res.data.data.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (value.score) {
                                value.score = JSON.parse(value.score);
                            }
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                        });
                        //获取成功的项目
                        res.data.data1.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (!value.score) {
                                value.totalscore = 0;
                            } else {
                                value.score = JSON.parse(value.score);
                                let Tscore = 0;
                                value.score.forEach(function (val, index) {
                                    Tscore += Number(val.score);
                                });
                                value.totalscore = Tscore/value.score.length;
                            }
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                        });
                        //获取审核失败的项目
                        res.data.data2.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (!value.score) {
                                value.totalscore = 0;
                            } else {
                                value.score = JSON.parse(value.score);
                                let Tscore = 0;
                                value.score.forEach(function (val, index) {
                                    Tscore += Number(val.score);
                                });
                                value.totalscore = Tscore/value.score.length;
                            }
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                        });
                        //获取审核中的项目
                        res.data.data3.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (!value.score) {
                                value.totalscore = 0;
                            } else {
                                value.score = JSON.parse(value.score);
                                let Tscore = 0;
                                value.score.forEach(function (val, index) {
                                    Tscore += Number(val.score);
                                });
                                value.totalscore = Tscore/value.score.length;
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
                        this.tableData1 = res.data.data3;
                        this.total1 = res.data.total3;
                        this.tableData2 = res.data.data1;
                        this.total2 = res.data.total1;
                        this.tableData3 = res.data.data2;
                        this.total3 = res.data.total2;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            del(id) {
                this.$confirm("是否确认删除该项目", '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                    this.$axios.get(this.$api.PROJECT, {
                        del_p_id: id
                    }).then(res => {
                        if (res.data.code === 200) {
                            let member = JSON.parse(res.data.member);
                            let length = member.length;
                            for (let i = 0; i < member.length; i++) {
                                this.getResearchProject(member[i].username, id, length)
                            }
                        }
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
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
            sizeChange1(val) {
                this.page = val;
                this.getData();
            },
            currentChange1(val) {
                this.page = val;
                this.getData();
            },
            sizeChange2(val) {
                this.page = val;
                this.getData();
            },
            currentChange2(val) {
                this.page = val;
                this.getData();
            },
            sizeChange3(val) {
                this.page = val;
                this.getData();
            },
            currentChange3(val) {
                this.page = val;
                this.getData();
            },
            getResearchProject(username, id, length) {
                this.$axios.get(this.$api.USER, {username}).then(res => {
                    if (res.data.code === 200) {
                        let research_project = JSON.parse(res.data.research_project);
                        research_project = research_project.filter(function (value, index) {
                            return value.id !== id;
                        });
                        research_project = JSON.stringify(research_project);
                        this.updateResearchProject(username, research_project, id, length)
                    }
                })
            },
            updateResearchProject(username, research_project, id, length) {
                this.$axios.put(this.$api.UPDATERESEARCHPROJECT1, {
                    username: username,
                    research_project: research_project
                }).then(res => {
                    if (res.data.code === 200) {
                        this.update_number++;
                    }
                    if (this.update_number === length) {
                        this.trueDel(id)
                    }
                })
            },
            trueDel(id) {
                this.$axios.delete(this.$api.PROJECT, {id}).then(res => {
                    if (res.data.code === 200) {
                        this.$message.success(res.data.msg);
                        this.getData();
                    } else {
                        this.$message.error("删除失败")
                    }
                })
            },
            search() {
                // this.show = !this.show;
                this.$axios.get(this.$api.PROJECT, {
                    searchType:"unchecked",
                    search: this.select,
                    searchData: this.searchData,
                    username: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        res.data.data.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (!value.score) {
                                value.totalscore = 0;
                            } else {
                                value.score = JSON.parse(value.score);
                                let Tscore = 0;
                                value.score.forEach(function (val, index) {
                                    Tscore += Number(val.score);
                                });
                                value.totalscore = Tscore/value.score.length;
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
            search1() {
                this.$axios.get(this.$api.PROJECT,{
                    searchType:"audit",
                    search:this.select1,
                    searchData:this.searchData1,
                    username:sessionStorage.getItem("username")
                }).then(res=>{
                    if (res.data.code === 200) {
                        res.data.data.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (!value.score) {
                                value.totalscore = 0;
                            } else {
                                value.score = JSON.parse(value.score);
                                let Tscore = 0;
                                value.score.forEach(function (val, index) {
                                    Tscore += Number(val.score);
                                });
                                value.totalscore = Tscore/value.score.length;
                            }
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                        });
                        this.tableData1 = res.data.data;
                        this.total1 = res.data.total;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            search2() {
                this.$axios.get(this.$api.PROJECT, {
                    searchType:"success",
                    search: this.select2,
                    searchData: this.searchData2,
                    username: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        res.data.data.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (!value.score) {
                                value.totalscore = 0;
                            } else {
                                value.score = JSON.parse(value.score);
                                let Tscore = 0;
                                value.score.forEach(function (val, index) {
                                    Tscore += Number(val.score);
                                });
                                value.totalscore = Tscore/value.score.length;
                            }
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                        });
                        this.tableData2 = res.data.data;
                        this.total2 = res.data.total;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            search3() {
                this.$axios.get(this.$api.PROJECT, {
                    searchType:"failure",
                    search: this.select3,
                    searchData: this.searchData3,
                    username: sessionStorage.getItem("username")
                }).then(res => {
                    if (res.data.code === 200) {
                        res.data.data.forEach(function (value, index) {
                            if (value.member) {
                                value.member = JSON.parse(value.member);
                            }
                            if (value.research_experts) {
                                value.research_experts = JSON.parse(value.research_experts)
                            }
                            if (!value.score) {
                                value.totalscore = 0;
                            } else {
                                value.score = JSON.parse(value.score);
                                let Tscore = 0;
                                value.score.forEach(function (val, index) {
                                    Tscore += Number(val.score);
                                });
                                value.totalscore = Tscore/value.score.length;
                            }
                            if (value.file) {
                                value.file = JSON.parse(value.file)
                            }
                            if (value.thumb) {
                                value.thumb = JSON.parse(value.thumb)
                            }
                        });
                        this.tableData3 = res.data.data;
                        this.total3 = res.data.total;
                    } else {
                        this.$message.error(res.data.msg)
                    }
                })
            },
            handleClick(tab, event) {
                if (tab.name === "second" && this.tableData1.length === 0) {
                    this.$message.error("暂无项目信息");
                }
                if (tab.name === "third" && !this.tableData2.length === 0) {
                    this.$message.error("暂无项目信息");
                }
                if (tab.name === "fourth" && !this.tableData3.length === 0) {
                    this.$message.error("暂无项目信息");
                }
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

    .el-select .el-input {
        width: 130px;
    }

    .select {
        width: 130px;
    }

    .input-with-select .el-input-group__prepend {
        background-color: #fff;
    }

    /*    .transition-box {
            margin-bottom: 10px;
            width: 200px;
            height: 100px;
            border-radius: 4px;
            background-color: #409EFF;
            text-align: center;
            color: #fff;
            padding: 40px 20px;
            box-sizing: border-box;
            margin-right: 20px;
        }*/
</style>