<?php


namespace app\api\controller;


use app\api\model\CollegeModel;
use app\api\model\MeetingModel;
use think\controller\Rest;

class Meeting extends Rest
{
    public function Meeting()
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
        $model = new MeetingModel();
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
                $xjhy = MeetingModel::where("abroad", 1)->order("time","desc")->limit(1,11)->select();
                $yxxjhy = MeetingModel::where("abroad", 1)->order("time","desc")->limit(0,1)->select();
                $yjhy = MeetingModel::where("abroad", 2)->order("time","desc")->limit(1,11)->select();
                $yxyjhy = MeetingModel::where("abroad", 2)->order("time","desc")->limit(0,1)->select();
                if ($xjhy || $yxxjhy || $yjhy || $yxyjhy) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data1" => $xjhy,
                        "data2" => $yjhy,
                        "data3" => $yxxjhy,
                        "data4" => $yxyjhy,
                    ]);
                }
            }
        }
        if (isset($data["types"])){
            if ($data["types"] == "xjhy"){
                $xjhy = MeetingModel::where("abroad", 1)->order("time","desc")->select();
                if ($xjhy){
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $xjhy
                    ]);
                }else{
                    return json([
                        "code" => 400,
                        "msg" => "暂无项目信息",
                    ]);
                }
            }
            if ($data["types"] == "yjhy"){
                $yjhy = MeetingModel::where("abroad",2 )->order("time","desc")->select();
                if ($yjhy){
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $yjhy
                    ]);
                }else{
                    return json([
                        "code" => 400,
                        "msg" => "暂无项目信息",
                    ]);
                }
            }
            $id = $data["id"];
            $news = MeetingModel::where("id",$id)->find();
            if ($news){
                return json([
                    "code" => 200,
                    "msg" => "获取成功",
                    "data" => $news
                ]);
            }
        }
    }

    private function post()
    {
        $data = input("post.");
        $model = new MeetingModel($data);
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
                $model = new MeetingModel();
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
        }
    }

    private function delete()
    {
        $data = input("get.");
        $id = $data["id"];
        $r = MeetingModel::destroy($id);
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