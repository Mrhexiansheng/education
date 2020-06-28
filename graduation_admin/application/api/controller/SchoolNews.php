<?php


namespace app\api\controller;


use app\api\model\CollegeModel;
use app\api\model\MeetingModel;
use app\api\model\NewsModel;
use app\api\model\NoticeModel;
use app\api\model\SchoolNewsModel;
use think\controller\Rest;
use think\Db;

class SchoolNews extends Rest
{
    public function SchoolNews()
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
        $model = new SchoolNewsModel();
        $data = input("get.");
        if (isset($data["type"])) {
            if ($data["type"] == "ht") {
                $news = $model::all();
                for ($i = 0; $i < count($news); $i++) {
                    $college_number = $news[$i]["college"];
                    $collegemsg = CollegeModel::where("id", $college_number)->find();
                    $college = $collegemsg->college;
                    $news[$i]["college"] = $college;
                }
                if (isset($news)) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $news
                    ]);
                }
            }
            if ($data["type"] == "qt") {
                $xj = SchoolNewsModel::where("abroad", 1)->order("time", "desc")->limit(1, 11)->select();
                $yxxj = SchoolNewsModel::where("abroad", 1)->order("time", "desc")->limit(0, 1)->select();
                $yj = SchoolNewsModel::where("abroad", 2)->order("time", "desc")->limit(1, 11)->select();
                $yxyj = SchoolNewsModel::where("abroad", 2)->order("time", "desc")->limit(0, 1)->select();
                if ($xj || $yj) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data1" => $xj,
                        "data2" => $yj,
                        "data3" => $yxxj,
                        "data4" => $yxyj,
                    ]);
                }
            }
        }
        if (isset($data["types"])) {
            if ($data["types"] == "xj") {
                $xj = SchoolNewsModel::where("abroad", 1)->order("time", "desc")->select();
                if ($xj) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $xj
                    ]);
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "暂无项目信息",
                    ]);
                }
            }
            if ($data["types"] == "yj") {
                $yj = SchoolNewsModel::where("abroad", 2)->order("time", "desc")->select();
                if ($yj) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $yj
                    ]);
                } else {
                    return json([
                        "code" => 400,
                        "msg" => "暂无项目信息",
                    ]);
                }
            }
            $id = $data["id"];
            $news = SchoolNewsModel::where("id", $id)->find();
            if ($news) {
                return json([
                    "code" => 200,
                    "msg" => "获取成功",
                    "data" => $news
                ]);
            }
        }
        if (isset($data["edit"])) {
            $id = $data["id"];
            $news = SchoolNewsModel::where("id", $id)->find();
            if ($news) {
                return json([
                    "code" => 200,
                    "msg" => "获取成功",
                    "data" => $news
                ]);
            } else {
                return json([
                    "code" => 400,
                    "msg" => "获取失败",
                ]);
            }
        }
        if (isset($data["require"])) {
            //获取新闻资讯
            $data1 = NewsModel::order("time","desc")->limit(1,11)->select();
            $data2 = NewsModel::order("time","desc")->limit(0,1)->select();
            //获取学校资讯
            $data3 = SchoolNewsModel::order("time","desc")->limit(1,11)->select();
            $data4 = SchoolNewsModel::order("time","desc")->limit(0,1)->select();
            //获取通知信息
            $data5 = NoticeModel::order("time","desc")->limit(1,11)->select();
            $data6 = NoticeModel::order("time","desc")->limit(0,1)->select();
            //获取会议信息
            $data7 = MeetingModel::order("time","desc")->limit(1,11)->select();
            $data8 = MeetingModel::order("time","desc")->limit(0,1)->select();
            if ($data1||$data2||$data3||$data4||$data5||$data6||$data7||$data8){
                return json([
                    "code" => 200,
                    "msg" => "获取成功",
                    "data1" => $data1,
                    "data2" => $data2,
                    "data3" => $data3,
                    "data4" => $data4,
                    "data5" => $data5,
                    "data6" => $data6,
                    "data7" => $data7,
                    "data8" => $data8,
                ]);
            }
        }
        if (isset($data["search"])){
            $searchData = $data["search"];
            $res = [];
            $res1 = Db::name("school_news")
                ->where("title","like","%$searchData%")
                ->whereOr("title","like","%$searchData")
                ->whereOr("title","like","$searchData%")
                ->select();
            $res2 = Db::name("news")
                ->where("title","like","%$searchData%")
                ->whereOr("title","like","%$searchData")
                ->whereOr("title","like","$searchData%")
                ->select();
            $res3 = Db::name("notice")
                ->where("title","like","%$searchData%")
                ->whereOr("title","like","%$searchData")
                ->whereOr("title","like","$searchData%")
                ->select();
            $res4 = Db::name("meeting")
                ->where("title","like","%$searchData%")
                ->whereOr("title","like","%$searchData")
                ->whereOr("title","like","$searchData%")
                ->select();
            if ($res1){
                $res = array_merge($res,$res1);
            }
            if ($res2){
                $res = array_merge($res,$res2);
            }
            if ($res3){
                $res = array_merge($res,$res3);
            }
            if ($res4){
                $res = array_merge($res,$res4);
            }
            $res = array_values($res);
            if ($res){
                return json([
                    "code" => 200,
                    "msg" => "获取成功",
                    "data" => $res
                ]);
            }
        }
    }

    private function post()
    {
        $data = input("post.");
        $model = new SchoolNewsModel($data);
        $r = $model->allowField(true)->save();
        if ($r) {
            return json([
                "msg" => "添加成功",
                "code" => 200,
            ]);
        } else {
            return json([
                "msg" => "添加失败",
                "code" => 400,
            ]);
        }
    }

    private function put()
    {
        $data = input("put.");
        if (isset($data["type"])) {
            $type = $data["type"];
            if ($type == "title") {
                $title = $data["title"];
                $id = $data["id"];
                $model = new SchoolNewsModel();
                $r = $model->save([
                    'title' => $title,
                ], ['id' => $id]);;
                if ($r) {
                    return json([
                        "msg" => "更新成功!",
                        "code" => 200,
                    ]);
                } else {
                    return json([
                        "msg" => "更新失败!",
                        "code" => 400,
                    ]);
                }
            }
            if ($type == "abroad") {
                $abroad = $data["a"];
                $id = $data["id"];
                $model = new SchoolNewsModel();
                $r = $model->save([
                    'abroad' => $abroad,
                ], ['id' => $id]);;
                if ($r) {
                    return json([
                        "msg" => "更新成功!",
                        "code" => 200,
                    ]);
                } else {
                    return json([
                        "msg" => "更新失败!",
                        "code" => 400,
                    ]);
                }
            }
        }
    }

    private function delete()
    {
        $data = input("get.");
        $id = $data["id"];
        $r = SchoolNewsModel::destroy($id);
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