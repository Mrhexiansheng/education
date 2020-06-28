<?php


namespace app\api\controller;


use app\api\model\AdminModel;
use app\api\model\CollegeModel;
use app\api\model\DepartmentModel;
use app\api\model\ProjectModel;
use app\api\model\RoleModel;

use think\captcha\Captcha;
use think\Controller;

class Admin extends Controller
{
    //产生哈希值
    function createHash()
    {
        return md5(time());
    }

    //生成密码
    function createPass($pass, $hash)
    {
        return md5(sha1($pass) . $hash);
    }

    //验证码验证
    function yz()
    {
        $config = [
            // 验证码字体大小
            'fontSize' => 30,
            // 验证码位数
            'length' => 4,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    //登录验证
    function login()
    {
        $model = new AdminModel();
        $username = input("post.username");
        $password = input("post.password");
        $last_login_time = input("post.last_login_time");
        $yzm = input("post.yzm");
        $captcha = new Captcha();
        if (!$captcha->check($yzm)) {
            return json([
                "msg" => "验证码输入错误",
                "code" => 400
            ]);
        }
        $r = $model::where("username", $username)->find();
        if (isset($r)) {
            if ($r->state === 1) {
                $r->last_login_time = $last_login_time;
                $r->save();
                $pass = $this->createPass($password, $r->hash);
                $avatar = $r->avatar;
                $realname = $r->realname;
                if ($pass == $r->password) {
                    $role = $r->role;
                    $data = RoleModel::where("role", $role)->find();
                    $route = $data->route;
                    return json([
                        "msg" => "登录成功",
                        "code" => 200,
                        "route" => $route,
                        "avatar" => $avatar,
                        "realname" => $realname
                    ]);
                } else {
                    return json([
                        "msg" => "验证码输入错误",
                        "code" => 400
                    ]);
                }
            } else {
                return json([
                    "msg" => "您的账号已被冻结！详情，请联系管理员。",
                    "code" => 400
                ]);
            }
        } else {
            return json([
                "msg" => "对不起，该用户不存在，您可以注册一个！",
                "code" => 400
            ]);
        }

    }

    //获得个人信息
    function getChangeData()
    {
        $username = input("get.username");
        $model = new AdminModel();
        $data = $model->where("username", $username)->find();
        $college = $data->college;
        $collegemsg = CollegeModel::get($college);
        $college = $collegemsg->college;
        $data->college = $college;
        $depart_number = $data->depart_number;
        $departmsg = DepartmentModel::get($depart_number);
        $depart_number = $departmsg->name;
        $data->depart_number = $depart_number;
        if (isset($data)) {
            return json([
                "msg" => "获取成功",
                "code" => 200,
                "data" => $data
            ]);
        } else {
            return json([
                "msg" => "获取失败",
                "code" => 400
            ]);
        }
    }

    //获取超级管理员信息
    function getRootData()
    {
        $username = input("get.username");
        $model = new AdminModel();
        $data = $model->where("username", $username)->find();
        if (isset($data)) {
            return json([
                "msg" => "获取成功",
                "code" => 200,
                "data" => $data
            ]);
        } else {
            return json([
                "msg" => "获取失败",
                "code" => 400
            ]);
        }
    }

    //获取专家信息
    function getExpertsData()
    {
        $username = input("get.username");
        $model = new AdminModel();
        $data = $model->where("username", $username)->find();
        if (isset($data)) {
            return json([
                "msg" => "获取成功",
                "code" => 200,
                "data" => $data
            ]);
        } else {
            return json([
                "msg" => "获取失败",
                "code" => 400
            ]);
        }
    }

    //分配项目时获取转接信息
    function getexpersData()
    {
        $username = input("get.username");
        $pid = input("get.pid");
        $type = ProjectModel::where("id", $pid)->find();
        $type1 = $type->type;
        $model = new AdminModel();
        $data = $model->where("username", $username)->find();
        $role = $data->role;
        if ($role < 3) {
            $expers = $model->where("role", "=", 3)->where("experts_type", "=", $type1)->select();  //先找到专家
            foreach ($expers as $k => $v) {
                if ($v->experts_project) {
                    $experts_project = json_decode($v->experts_project, true);
                    $a = count($experts_project);
                    if ($a == 3) {
                        unset($expers[$k]);
                    }
                    foreach ($experts_project as $b => $c) {
                        if ($c["id"] == $pid) {
                            unset($expers[$k]);
                        }
                    }

                }

            }
            if (isset($expers)) {
                return json([
                    "msg" => "获取成功",
                    "code" => 200,
                    "data" => $expers
                ]);
            } else {
                return json([
                    "msg" => "获取失败",
                    "code" => 400
                ]);
            }
        }
    }

    //给专家分配完项目之后，专家在评项目的修改
    function updateExpertsProject()
    {
        $data = input("put.");
        $expertsProjectMsg = $data["expertsProjectMsg"];
        $expertsProjectMsg = json_decode($expertsProjectMsg, true);
        $pid = $data["pid"];
        $project = ProjectModel::where("id", $pid)->find();
        $pname = $project->name;
        $model = new AdminModel();
        $a = [
            "id" => $pid,
            "name" => $pname
        ];
        $c = json_encode($a, JSON_UNESCAPED_UNICODE);
        $admin = $model->where("id", "in", $expertsProjectMsg)->select();
        for ($i = 0; $i < count($admin); $i++) {
            if ($admin[$i]->experts_project) {
                $b = count(json_decode($admin[$i]->experts_project, true));
                if ($b + 1 <= 3) {
                    $newexperts_project = json_decode($admin[$i]->experts_project, true);
                    $a = "[" . $c . "]";
                    $a = json_decode($a, true);
                    $newexperts_project = array_merge($newexperts_project, $a);
                    $newexperts_project = json_encode($newexperts_project, JSON_UNESCAPED_UNICODE);
                    $r = $model->where("id", "in", $expertsProjectMsg)->update(['experts_project' => $newexperts_project]);
                    if ($r && $i + 1 == count($admin)) {
                        return json([
                            "msg" => "专家在研项目更新成功！",
                            "code" => 200,
                        ]);
                    } else {
                        return json([
                            "msg" => "专家在研项目更新失败！",
                            "code" => 400,
                        ]);
                    }
                } else {
                    return json([
                        "msg" => "专家在研项目不能大于3个！",
                        "code" => 400,
                    ]);
                }
            } else {
                $r = $model->where("id", "in", $expertsProjectMsg)->update(['experts_project' => "[" . $c . "]"]);
                if ($r) {
                    return json([
                        "msg" => "专家在研项目更新成功！",
                        "code" => 200,
                    ]);
                } else {
                    return json([
                        "msg" => "专家在研项目更新失败！",
                        "code" => 400,
                    ]);
                }
//                for ($d = 0; $d < count($admin); $d++) {
//                    $r = $model->save([
//                        'experts_project' => "[" . $c . "]"
//                    ], ['id' => $admin[$d]->id]);
//                    while ($r && $d + 1 == count($admin)) {
//                        return json([
//                            "msg" => "专家在研项目更新成功！",
//                            "code" => 200,
//                        ]);
//                    }
//                }
            }
        }
    }

    //针对性修改个人信息
    function update()
    {
        $data = input("put.");
        $model = new AdminModel();
        if (isset($data["username"])) {
            $username = $data["username"];
            $message = $model->where("username", $username)->find();
            $id = $message->id;
            if (isset($data["password1"]) && isset($data["password2"]) && isset($data["password3"])) {
                $pass = $data["password1"];
                $pass1 = $data["password2"];
                $pass2 = $data["password3"];
                $password = $message->password;  //数据库存储的密码
                $newpass = $this->createPass($pass, $message->hash);
                if ($newpass == $password) {
                    if ($pass1 == $pass2) {
                        $newpassword = $this->createPass($pass1, $message->hash);
                        $data["password"] = $newpassword;
                        $r = $model->allowField(true)->save($data, ['id' => $id]);
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
                    } else {
                        return json([
                            "msg" => "两次密码输入请保持一致",
                            "code" => 400
                        ]);
                    }
                } else {
                    return json([
                        "msg" => "原密码输入错误",
                        "code" => 400
                    ]);
                }
            } else if (isset($data["experts_type"]) || isset($data["abstract"])) {
                $r = $model->save([
                    "realname" => $data["realname"],
                    "phone" => $data["phone"],
                    "avatar" => $data["avatar"],
                    "experts_type" => $data["experts_type"],
                    "abstract" => $data["abstract"],
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
            } else {
                $r = $model->save([
                    "realname" => $data["realname"],
                    "phone" => $data["phone"],
                    "position" => $data["position"],
                    "avatar" => $data["avatar"],
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
        } else {
            return json([
                "msg" => "修改失败",
                "code" => 400
            ]);
        }
    }

    //验证领导注册信息
    function beforeRegistered()
    {
        $data = input("get.");
        $college = $data["college"];
        $role = $data["role"];
        if($role == 2){
            $admin = AdminModel::where("role", $role)->where("college", $college)->find();
            if ($admin) {
                return json([
                    "msg" => "注册失败，请勿重复注册领导账号！",
                    "code" => 400,
                ]);
            } else {
                return json([
                    "msg" => "可以注册",
                    "code" => 200,
                ]);
            }
        }else{
            return json([
                "msg" => "可以注册",
                "code" => 200,
            ]);
        }
    }

    //用户注册h8
    function registered()
    {
        $data = input("post.");
        $model = new AdminModel();
        if (isset($data["username"])) {   //对用户名做一个限制，用户名是要唯一索引的，不能重复
            $username = $data["username"];
            $data1 = $model->where("username", $username)->find();
            if ($data1) {
                return json([
                    "msg" => "注册失败，用户名重复，请重新填写",
                    "code" => 400,
                ]);
            } else {
                $hash = $this->createHash(); //哈希值
                $pass = $data["password1"];
                $password = $this->createPass($pass, $hash); //创造密码
                $username = $data["username"];
                $avatar = $data["avatar"];
                $phone = $data["phone"];
                $last_login_time = $data["last_login_time"];
                $college = $data["college"];
                $depart_number = $data["depart_number"];
                $role = $data["role"];
                $model->username = $username;
                $model->password = $password;
                $model->hash = $hash;
                $model->avatar = $avatar;
                $model->phone = $phone;
                $model->last_login_time = $last_login_time;
                $model->college = $college;
                $model->depart_number = $depart_number;
                $model->role = $role;
                $model->teachers_title = $data["teachers_title"];
                $model->degree = $data["degree"];
                $model->experts_type = $data["experts_type"];
                $r = $model->save();
                if ($r) {
                    return json([
                        "msg" => "注册成功",
                        "code" => 200,
                    ]);
                } else {
                    return json([
                        "msg" => "注册失败",
                        "code" => 400,
                    ]);
                }
            }
        }
    }

    //密码重置
    function resetPass()
    {
        $data = input("post.");
        if (isset($data["id"])) {
            $id = $data["id"];
            $message = AdminModel::where("id", $id)->find();
            $hash = $message->hash;
            $newPass = $this->createPass("123456", $hash);
            $message->password = $newPass;
            $r = $message->save();
            if ($r) {
                return json([
                    "code" => 200,
                    "msg" => "重置成功",
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "重置失败",
                ]);
            }
        }
    }

    //更新用户参与的项目信息
    function updateResearchProject()
    {
        $data = input("put.");
        $username = $data["username"];
        $research_project = $data["research_project"];
        $msg = AdminModel::where("username", $username)->find();
        $id = $msg->id;
        $model = new AdminModel();
        $r = $model->save([
            'research_project' => $research_project,
        ], ['id' => $id]);
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

    //删除时获取用户的参妍项目信息
    function getResearchProject()
    {
        $username = input("get.username");
        $admin = AdminModel::where("username", $username)->find();
        $research_project = $admin->research_project;
        if (isset($research_project)) {
            return json([
                "code" => 200,
                "data" => $research_project,
                "msg" => "获取成功"
            ]);
        }
    }

    //修改删除用户时的参研项目信息
    function updateProject()
    {
        $data = input("put.");
        $username = $data["username"];
        $research_project = $data["research_project"];
        $msg = AdminModel::where("username", $username)->find();
        $id = $msg->id;
        $model = new AdminModel();
        $r = $model->save([
            'research_project' => $research_project,
        ], ['id' => $id]);
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

    //删除用户
    function deleteUser()
    {
        $data = input("get.");
        $id = $data["id"];
        $model = new AdminModel();
        $admin = AdminModel::where("id", $id)->find();
        $username = $admin->username;
        $role = $admin->role;
        $research_project = $admin->research_project;
        $project = ProjectModel::where("aid", $id)->find();
        if ($role === 2) {
            $r = AdminModel::destroy($id);
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
        if ($role === 3) {    //专家只需要修改一下自己参评的项目中的项目信息
            $experts_project = $admin->experts_project;
            if ($experts_project) {
                $experts_project = json_decode($experts_project, true);
                $pid = [];
                foreach ($experts_project as $k => $v) {
                    array_push($pid, $v["id"]);
                }
                foreach ($pid as $a => $b) {
                    $project1 = ProjectModel::where("id", $b)->find();
                    $research_experts1 = $project1->research_experts;
                    $research_experts1 = json_decode($research_experts1, true);
                    foreach ($research_experts1 as $c => $d) {
                        if ($d["id"] == $id) {
                            unset($research_experts1[$c]);
                        }
                    }
                    $research_experts1 = array_values($research_experts1);
                    $research_experts1 = json_encode($research_experts1, JSON_UNESCAPED_UNICODE);
                    $model1 = new ProjectModel();
                    $r = $model1->save([
                        'research_experts' => $research_experts1,
                    ], ['id' => $b]);//所有项目的参评专家信息更新完毕
                }
                $r = AdminModel::destroy($id);
                if ($r) {
                    return json([
                        "code" => 200,
                        "msg" => "删除成功"
                    ]);
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "删除失败",
                    ]);
                }
            } else {
                $r = AdminModel::destroy($id);
                if ($r) {
                    return json([
                        "code" => 200,
                        "msg" => "删除成功"
                    ]);
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "删除失败",
                        "data" => $r
                    ]);
                }
            }
        }
        if ($role === 4) {  //说明该用户是教师
            if ($project) {  //说明该用户是项目负责人，需要把项目删除掉
                $pid = $project->id;   //拿到项目id
                $member = $project->member; // 拿到项目的人员信息
                $research_experts = $project->research_experts;
                if ($member) {
                    $member = json_decode($member, true);
                    $aid = [];
                    foreach ($member as $k => $v) {
                        array_push($aid, $v["username"]); //拿到参与该项目的用户id
                    }
                    foreach ($aid as $a => $b) {
                        $admins = AdminModel::where("username", $b)->find();
                        $research_project = $admins->research_project;
                        $research_project = json_decode($research_project, true);
                        foreach ($research_project as $c => $d) {
                            if ($d["id"] === $pid) {
                                unset($research_project[$c]);
                            }
                        }
                        $research_project = array_values($research_project);//删除完毕
                        $research_project = json_encode($research_project, JSON_UNESCAPED_UNICODE);
                        $r = $model->save([
                            'research_expert' => $research_project,
                        ], ['username' => $b]);
                    } //每个用户的参研项目更新成功
                    //开始修改专家在评项目,没有就不必修改了
                    if ($research_experts) {
                        $research_experts = json_decode($research_experts, true);
                        $eid = [];
                        $pid = $project->id;   //拿到项目id
                        foreach ($research_experts as $e => $f) {
                            array_push($eid, $f["id"]);
                        }
                        foreach ($eid as $g => $h) {
                            $admine = AdminModel::where("id", $h)->find();
                            $experts_project = json_decode($admine->experts_project, true);
                            foreach ($experts_project as $i => $j) {
                                if ($j["id"] === $pid) {
                                    unset($experts_project[$i]);
                                }
                            }
                            $experts_project = array_values($experts_project);//删除完毕
                            $experts_project = json_encode($experts_project, JSON_UNESCAPED_UNICODE);
                            $r = $model->save([
                                'experts_project' => $experts_project,
                            ], ['id' => $h]);
                        }
                    }
                    $r = AdminModel::destroy($id);
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
                } else {
                    //开始修改专家在评项目,没有就不必修改了
                    if ($research_experts) {
                        $research_experts = json_decode($research_experts, true);
                        $eid = [];
                        $pid = $project->id;   //拿到项目id
                        foreach ($research_experts as $e => $f) {
                            array_push($eid, $f["id"]);
                        }
                        foreach ($eid as $g => $h) {
                            $admine = AdminModel::where("id", $h)->find();
                            $experts_project = json_decode($admine->experts_project, true);
                            foreach ($experts_project as $i => $j) {
                                if ($j["id"] === $pid) {
                                    unset($experts_project[$i]);
                                }
                            }
                            $experts_project = array_values($experts_project);//删除完毕
                            $experts_project = json_encode($experts_project, JSON_UNESCAPED_UNICODE);
                            $r = $model->save([
                                'experts_project' => $experts_project,
                            ], ['id' => $h]);
                        }
                    }
                    $r = AdminModel::destroy($id);
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
            } else {
                //普通教师需要只需要根据自己的参研项目信息去项目里面进行修改
                $research_project = json_decode($research_project, true);
                if ($research_project) {
                    $ids = [];   //获取一下项目id
                    foreach ($research_project as $k => $l) {
                        array_push($ids, $l["id"]);
                    }
                    foreach ($ids as $m => $n) {
                        $projects = ProjectModel::where("id", $n)->find();
                        $member = $projects->member;
                        $member = json_decode($member, true);
                        foreach ($member as $o => $p) {
                            if ($p["username"] == $username) {
                                unset($member[$o]);
                            }
                        }
                        $member = array_values($member);
                        $member = json_encode($member, JSON_UNESCAPED_UNICODE);
                        $model2 = new ProjectModel();
                        $r = $model2->save([
                            'member' => $member,
                        ], ['id' => $n]); //该用户参与的项目信息修改完毕
                    }
                    $r = AdminModel::destroy($id);
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
                } else {
                    $r = AdminModel::destroy($id);
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
        }
    }
}