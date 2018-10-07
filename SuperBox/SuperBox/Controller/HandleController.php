<?php
namespace SuperBox\Controller;
use \SuperBox\Route\Route;
//根据路由解析结果 导向 指定控制器
class HandleController{
  public $resolver;
  public function __construct(){
        $this->resolver=Route::instance()->getResolver();
        $this->ToController();
    }
  public function ToController(){
      //若存在 路由匹配 信息
      if(isset($this->resolver)){
          $AppDir=$this->resolver['AppDir'];
          $ClassName=$this->resolver['ClassName'];
          $method=$this->resolver['method'];
          $parameters=$this->resolver['parameters'];
          //引入 该Controller文件
          $ControllerPath=APP_PATH."\\".$AppDir."\\Controller\\".$ClassName.".php";
          require_once $ControllerPath;
          //整合 命名空间\类名
          $NamespaceClass="\\".$AppDir."\\Controller\\".$ClassName;
          //实例化 控制器
          $Object=new $NamespaceClass();
          //若有参数，则传参
          if(isset($parameters)){
              $Object->$method($parameters);
          }
          else{
              $Object->$method();
          }
      }
  }
}
?>