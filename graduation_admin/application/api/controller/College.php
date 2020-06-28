<?php


namespace app\api\controller;


use app\api\model\CollegeModel;
use think\controller\Rest;

class College extends Rest
{
    public function college()
    {
        switch ($this->method) {
            case "get":
                return $this->get();
            case "post":
                return $this->post();
            case "put":
                return $this->put();
            case "delete":
                return $this->delete();
        }
    }

    private function get()
    {
        $data = CollegeModel::all();
        return json([
            "code" => 200,
            "msg" => "获取成功",
            "data" => $data
        ]);
    }

    private function post()
    {

    }

    private function put()
    {

    }

    private function delete()
    {

    }
}