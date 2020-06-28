<?php


namespace app\api\controller;


use app\api\model\CollegeModel;
use app\api\model\NoticeModel;
use think\controller\Rest;

class Notice extends Rest
{
    public function Notice()
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
        $model = new NoticeModel();
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
                $lx = NoticeModel::where("abroad", 1)->order("time","desc")->limit(1,11)->select();
                $yxlx = NoticeModel::where("abroad", 1)->order("time","desc")->limit(0,1)->select();
                $sh = NoticeModel::where("abroad", 2)->order("time","desc")->limit(1,11)->select();
                $yxsh = NoticeModel::where("abroad", 2)->order("time","desc")->limit(0,1)->select();
                if ($lx || $yxlx || $yxsh || $sh) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data1" => $lx,
                        "data2" => $sh,
                        "data3" => $yxlx,
                        "data4" => $yxsh,
                    ]);
                }
            }
        }
        if (isset($data["types"])){
            if ($data["types"] == "lx"){
                $gn = NoticeModel::where("abroad", 1)->order("time","desc")->select();
                if ($gn){
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $gn
                    ]);
                }else{
                    return json([
                        "code" => 400,
                        "msg" => "暂无项目信息",
                    ]);
                }
            }
            if ($data["types"] == "sh"){
                $gw = NoticeModel::where("abroad",2 )->order("time","desc")->select();
                if ($gw){
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $gw
                    ]);
                }else{
                    return json([
                        "code" => 400,
                        "msg" => "暂无项目信息",
                    ]);
                }
            }
            $id = $data["id"];
            $news = NoticeModel::where("id",$id)->find();
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
        $model = new NoticeModel($data);
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
                $model = new NoticeModel();
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
                $model = new NoticeModel();
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
            if ($type == "type") {
                $abroad = $data["a"];
                $id = $data["id"];
                $model = new NoticeModel();
                $r = $model->save([
                    'type' => $abroad,
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
        $r = NoticeModel::destroy($id);
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