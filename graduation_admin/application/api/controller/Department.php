<?php


namespace app\api\controller;


use app\api\model\DepartmentModel;
use think\controller\Rest;

class Department extends Rest
{
    public function department()
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
        $model = new DepartmentModel();
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

    }

    private function put()
    {

    }

    private function delete()
    {

    }
}