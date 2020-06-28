<?php


namespace app\api\controller;


use app\api\model\AdminModel;
use app\api\model\CollegeModel;
use app\api\model\ProjectModel;
use app\api\model\ProjectTypeModel;
use think\controller\Rest;
use think\Db;

class User extends Rest
{
    public function User()
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
        if (isset($data["size"])) {
            $size = $data["size"];
            $page = $data["page"];
            $start = ($page - 1) * $size;
            $model = new AdminModel();
            $admin = AdminModel::where("role", ">", 1)->limit($start, $size)->order("id", "asc")->select();
            $count = AdminModel::where("role", ">", 1)->select();
            $total = count($count);
            if (isset($admin)) {
                for ($i = 0; $i < count($admin); $i++) {
                    $college_number = $admin[$i]["college"];
                    if ($college_number > 0) {
                        $collegemsg = CollegeModel::where("id", $college_number)->find();
                        $college = $collegemsg->college;
                        $admin[$i]["college"] = $college;
                    } else {
                        $admin[$i]["college"] = "专家";
                    }
                }
                return json([
                    "msg" => "查询成功",
                    "code" => 200,
                    "data" => $admin,
                    "total" => $total
                ]);
            } else {
                return json([
                    "msg" => "查询失败",
                    "code" => 400
                ]);
            }
        }
        if (isset($data["username"])) {
            $username = $data["username"];
            $admin = AdminModel::where("username", $username)->find();
            $research_project = $admin->research_project;
            if (isset($research_project)) {
                return json([
                    "msg" => "查询成功",
                    "code" => 200,
                    "research_project" => $research_project
                ]);
            } else {
                return json([
                    "msg" => "查询失败",
                    "code" => 400
                ]);
            }
        }
        //获取当前用户参研项目的成员信息->删除
        if (isset($data["username_member"])) {
            $username = $data["username_member"];
            $admin = AdminModel::where("username", $username)->find();
            $id = $admin->id;
            $project = ProjectModel::where("aid", $id)->find();
            //说明是项目负责人要查看项目组员信息
            if ($project) {
                $member = $project->member;
                $member = json_decode($member, true);
                $usernames = [];
                foreach ($member as $k => $v) {
                    array_push($usernames, $v["username"]);
                }
                $res = AdminModel::where('username', "in", $usernames)->select();
                for ($i = 0; $i < count($res); $i++) {
                    $college_number = $res[$i]["college"];
                    $collegemsg = CollegeModel::where("id", $college_number)->find();
                    $college = $collegemsg->college;
                    $res[$i]["college"] = $college;
                }
                if ($res) {
                    return json([
                        "msg" => "查询成功",
                        "code" => 200,
                        "data" => $res,
                    ]);
                } else {
                    return json([
                        "msg" => "查询失败",
                        "code" => 400
                    ]);
                }
            } else {
                $research_project = $admin->research_project;
                $research_project = json_decode($research_project, true);
                $pid = [];//获取该成员下面所有参研的项目id
                foreach ($research_project as $k => $v) {
                    array_push($pid, $v["id"]);
                }
                $username1 = [];
                $project2 = ProjectModel::where("id", "in", $pid)->select();
                foreach ($project2 as $a => $b) {
                    $member3 = $b->member;
                    $member3 = json_decode($member3, true);
                    foreach ($member3 as $c => $d) {
                        array_push($username1, $d["username"]);
                    }
                }
                $res1 = AdminModel::where('username', "in", $username1)->select();
                for ($i = 0; $i < count($res1); $i++) {
                    $college_number = $res1[$i]["college"];
                    $collegemsg = CollegeModel::where("id", $college_number)->find();
                    $college = $collegemsg->college;
                    $res1[$i]["college"] = $college;
                }
                if ($res1) {
                    return json([
                        "msg" => "查询成功",
                        "code" => 200,
                        "data" => $res1
                    ]);
                } else {
                    return json([
                        "msg" => "查询失败",
                        "code" => 400
                    ]);
                }
            }
        }
        //搜索用户信息
        if (isset($data["search"])) {
            $search = $data["search"];
            $model = new AdminModel();
//            $admin = $model->where("realname","like",["%$search%"],"OR")->select();
//            $admin = $model->where("realname like '%$search%' OR realname like '$search%' OR realname like '%$search'")->select();
            $admin = Db::query("SELECT * FROM admin WHERE (realname LIKE '$search%' or realname LIKE '%$search%' or realname LIKE '%$search');");
            if ($admin) {
                return json([
                    "code" => 200,
                    "msg" => "搜索成功",
                    "data" => $admin
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "暂无该用户,换个名字吧！"
                ]);
            }
        }
    }

    private function post()
    {

    }

    private function put()
    {
        $data = input("put.");
        $id = $data["id"];
        if (isset($data["state"])) {
            $state = $data["state"];
            $model = new AdminModel();
            $r = $model->save([
                'state' => $state,
            ], ['id' => $id]);
            if ($r) {
                return json([
                    "msg" => "修改成功",
                    "code" => 200
                ]);
            } else {
                return json([
                    "msg" => "修改失败",
                    "code" => 400
                ]);
            }
        }
        $project = ProjectModel::where("aid", $id)->find();
        $admin = AdminModel::where("id", $id)->find();
        $research_project = $admin->research_project;
        $username = $admin->username;
        if (isset($project)) {   //说明此人是项目负责人
            $member = $project->member;
            $pid = $project->id;
            return json([
                "code" => 200,
                "msg" => "查询成功",
                "member" => $member,  //获得项目组成员信息
                "pid" => $pid       //获得该负责人当前绑定的项目id
            ]);
        } else {
            return json([
                "code" => 200,
                "msg" => "查询成功",
                "research_project" => $research_project,  //获得该用户的参研项目信息
                "username" => $username
            ]);
        }
    }

    private function delete()
    {
        $data = input("get.");
        if (isset($data["id"])) {
            $id = $data["id"];
            $project = ProjectModel::where("aid", $id)->find();
            if (isset($project)) {  //删除负责人类型的用户时就相等于把项目以及所有关联的项目成员信息一并更新
                $pid = $project->id;
                $p = ProjectModel::destroy($pid);
                if ($p) {
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
        //删除项目组成员
        if (isset($data["delusername"])) {
            $username = $data["username"];
            $delusername = $data["delusername"];
            $admin = AdminModel::where("username", $username)->find();
            $admin1 = AdminModel::where("username", $delusername)->find();
            //先判断有没有删除权限
            $id = $admin->id;
            $project = ProjectModel::where("aid", $id)->find();//找到该项目
            if ($project) {
                if ($username == $delusername) {//说明是项目组组长在自己删除自己，就是想要删除项目
                    //先更新组员信息
                    $id = $admin->id;
                    $project = ProjectModel::where("aid", $id)->find();//找到该项目
                    $pid = $project->id;
                    $member = $project->member;
                    $member = json_decode($member, true);
                    //拿到组员信息
                    foreach ($member as $k => $v) {
                        $admins = AdminModel::where("username", $v["username"])->find();
                        $research_project = $admins->research_project;
                        $research_project = json_decode($research_project, true);
                        foreach ($research_project as $a => $b) {
                            if ($b["id"] === $pid) {
                                unset($research_project[$a]);
                            }
                        }
                        $research_project = array_values($research_project);
                        $research_project = json_encode($research_project, JSON_UNESCAPED_UNICODE);
                        $model = new AdminModel();
                        $r = $model->save([
                            'research_project' => $research_project,
                        ], ['username' => $v["username"]]);
                        $p = ProjectModel::destroy($pid);
                        if ($p && $r) {
                            return json([
                                "code" => 200,
                                "msg" => "信息已更新，项目成功删除"
                            ]);
                        } else {
                            return json([
                                "code" => 400,
                                "msg" => "信息更新失败，项目删除失败"
                            ]);
                        }
                    }
                } else { //不是在删除项目，删除组员
                    $id = $admin->id;
                    $project = ProjectModel::where("aid", $id)->find();//找到该项目
                    $pid1 = $project->id;//找到项目id
                    $member1 = $project->member;
                    $member1 = json_decode($member1, true);
                    $member3 =$member1;
                    foreach ($member1 as $m => $n) {
                        if ($username == $n["username"]) {
                            unset($member1[$m]);
                        }
                    }
                    $member1 = array_values($member1);
                    foreach ($member1 as $k => $v) {
                        $admin2 = AdminModel::where("username", $v["username"])->find();
                        $research_project1 = $admin2->research_project;
                        $research_project1 = json_decode($research_project1, true);
                        foreach ($research_project1 as $a => $b) {
                            if ($b["id"] === $pid1) {
                                unset($research_project1[$a]);
                            }
                        }
                        $research_project1 = array_values($research_project1);
                        $research_project1 = json_encode($research_project1, JSON_UNESCAPED_UNICODE);
                        $model = new AdminModel();
                        $r = $model->save([
                            'research_project' => $research_project1,
                        ], ['username' => $v["username"]]);
                    }
                    foreach ($member3 as $c => $d) {
                        if ($d["username"] == $delusername) {
                            unset($member3[$c]);
                        }
                    }
                    $member3 = array_values($member3);
                    $member3 = json_encode($member3, JSON_UNESCAPED_UNICODE);
                    $model2 = new ProjectModel();
                    $p = $model2->save([
                        'member' => $member3,
                    ], ['id' => $pid1]);
                    if ($p) {
                        return json([
                            "code" => 200,
                            "msg" => "删除成功",
                        ]);
                    } else {
                        return json([
                            "code" => 400,
                            "msg" => "删除失败",
                        ]);
                    }
                }
            } else {
                return json([
                    "code" => 400,
                    "msg" => "对不起，您的权限不足！"
                ]);
            }

        }
    }
}