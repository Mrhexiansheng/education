<?php


namespace app\api\controller;


use app\api\model\NewsModel;
use think\controller\Rest;

class News extends Rest
{
    public function News()
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
        $model = new NewsModel();
        $data = input("get.");
        if (isset($data["type"])) {
            if ($data["type"] == "ht") {
                $news = $model::all();
                if (isset($news)) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data" => $news
                    ]);
                }
            }
            if ($data["type"] == "qt") {
                $gn = NewsModel::where("abroad", 1)->order("time","desc")->limit(1,11)->select();
                $yxgn = NewsModel::where("abroad", 1)->order("time","desc")->limit(0,1)->select();
                $gw = NewsModel::where("abroad", 2)->order("time","desc")->limit(1,11)->select();
                $yxgw = NewsModel::where("abroad", 2)->order("time","desc")->limit(0,1)->select();
                if ($gn || $gw || $yxgn || $yxgw) {
                    return json([
                        "code" => 200,
                        "msg" => "获取成功",
                        "data1" => $gn,
                        "data2" => $gw,
                        "data3" => $yxgn,
                        "data4" => $yxgw,
                    ]);
                }
            }
        }
        if (isset($data["types"])){
            if ($data["types"] == "gn"){
                $gn = NewsModel::where("abroad", 1)->order("time","desc")->select();
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
            if ($data["types"] == "gw"){
                $gw = NewsModel::where("abroad",2 )->order("time","desc")->select();
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
            $news = NewsModel::where("id",$id)->find();
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
        $model = new NewsModel($data);
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
            if ($type == "abroad") {
                $abroad = $data["a"];
                $id = $data["id"];
                $model = new NewsModel();
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
            if ($type == "title") {
                $title = $data["title"];
                $id = $data["id"];
                $model = new NewsModel();
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
        $r = NewsModel::destroy($id);
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