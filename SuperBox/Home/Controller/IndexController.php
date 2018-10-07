<?php
namespace Home\Controller;
use \SuperBox\Controller\BaseController;
class IndexController extends BaseController{
    public function index(){
        $this->display("Default/welcome.tpl");
    }
    //清除 该模块目录 下的 所有缓存/编译文件
    public function ClearCache(){
        //清除cache缓存
        $this->clearAllCache();
        //清除编译目录的文件
        $this->clearCompiledTemplate();
        $this->success("清除该模块下缓存/编译成功")->back();
    }

}