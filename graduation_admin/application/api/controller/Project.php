<?php


namespace app\api\controller;


use app\api\model\AdminModel;
use app\api\model\CollegeModel;
use app\api\model\ProjectModel;
use app\api\model\ProjectTypeModel;
use think\controller\Rest;
use think\Db;

class Project extends Rest
{
    public function project()
    {
        switch ($this->method) {
            case "get" :
                return $this->get();
            case "post" :
                return $this->post();
            case "put" :
                return $this->put();
            case "delete" :
                return $this->delete();
        }
    }

    private function get()
    {
        $data = input("get.");

        //获取项目或者项目组信息
        if (isset($data["size"])) {
            $size = $data["size"];
            if (isset($data["page"])) {
                $page = $data["page"];
                $start = ($page - 1) * $size;
                $username = $data["username"];
                $admin = AdminModel::where("username", $username)->find();
                $role = $admin->role;
                $where = [];
                //获取超级管理员可分配的项目
                if (isset($data["require"])) {
                    //获取领导当前所在院系的项目
                    if ($data["require"] == "personal") {
                        $size = $data["size"];
                        $page = $data["page"];
                        $start = ($page - 1) * $size;
                        $size1 = $data["size1"];
                        $page1 = $data["page1"];
                        $start1 = ($page1 - 1) * $size1;
                        $username = $data["username"];
                        $admin = AdminModel::where("username", $username)->find();
                        $college = $admin->college;   //获得该领导的学院号
                        $data1 = [];
                        $project = ProjectModel::all();
                        $a = count($project); // 获取项目的数量
                        //找出与领导同一学院的人
                        for ($i = 0; $i < $a; $i++) {
                            $admin1 = AdminModel::where("id", $project[$i]["aid"])->find();
                            $college1 = $admin1->college;
                            if ($college === $college1) {
                                array_push($data1, $admin1);
                            }
                        }
                        //拿到与领导同一学院的这些人的项目id汇成数组
                        $b = count($data1);
                        $c = [];
                        for ($i = 0; $i < $b; $i++) {
                            array_push($c, $data1[$i]["id"]);
                        }
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.aid", "in", $c)
                            ->where("c.states", 3)
                            ->where("c.experts_state", "=", 0)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->limit($start, $size)
                            ->field("c.project_number,c.file,c.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.aid", "in", $c)
                            ->where("c.experts_state", "=", 0)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.file,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        $res1 = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.aid", "in", $c)
                            ->where("c.states", 4)
                            ->where("c.experts_state", "=", 1)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->limit($start1, $size1)
                            ->field("c.project_number,c.id,c.file,c.score,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res1); $i++) {
                            $college_number = $res1[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res1[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res1); $i++) {
                            $college_number = $res1[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res1[$i]["type"] = $college;
                        }
                        $count1 = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.aid", "in", $c)
                            ->where("c.experts_state", "=", 1)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.file,c.score,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total1 = count($count1);
                        if ($res || $res1) {
                            return json([
                                "code" => 200,
                                "msg" => "获取成功",
                                "data" => $res,
                                "data1" => $res1,
                                "total" => $total,
                                "total1" => $total1,
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "当前暂无信息！",
                            ]);
                        }
                    }
                    //获取专家在评的项目
                    if ($data["require"] == "experts") {
                        $username = $data["username"];
                        $admin = AdminModel::where("username", $username)->find();
                        $experts_project = $admin->experts_project;
                        $experts_project = json_decode($experts_project, true);
                        $where = [];
                        if ($experts_project) {
                            foreach ($experts_project as $k => $v) {
                                array_push($where, $v["id"]);
                            }
                            $res = Db::name('admin')
                                ->alias("g")
                                ->join("project c", "c.aid = g.id")
                                ->where("c.id", "in", $where)
                                ->where("c.experts_state", 1)
                                ->where("c.state2", "=", 1)
                                ->where("c.states", 4)
                                ->order("g.id", "asc")
                                ->limit($start, $size)
                                ->field("c.project_number,c.file,c.thumb,c.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                                ->select();
                            for ($i = 0; $i < count($res); $i++) {
                                $college_number = $res[$i]["college"];
                                $collegemsg = CollegeModel::where("id", $college_number)->find();
                                $college = $collegemsg->college;
                                $res[$i]["college"] = $college;
                            }
                            for ($i = 0; $i < count($res); $i++) {
                                $college_number = $res[$i]["type"];
                                $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                                $college = $collegemsg->type;
                                $res[$i]["type"] = $college;
                            }
                            $count = Db::name('admin')
                                ->alias("g")
                                ->join("project c", "c.aid = g.id")
                                ->where("c.id", "in", $where)
                                ->where("c.experts_state", 1)
                                ->where("c.state2", "=", 1)
                                ->where("c.states", 4)
                                ->order("g.id", "asc")
                                ->field("c.project_number,c.file,c.thumb,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                                ->select();
                            $total = count($count);
                            if (isset($res)) {
                                return json([
                                    "code" => 200,
                                    "msg" => "获取成功",
                                    "data" => $res,
                                    "total" => $total,
                                    "where" => $where
                                ]);
                            } else {
                                return json([
                                    "code" => 400,
                                    "msg" => "获取失败",
                                ]);
                            }
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无在评项目！",
                            ]);
                        }
                    }
                    //超级管理员获取审核项目

                }
                if (isset($data["admin"])) {
                    if ($data["admin"] == "admin") {
                        $size = $data["size"];
                        $page = $data["page"];
                        $start = ($page - 1) * $size;
                        $size1 = $data["size1"];
                        $page1 = $data["page1"];
                        $start1 = ($page1 - 1) * $size1;
                        $username = $data["username"];
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.experts_state", "=", 0)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->limit($start, $size)
                            ->field("c.project_number,c.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.experts_state", "=", 0)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        $res1 = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.experts_state", "=", 1)
                            ->where("c.states", "=", 4)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->limit($start1, $size1)
                            ->field("c.project_number,c.id,c.score,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res1); $i++) {
                            $college_number = $res1[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res1[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res1); $i++) {
                            $college_number = $res1[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res1[$i]["type"] = $college;
                        }
                        $count1 = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.experts_state", "=", 1)
                            ->where("c.states", "=", 4)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,g.id,g.username,c.score,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total1 = count($count1);
                        if ($res || $res1) {
                            return json([
                                "code" => 200,
                                "msg" => "获取成功",
                                "data" => $res,
                                "total" => $total,
                                "data1" => $res1,
                                "total1" => $total1,
                            ]);
                        }
                    }
                    if ($data["admin"] == "leader") {
                        $size = $data["size"];
                        $page = $data["page"];
                        $start = ($page - 1) * $size;
                        $username = $data["username"];
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.experts_state", "=", 0)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->limit($start, $size)
                            ->field("c.project_number,c.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.experts_state", "=", 0)
                            ->where("c.state2", "=", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if (isset($res)) {
                            return json([
                                "code" => 200,
                                "msg" => "获取成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        }
                    }
                }
                if ($role === 1) {
                    $size1 = $data["size1"];
                    $size2 = $data["size2"];
                    $size3 = $data["size3"];
                    $page1 = $data["page1"];
                    $page2 = $data["page2"];
                    $page3 = $data["page3"];
                    $start1 = ($page1 - 1) * $size1;
                    $start2 = ($page2 - 1) * $size2;
                    $start3 = ($page3 - 1) * $size3;
                    //获取未审核的项目
                    $res = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "g.id = c.aid")
                        ->where("c.states", 3)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->limit($start, $size)
                        ->field("c.project_number,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    for ($i = 0; $i < count($res); $i++) {
                        $college_number = $res[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res); $i++) {
                        $college_number = $res[$i]["type"];
                        $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                        $college = $collegemsg->type;
                        $res[$i]["type"] = $college;
                    }
                    $count = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "g.id = c.aid")
                        ->where($where)
                        ->where("c.states", 3)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->field("c.project_number,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    $total = count($count);
                    //获取审核成功的项目
                    $res1 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "g.id = c.aid")
                        ->where($where)
                        ->where("c.experts_state", 1)
                        ->where("c.states", 1)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->limit($start2, $size2)
                        ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    for ($i = 0; $i < count($res1); $i++) {
                        $college_number = $res1[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res1[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res1); $i++) {
                        $college_number = $res1[$i]["type"];
                        $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                        $college = $collegemsg->type;
                        $res1[$i]["type"] = $college;
                    }
                    $count1 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "g.id = c.aid")
                        ->where($where)
                        ->where("c.experts_state", 1)
                        ->where("c.states", 1)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    $total1 = count($count1);
                    //获取审核失败的项目
                    $res2 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "g.id = c.aid")
                        ->where($where)
                        ->where("c.experts_state", 1)
                        ->where("c.states", 2)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->limit($start3, $size3)
                        ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    for ($i = 0; $i < count($res2); $i++) {
                        $college_number = $res2[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res2[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res2); $i++) {
                        $college_number = $res2[$i]["type"];
                        $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                        $college = $collegemsg->type;
                        $res2[$i]["type"] = $college;
                    }
                    $count2 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "g.id = c.aid")
                        ->where($where)
                        ->where("c.experts_state", 1)
                        ->where("c.states", 2)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    $total2 = count($count2);
                    //获取审核中的项目
                    $res3 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "g.id = c.aid")
                        ->where($where)
                        ->where("c.states", 4)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->limit($start1, $size1)
                        ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    for ($i = 0; $i < count($res3); $i++) {
                        $college_number = $res3[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res3[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res3); $i++) {
                        $college_number = $res3[$i]["type"];
                        $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                        $college = $collegemsg->type;
                        $res3[$i]["type"] = $college;
                    }
                    $count3 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "g.id = c.aid")
                        ->where("c.states", 4)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    $total3 = count($count3);
                    if ($res || $res1 || $res2 || $res3) {
                        return json([
                            "code" => 200,
                            "msg" => "获取成功",
                            "data" => $res,
                            "data1" => $res1,
                            "data2" => $res2,
                            "data3" => $res3,
                            "total" => $total,
                            "total1" => $total1,
                            "total2" => $total2,
                            "total3" => $total3,
                        ]);
                    }
                }
                if ($role === 2) {
                    $size1 = $data["size1"];
                    $size2 = $data["size2"];
                    $size3 = $data["size3"];
                    $page1 = $data["page1"];
                    $page2 = $data["page2"];
                    $page3 = $data["page3"];
                    $start1 = ($page1 - 1) * $size1;
                    $start2 = ($page2 - 1) * $size2;
                    $start3 = ($page3 - 1) * $size3;
                    $username = $data["username"];
                    $admin = AdminModel::where("username", $username)->find();
                    $college = $admin->college;   //获得该领导的学院号
                    $data1 = [];
                    $project = ProjectModel::all();
                    $a = count($project); // 获取项目的数量
                    //找出与领导同一学院的人
                    for ($i = 0; $i < $a; $i++) {
                        $admin1 = AdminModel::where("id", $project[$i]["aid"])->find();
                        $college1 = $admin1->college;
                        if ($college === $college1) {
                            array_push($data1, $admin1);
                        }
                    }
                    //拿到与领导同一学院的这些人的项目id汇成数组
                    $b = count($data1);
                    $c = [];
                    for ($i = 0; $i < $b; $i++) {
                        array_push($c, $data1[$i]["id"]);
                    }
                    //获取未审核项目
                    $res = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "c.aid = g.id")
                        ->where("c.aid", "in", $c)
                        ->where("c.states", 3)
                        ->where("c.state2", 1)
                        ->order("g.id", "asc")
                        ->limit($start, $size)
                        ->field("c.project_number,c.id,c.score,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    for ($i = 0; $i < count($res); $i++) {
                        $college_number = $res[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res); $i++) {
                        $college_number = $res[$i]["type"];
                        $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                        $college = $collegemsg->type;
                        $res[$i]["type"] = $college;
                    }
                    $count = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "c.aid = g.id")
                        ->where("c.aid", "in", $c)
                        ->where("c.states", 3)
                        ->where("c.state2", 1)
                        ->order("g.id", "asc")
                        ->field("c.project_number,c.score,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    $total = count($count);
                    //获取审核中项目
                    $res3 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "c.aid = g.id")
                        ->where("c.aid", "in", $c)
                        ->where("c.states", 4)
                        ->where("c.state2", 1)
                        ->order("g.id", "asc")
                        ->limit($start1, $size1)
                        ->field("c.project_number,c.id,c.score,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    for ($i = 0; $i < count($res3); $i++) {
                        $college_number = $res3[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res3[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res3); $i++) {
                        $college_number = $res3[$i]["type"];
                        $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                        $college = $collegemsg->type;
                        $res3[$i]["type"] = $college;
                    }
                    $count3 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "c.aid = g.id")
                        ->where("c.aid", "in", $c)
                        ->where("c.states", 4)
                        ->where("c.state2", 1)
                        ->order("g.id", "asc")
                        ->field("c.project_number,c.score,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    $total3 = count($count3);
                    //获取审核成功项目
                    $res1 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "c.aid = g.id")
                        ->where("c.aid", "in", $c)
                        ->where("c.experts_state", "=", 1)
                        ->where("c.states", 1)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->limit($start2, $size2)
                        ->field("c.project_number,c.id,c.score,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    for ($i = 0; $i < count($res1); $i++) {
                        $college_number = $res1[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res1[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res1); $i++) {
                        $college_number = $res1[$i]["type"];
                        $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                        $college = $collegemsg->type;
                        $res1[$i]["type"] = $college;
                    }
                    $count1 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "c.aid = g.id")
                        ->where("c.aid", "in", $c)
                        ->where("c.experts_state", "=", 1)
                        ->where("c.states", 1)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->field("c.project_number,c.score,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    $total1 = count($count1);
                    //获取审核失败项目
                    $res2 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "c.aid = g.id")
                        ->where("c.aid", "in", $c)
                        ->where("c.experts_state", "=", 1)
                        ->where("c.states", 2)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->limit($start3, $size3)
                        ->field("c.project_number,c.id,c.score,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    for ($i = 0; $i < count($res2); $i++) {
                        $college_number = $res2[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res2[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res2); $i++) {
                        $college_number = $res2[$i]["type"];
                        $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                        $college = $collegemsg->type;
                        $res2[$i]["type"] = $college;
                    }
                    $count2 = Db::name('admin')
                        ->alias("g")
                        ->join("project c", "c.aid = g.id")
                        ->where("c.aid", "in", $c)
                        ->where("c.experts_state", "=", 1)
                        ->where("c.states", 2)
                        ->where("c.state2", "=", 1)
                        ->order("g.id", "asc")
                        ->field("c.project_number,c.score,g.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                        ->select();
                    $total2 = count($count2);
                    if ($res || $res1 || $res2 || $res3) {
                        return json([
                            "code" => 200,
                            "msg" => "获取成功",
                            "data" => $res,
                            "data1" => $res1,
                            "data2" => $res2,
                            "data3" => $res3,
                            "total" => $total,
                            "total1" => $total1,
                            "total2" => $total2,
                            "total3" => $total3
                        ]);
                    } else {
                        return json([
                            "code" => 400,
                            "msg" => "当前暂无信息！",
                            "v" => $c
                        ]);
                    }
                }
                if ($role === 3) {
                    $experts_projects = $admin->experts_projects;
                    if ($experts_projects) {
                        $experts_projects = json_decode($experts_projects, true);
                        $where = [];
                        if ($experts_projects) {
                            foreach ($experts_projects as $k => $v) {
                                array_push($where, $v["id"]);
                            }
                        }
                        //获取专家审核项目中的审核成功的项目
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.id", "in", $where)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->limit($start, $size)
                            ->field("c.project_number,c.file,c.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $res1 = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "c.aid = g.id")
                            ->where("c.id", "in", $where)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->limit($start, $size)
                            ->field("c.project_number,c.file,c.id,g.username,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res1); $i++) {
                            $college_number = $res1[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res1[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res1); $i++) {
                            $college_number = $res1[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res1[$i]["type"] = $college;
                        }

                        if ($res || $res1) {
                            return json([
                                "code" => 200,
                                "msg" => "获取成功",
                                "data1" => $res,
                                "data2" => $res1,
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "当前暂无信息！",
                            ]);
                        }
                    } else {
                        return json([
                            "code" => 400,
                            "msg" => "当前暂无信息！",
                        ]);
                    }
                }
                if ($role === 4) {
                    $res = Db::name("project")
                        ->alias("p")
                        ->join("admin a", "p.aid = a.id")
                        ->where($where)
                        ->where("state2", 1)
                        ->field("a.realname,a.phone,a.college,a.teachers_title,p.name,p.thumb,p.states,p.description,p.keywords,p.file,p.type,p.level,p.member,p.time,p.state2,p.project_number,p.research_experts")
                        ->limit($start, $size)
                        ->order("p.id", "asc")
                        ->select();
                    for ($i = 0; $i < count($res); $i++) {
                        $college_number = $res[$i]["college"];
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $res[$i]["college"] = $college;
                    }
                    for ($i = 0; $i < count($res); $i++) {
                        $type = $res[$i]["type"];
                        $typemsg = ProjectTypeModel::where("id", $type)->find();
                        $type1 = $typemsg->type;
                        $res[$i]["type"] = $type1;
                    }
                    $count = Db::name("project")
                        ->alias("p")
                        ->join("admin a", "p.aid = a.id")
                        ->where($where)
                        ->where("state2", 1)
                        ->field("a.realname,a.phone,a.college,a.teachers_title,p.name,p.thumb,p.states,p.description,p.file,p.keywords,p.type,p.level,p.member,p.time,p.state2,p.project_number,p.research_experts")
                        ->order("p.id", "asc")
                        ->select();
                    $total = count($count);
                    if (isset($res)) {
                        return json([
                            "code" => 200,
                            "msg" => "获取成功",
                            "data" => $res,
                            "total" => $total
                        ]);
                    }
                }
            }
        }

        //获取用户当前参与的项目信息
        if (isset($data["view"])) {
            $username = $data["username"];
            $admin = AdminModel::where("username", $username)->find();
            $pid = [];
            $research_project = $admin->research_project;
            $research_project = json_decode($research_project, true);
            $research_projects = $admin->research_projects;
            $research_projects = json_decode($research_projects, true);
            if ($research_projects) {
                foreach ($research_projects as $k => $v) {
                    array_push($pid, $v["id"]);
                }
            }
            if ($research_project) {
                foreach ($research_project as $a => $b) {
                    array_push($pid, $b["id"]);
                }
            }
            $res = Db::name("project")
                ->alias("p")
                ->join("admin a", "p.aid = a.id")
                ->where("p.id", "in", $pid)
                ->field("p.id,a.realname,a.phone,a.college,p.file,a.teachers_title,p.name,p.thumb,p.states,p.description,p.keywords,p.type,p.level,p.member,p.time,p.state2,p.project_number")
                ->order("p.id", "asc")
                ->select();
            for ($i = 0; $i < count($res); $i++) {
                $college_number = $res[$i]["college"];
                $collegemsg = CollegeModel::where("id", $college_number)->find();
                $college = $collegemsg->college;
                $res[$i]["college"] = $college;
            }
            for ($i = 0; $i < count($res); $i++) {
                $type = $res[$i]["type"];
                $typemsg = ProjectTypeModel::where("id", $type)->find();
                $type1 = $typemsg->type;
                $res[$i]["type"] = $type1;
            }
            if (isset($res)) {
                return json([
                    "code" => 200,
                    "msg" => "获取成功",
                    "data" => $res
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "您还没有在研项目，请尽快申请或加入。",
                ]);
            }
        }

        if (isset($data["pid"])) {
            $pid = $data["pid"];
            $project = ProjectModel::where("id", $pid)->find();
            if (isset($project)) {
                return json([
                    "code" => 200,
                    "msg" => "查询成功",
                    "project" => $project
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "查询失败",
                ]);
            }
        }

        //删除项目时需要的member获取
        if (isset($data["del_p_id"])) {
            $id = $data["del_p_id"];
            $project = ProjectModel::where("id", $id)->find();
            $member = $project->member;
            if (isset($member)) {
                return json([
                    "code" => 200,
                    "msg" => "查询成功",
                    "member" => $member
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "查询失败",
                ]);
            }
        }

        //对于用户申请加入项目时，是否能加入验证
        if (isset($data["yzsq"])) {
            $id = $data["id"];
            $project = ProjectModel::where("id", $id)->find();
            $state2 = $project->state2;
            $join = $project->join;
            if ($join === 1) {
                if ($state2 === 2) {
                    return json([
                        "code" => 200,
                        "msg" => "该项目可以加入！",
                    ]);
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "当前项目已经提交审核，不可再加入该项目！",
                        "a" => $state2
                    ]);
                }
            } else {
                return json([
                    "code" => 400,
                    "msg" => "当前项目已经审核完毕，不可再加入该项目！",
                ]);
            }
        }

        //项目库搜索项目
        if (isset($data["searchType"])) {
            $username = $data["username"];
            $user = AdminModel::where("username", $username)->find();
            $role = $user->role;
            if ($role === 1) {
                //搜索未审核项目
                if ($data["searchType"] == "unchecked") {
                    $search = $data["search"];
                    $searchData = $data["searchData"];
                    if ($search == "name") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "project_number") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "username") {
                        $admin = AdminModel::where("username", $searchData)->find();
                        $id = $admin->id;
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", $id)
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", $id)
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                }
                //搜索审核中项目
                if ($data["searchType"] == "audit") {
                    $search = $data["search"];
                    $searchData = $data["searchData"];
                    if ($search == "name") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "project_number") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "username") {
                        $admin = AdminModel::where("username", $searchData)->find();
                        $id = $admin->id;
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", $id)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", $id)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                }
                //搜索审核成功项目
                if ($data["searchType"] == "success") {
                    $search = $data["search"];
                    $searchData = $data["searchData"];
                    if ($search == "name") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "project_number") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "username") {
                        $admin = AdminModel::where("username", $searchData)->find();
                        $id = $admin->id;
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", $id)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", $id)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                }
                //搜索审核失败的项目
                if ($data["searchType"] == "failure") {
                    $search = $data["search"];
                    $searchData = $data["searchData"];
                    if ($search == "name") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "project_number") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "username") {
                        $admin = AdminModel::where("username", $searchData)->find();
                        $id = $admin->id;
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", $id)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", $id)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                }
            }
            if ($role === 2) {
                $college = $user->college;   //获得该领导的学院号
                $data1 = [];
                $project = ProjectModel::all();
                $a = count($project); // 获取项目的数量
                //找出与领导同一学院的人
                for ($i = 0; $i < $a; $i++) {
                    $admin1 = AdminModel::where("id", $project[$i]["aid"])->find();
                    $college1 = $admin1->college;
                    if ($college === $college1) {
                        array_push($data1, $admin1);
                    }
                }
                //拿到与领导同一学院的这些人的项目id汇成数组
                $b = count($data1);
                $c = [];
                for ($i = 0; $i < $b; $i++) {
                    array_push($c, $data1[$i]["id"]);
                }
                //搜索未审核项目
                if ($data["searchType"] == "unchecked") {
                    $search = $data["search"];
                    $searchData = $data["searchData"];
                    if ($search == "name") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 3)
                            ->where("c.aid", "in", $c)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 3)
                            ->where("c.aid", "in", $c)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "project_number") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.aid", "in", $c)
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.aid", "in", $c)
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "username") {
                        $admin = AdminModel::where("username", $searchData)->find();
                        $id = $admin->id;
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.aid", $id)
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.aid", $id)
                            ->where("c.states", 3)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                }
                //搜索审核中项目
                if ($data["searchType"] == "audit") {
                    $search = $data["search"];
                    $searchData = $data["searchData"];
                    if ($search == "name") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.aid", "in", $c)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.aid", "in", $c)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "project_number") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.aid", "in", $c)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.project_number", $searchData)
                            ->where("c.aid", "in", $c)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "username") {
                        $admin = AdminModel::where("username", $searchData)->find();
                        $id = $admin->id;
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.aid", $id)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.aid", $id)
                            ->where("c.states", 4)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                }
                //搜索审核成功项目
                if ($data["searchType"] == "success") {
                    $search = $data["search"];
                    $searchData = $data["searchData"];
                    if ($search == "name") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "project_number") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "username") {
                        $admin = AdminModel::where("username", $searchData)->find();
                        $id = $admin->id;
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.aid", $id)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.aid", $id)
                            ->where("c.states", 1)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                }
                //搜索审核失败的项目
                if ($data["searchType"] == "failure") {
                    $search = $data["search"];
                    $searchData = $data["searchData"];
                    if ($search == "name") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.name", "like", "%$searchData%")
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "project_number") {
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.project_number", $searchData)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                    if ($search == "username") {
                        $admin = AdminModel::where("username", $searchData)->find();
                        $id = $admin->id;
                        $res = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.aid", $id)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["college"];
                            $collegemsg = CollegeModel::where("id", $college_number)->find();
                            $college = $collegemsg->college;
                            $res[$i]["college"] = $college;
                        }
                        for ($i = 0; $i < count($res); $i++) {
                            $college_number = $res[$i]["type"];
                            $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                            $college = $collegemsg->type;
                            $res[$i]["type"] = $college;
                        }
                        $count = Db::name('admin')
                            ->alias("g")
                            ->join("project c", "g.id = c.aid")
                            ->where("c.aid", "in", $c)
                            ->where("c.aid", $id)
                            ->where("c.states", 2)
                            ->order("g.id", "asc")
                            ->field("c.project_number,c.score,c.id,g.username,c.file,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.file,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree,c.research_experts")
                            ->select();
                        $total = count($count);
                        if ($res) {
                            return json([
                                "code" => 200,
                                "msg" => "搜索成功",
                                "data" => $res,
                                "total" => $total
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "暂无该项目，赶快申请吧！"
                            ]);
                        }
                    }
                }
            }
        }

    }

    private function post()
    {
        $data = input("post.");
        if (isset($data["username"])) {
            $username = $data["username"];
            $admin = AdminModel::where("username", $username)->find();
            $teachers_title = $admin->teachers_title;
            $degree = $admin->degree;
            $research_project = $admin->research_project;
            $research_project = json_decode($research_project);
            $id = $admin->id;
            if ($teachers_title >= 3 || $degree * $teachers_title == 6) {  //副教授以上或者讲师+博士学位 ，先通过权限判断在判断本人到底有没有项目在身
                if ($research_project && count($research_project) > 0) {
                    return json([
                        "code" => 400,
                        "msg" => "对不起，您已有在研项目，不能作为项目申请人！",
                    ]);
                } else {
                    $project = ProjectModel::where("aid", $id)->find();
                    if (!isset($project)) {
                        $model = new ProjectModel();
                        $model->name = $data["name"];
                        $model->thumb = $data["thumb"];
                        $model->description = $data["description"];
                        $model->keywords = $data["keywords"];
                        $model->aid = $id;
                        $model->level = $data["level"];
                        $model->time = $data["time"];
                        $model->file = $data["file"];
                        $model->project_number = $data["project_number"];
                        $model->search_number = $data["search_number"];
                        $model->type = $data["type"];
                        $model->member = $data["member"];
                        $r = $model->save();
                        if ($r) {
                            $search_number = $data["search_number"];
                            $project = ProjectModel::where("search_number", $search_number)->find();
                            return json([
                                "code" => 200,
                                "msg" => "恭喜您申请成功，等待组员加入。",
                                "data" => $project
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "申请失败",
                            ]);
                        }
                    } else {
                        return json([
                            "code" => 400,
                            "msg" => "对不起，您已有项目在研究中，暂时不能再次申请项目！",
                        ]);
                    }
                }
            } else {
                return json([
                    "code" => 400,
                    "msg" => "对不起，您的权限不够！",
                    "data" => $data
                ]);
            }
        }
    }

    private function put()
    {
        $data = input("put.");
        //给项目分配专家，进行评分
        if (isset($data["grade"])) {
            $pid = $data["pid"];
            $project = ProjectModel::where("id", "=", $pid)->find();
            $research_experts = $project->research_experts;
            $experts_state = $project->experts_state;
            if ($research_experts) {
                $research_experts = json_decode($research_experts, true);
                $a = count($research_experts);
                $research_experts1 = $data["research_experts"];
                $research_experts2 = json_decode($research_experts1, true);
                $b = count($research_experts2);
                if ($a < 3 && $a + $b <= 3) {
                    foreach ($research_experts as $k => $v) {
                        foreach ($research_experts2 as $c => $d) {
                            if ($v["id"] == $d["id"]) unset($research_experts2[$c]);
                        }
                    }
                    $research_experts = array_merge($research_experts, $research_experts2);
                    $research_experts = json_encode($research_experts, JSON_UNESCAPED_UNICODE);
                    if ($experts_state == 0) {
                        $model = new ProjectModel();
                        $r = $model->save([
                            'research_experts' => $research_experts,
                        ], ['id' => $pid]);
                        if ($r) {
                            return json([
                                "code" => 200,
                                "msg" => "分配成功"
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "分配失败！",
                            ]);
                        }
                    } else {
                        return json([
                            "code" => 400,
                            "msg" => "分配失败,该项目已经分配完毕！",
                        ]);
                    }
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "分配失败，在评专家不能大于3人！",
                    ]);
                }
            } else {
                $research_experts2 = $data["research_experts"]; //接收一下前端传过来的专家信息
                $research_experts3 = json_decode($research_experts2, true);
                $b = count($research_experts3);
                if ($b > 3) {
                    return json([
                        "code" => 400,
                        "msg" => "分配失败，专家分配不能大于3人！",
                    ]);
                } else {
                    $model = new ProjectModel();
                    $r = $model->save([
                        'research_experts' => $research_experts2,
//                        "experts_state" => 1
                    ], ['id' => $pid]);
                    if ($r) {
                        return json([
                            "code" => 200,
                            "msg" => "分配成功"
                        ]);
                    } else {
                        return json([
                            "code" => 400,
                            "msg" => "分配失败",
                        ]);
                    }
                }
            }
        }
        //专家对于在评项目的评分
        if (isset($data["score"])) {
            $newscore = $data["score"];
            $pid = $data["id"];
            $name = $data["name"];
            $admin = AdminModel::where("username", $name)->find();
            $realname = $admin->realname;
            $project1 = ProjectModel::where("id", $pid)->find();
            $score = $project1->score;
            if ($score) {
                $score = json_decode($score, true);
                foreach ($score as $k => $v) {
                    if ($realname == $v["name"]) {
                        return json([
                            "code" => 400,
                            "msg" => "您已对该项目进行评分，请勿重复评分！",
                        ]);
                    }
                }
                $newscore = json_decode($newscore, true);
                $score = array_merge($score, $newscore);
                $score = json_encode($score, JSON_UNESCAPED_UNICODE);
                $model = new ProjectModel();
                $r = $model->save([
                    'score' => $score,
                ], ['id' => $pid]);
                if ($r) {
                    return json([
                        "code" => 200,
                        "msg" => "评分成功",
                    ]);
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "评分失败！",
                    ]);
                }
            } else {
                $model = new ProjectModel();
                $newscore1 = $data["score"];
                $r = $model->save([
                    'score' => $newscore1,
                ], ['id' => $pid]);
                if ($r) {
                    return json([
                        "code" => 200,
                        "msg" => "评分成功!"
                    ]);
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "评分失败！",
                    ]);
                }
            }
        }
        //结束对该项目的专家分配
        if (isset($data["overDistribution"])) {
            $pid = $data["pid"];
            $model = new ProjectModel();
            $r = $model->save([
                'experts_state' => 1,
                "states" => 4
            ], ['id' => $pid]);
            if ($r) {
                return json([
                    "code" => 200,
                    "msg" => "分配完成！"
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "分配失败！",
                ]);
            }
        }
        //查询申请信息
        if (isset($data["search_number"])) {
            $search_number = $data["search_number"];
            $username = $data["username"];
            $msg = ProjectModel::where("search_number", $search_number)->find();
            $adminmsg = AdminModel::where("username", $username)->find();
            $research_project = $adminmsg->research_project;
            if (isset($msg)) {
                $member = $msg->member;
                $res = Db::name('admin')
                    ->alias("g")
                    ->join("project c", "g.id = c.aid")
                    ->where("search_number", $search_number)
                    ->where("state2", 2)
                    ->order("g.id", "asc")
                    ->field("c.project_number,c.id,g.username,c.member,g.last_login_time,g.state,g.avatar,g.phone,g.college,g.depart_number,g.realname,c.name,g.role,c.thumb,c.states,c.description,c.keywords,c.type,c.level,c.member,c.time,g.teachers_title,g.degree")
                    ->select();
                for ($i = 0; $i < count($res); $i++) {
                    $college_number = $res[$i]["college"];
                    $collegemsg = CollegeModel::where("id", $college_number)->find();
                    $college = $collegemsg->college;
                    $res[$i]["college"] = $college;
                }
                for ($i = 0; $i < count($res); $i++) {
                    $college_number = $res[$i]["type"];
                    $collegemsg = ProjectTypeModel::where("id", $college_number)->find();
                    $college = $collegemsg->type;
                    $res[$i]["type"] = $college;
                }
                if ($res) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $res,
                        "member" => $member,
                        "research_project" => $research_project
                    ]);
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "该项目已经提交审核，不可再加入！",
                    ]);
                }
            } else {
                return json([
                    "code" => 400,
                    "msg" => "搜索失败",
                ]);
            }
        }
        //处理申请信息
        if (isset($data["member"])) {
            $id = $data["id"];
            $newmember = $data["member"];
            $project = ProjectModel::where("id", $id)->find();
            $username = $data["username"];
            $admin = AdminModel::where("username", $username)->find();
            $aid = $admin->id;
            $state2 = $project->state2;
            $personal_project = ProjectModel::where("aid", $aid)->find();
            if (isset($personal_project)) {   //可以查到aid说明此用户可以自主创建项目，所以不必判断职称和学位
                return json([
                    "code" => 400,
                    "msg" => "对不起，您作为项目申请人，只能参与一个项目！",
                ]);
            } else {
                if ($state2 == 2) {
                    $model = new ProjectModel();
                    $r = $model->save([
                        'member' => $newmember,
                    ], ['id' => $id]);
                    if ($r) {
                        return json([
                            "code" => 200,
                            "msg" => "申请成功",
                            "data" => $project
                        ]);
                    } else {
                        return json([
                            "code" => 400,
                            "msg" => "请勿重复申请",
                        ]);
                    }
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "此项目已提交审核，不可进行再次申请。",
                    ]);
                }

            }

        }
        //处理删除普通用户时，项目组成员信息修改
        if (isset($data["newmember"])) {
            $pid = $data["pid"];
            $member = $data["newmember"];
            $model = new ProjectModel();
            $r = $model->save([
                'member' => $member,
            ], ['id' => $pid]);
            if ($r) {
                return json([
                    "code" => 200,
                    "msg" => "更新成功",
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "更新失败",
                ]);
            }
        }
        //项目成员组合完毕，提交审核
        if (isset($data["username"])) {
            $username = $data["username"];
            $id = $data["id"];
            $admin = AdminModel::where("username", $username)->find();
            $project = ProjectModel::where("id", $id)->find();
            $join = $project->join;
            $p_aid = $project->aid;
            $aid = $admin->id;
            if ($join === 2) {
                return json([
                    "code" => 400,
                    "msg" => "该项目已经审核完毕，请勿再次提交！",
                ]);
            } else {
                if ($p_aid == $aid) {
                    $model = new ProjectModel();
                    $r = $model->save([
                        'state2' => 1,
                    ], ['id' => $id]);
                    if ($r) {
                        return json([
                            "code" => 200,
                            "msg" => "提交成功",
                        ]);
                    } else {
                        return json([
                            "code" => 400,
                            "msg" => "您已提交，请勿重复提交！",
                        ]);
                    }
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "对不起，您的权限不够！"
                    ]);
                }
            }
        }
        //领导或者超级管理员对于该项目的最终审核
        if (isset($data["state"])) {
            $state = $data["state"];
            $id = $data["id"];
            $psh = $data["psh"];
            $model = new ProjectModel();
            $r = $model->save([
                'states' => $state,
                "join" => 2
            ], ['id' => $id]);
            if ($r) {
                $project = ProjectModel::where("id", $id)->find();
                $pname = $project->name;
                $research_experts = $project->research_experts;
                $member = $project->member;
                //修改一下该项目的参研人员的在研项目信息，改到research_projects
                $member = json_decode($member, true);
                $cyid = []; //拿到项目组员用户名
                foreach ($member as $k => $v) {
                    array_push($cyid, $v["username"]);
                }
                foreach ($cyid as $a => $b) {
                    $user = AdminModel::where("username", $b)->find();
                    $research_project = $user->research_project;
                    $research_project = json_decode($research_project, true);
                    foreach ($research_project as $c => $d) {
                        if ($id === $d["id"]) {
                            unset($research_project[$c]);
                        }
                    }
                    $research_project = array_values($research_project);
                    $research_project = json_encode($research_project, JSON_UNESCAPED_UNICODE);
                    $research_projects = $user->research_projects;
                    if ($research_projects) {
                        $research_projects = json_decode($research_projects, true);
                        $psh = json_decode($psh, true);
                        $research_projects = array_merge($research_projects, $psh);
                        $research_projects = array_values($research_projects);
                        $research_projects = json_encode($research_projects, JSON_UNESCAPED_UNICODE);
                        $model1 = new AdminModel();
                        $r = $model1->save([
                            'research_project' => $research_project,
                            'research_projects' => $research_projects,
                        ], ['username' => $b]);
                    } else {
                        $model1 = new AdminModel();
                        $r = $model1->save([
                            'research_project' => $research_project,
                            'research_projects' => $psh,
                        ], ['username' => $b]);
                    }
                }
                $research_experts = json_decode($research_experts, true);
                $aid = [];
                //获取一下该项目的参评人员，修改一下他们的在评项目
                foreach ($research_experts as $k => $v) {
                    array_push($aid, $v["id"]);
                }
                $admin = AdminModel::where("id", "in", $aid)->select();
                foreach ($admin as $k => $v) {
                    $experts_project = $admin[$k]->experts_project;
                    $experts_project = json_decode($experts_project, true);
                    foreach ($experts_project as $a => $b) {
                        if ($experts_project[$a]["id"] == $id) {
                            //不论成功或者失败专家在研项目都要删去
                            unset($experts_project[$a]);
                            $experts_project = array_values($experts_project);
                            $experts_project = json_encode($experts_project, JSON_UNESCAPED_UNICODE);
                            //判断当前experts_projects是否有内容
                            $experts_projects = $admin[$k]->experts_projects;
                            if ($experts_projects) {
                                $experts_projects = json_decode($experts_projects, true);
                                $psh = json_decode($psh, true);
                                $experts_projects = array_merge($experts_projects, $psh);
                                $experts_projects = array_values($experts_projects);
                                $experts_projects = json_encode($experts_projects, JSON_UNESCAPED_UNICODE);
                                $model1 = new AdminModel();
                                $r = $model1->save([
                                    'experts_project' => $experts_project,
                                    'experts_projects' => $experts_projects,
                                ], ['id' => $admin[$k]->id]);
                            } else {
                                $model1 = new AdminModel();
                                $r = $model1->save([
                                    'experts_project' => $experts_project,
                                    'experts_projects' => $psh,
                                ], ['id' => $admin[$k]->id]);
                            }
                        }
                    }
                }
                return json([
                    "code" => 200,
                    "msg" => "审核成功",
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "审核失败",
                ]);
            }
        }
    }

    private function delete()
    {
        $data = input("get.");
        $id = $data["id"];
        $r = ProjectModel::destroy($id);
        if ($r) {
            return json([
                "code" => 200,
                "msg" => "删除成功"
            ]);
        } else {
            return json([
                "code" => 400,
                "msg" => "删除失败"
            ]);
        }
    }
}