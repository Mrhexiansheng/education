<?php


namespace app\api\controller;


use think\controller\Rest;

class Article extends Rest
{
    public function article()
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