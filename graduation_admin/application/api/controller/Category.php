<?php


namespace app\api\controller;


use app\api\model\CategoryModel;
use think\controller\Rest;

class Category extends Rest
{
    public function category()
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
        $model = new CategoryModel();
        $data = $model::all();
        if (isset($data)) {
            return json([
                "code" => 200,
                "msg" => "获取成功",
                "data" => $data
            ]);
        }
    }

    private function post()
    {
        $data = input("post.");
        $catname = $data["catname"];
        $enname = $data["enname"];
        $model = new CategoryModel();
        $model->catname = $catname;
        $model->enname = $enname;
        $r = $model->save();
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
        $id = $data["id"];
        $catname = $data["catname"];
        $enname = $data["enname"];
        $model = new CategoryModel();
        $r = $model->save([
            'catname' => $catname,
            'enname' => $enname,
        ], ['id' => $id]);
        if ($r) {
            return json([
                "code" => 200,
                "msg" => "更新成功！"
            ]);
        } else {
            return json([
                "code" => 400,
                "msg" => "更新失败！",
            ]);
        }
    }

    private function delete()
    {
        $data = input("get.");
        $id = $data["id"];
        $r = CategoryModel::destroy($id);
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