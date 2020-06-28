<?php


namespace app\api\controller;


use app\api\model\ProjectModel;
use app\api\model\ProjectTypeModel;
use think\controller\Rest;

class ProjectType extends Rest
{
    public function projectType()
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
        $data = ProjectTypeModel::all();
        $project = ProjectModel::all();
        $count = count($project);
        return json([
            "code" => 200,
            "msg" => "获取成功",
            "data" => $data,
            "count"=>$count
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