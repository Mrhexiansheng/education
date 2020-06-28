<?php


namespace app\api\controller;


use think\controller\Rest;

use think\File;

class Upload extends Rest
{
    public function upload()
    {
        $file = input("file.file");
        if ($file) {
            $info = $file->validate(['size' => 100000000, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $wj = $info->getSaveName();
                $wj = str_replace("\\", "/", $wj);
                echo "/uploads/" . $wj;
            } else {
                // 上传失败获取错误信息
                echo "error";
            }
        }
    }

    public function uploadFile()
    {
        $file = input("file.file");
        if ($file) {
            $info = $file->validate(['ext' => 'doc,xls,zip,docx'])->move(ROOT_PATH . 'public' . DS . 'uploadsfile');
            if ($info) {
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $wj = $info->getSaveName();
                $wj = str_replace("\\", "/", $wj);
                echo "/uploadsfile/" . $wj;
            } else {
                // 上传失败获取错误信息
                echo "error";
            }
        }
    }
}