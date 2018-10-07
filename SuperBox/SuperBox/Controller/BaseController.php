<?php
namespace SuperBox\Controller;
use \SuperBox\Exception\AppException;
use \SuperBox\Registry\ApplicationRegistry;
//模块 控制器基类
class BaseController{
    protected $MySmarty;
    public function __construct(){
        //保存Smarty实例 到属性;
        $this->MySmarty=new \SuperBox\Controller\MySmarty();
        //设置 自定义插件包("Library\Smarty\Myplugins");
        $this->MySmarty->addPluginsDir(APP_PATH."\Library\Smarty\Myplugins");
        $this->SetSession();//设置 session开启状态;
        $this->SetTimezone();//设置 默认时区
    }
    protected function SetSession(){
        $session_status=ApplicationRegistry::instance()->getSession();
        if($session_status){
            session_start();
        }
        else{
            return;
        }
    }
    protected function SetTimezone(){
    	$timezone=ApplicationRegistry::instance()->getTimezone();
    	date_default_timezone_set($timezone);
    }
    //清除 全部缓存
    protected function clearAllCache(){
        $this->MySmarty->clearAllCache();
    }
    //清除 编译目录所有文件
    public function clearCompiledTemplate(){
        $this->MySmarty->clearCompiledTemplate();
    }
    //赋值
    protected function assign($name,$value){
        $this->MySmarty->assign($name,$value);
    }
    //错误弹窗
    protected function error($info){
        $_SESSION["status"]="error";
        $_SESSION['body']=$info;
        return $this;
    }
    //成功弹窗
    protected function success($info){
        $_SESSION["status"]="success";
        $_SESSION['body']=$info;
        return $this;
    }
    //赋值$_SESSION[$key]=$value
    protected function with($key,$value){
        $_SESSION[$key]=$value;
        return $this;
    }
    //返回上一页(不刷新，浏览器缓存的上页)
    protected function back(){
        echo "<script type='text/javascript'>window.history.back()</script>";
        exit;
    }
    //返回上一页(刷新)
    protected function BackRefresh(){
        echo "<script type='text/javascript'>window.location.href = document.referrer;</script>";
        exit;
    }
    //渲染模板(不带变量)：
    protected function display($tpl){
        $this->MySmarty->display($tpl);
        exit;
    }
    //渲染模板(携带变量)：简单封装$this->view()方法
    protected function View($tpl,$arr=NULL){
        if(is_array($arr)){
            foreach($arr as $k=>$v){
                $this->assign($k,$v);
            }
        }
        $this->display($tpl);
        exit;
    }
    //惰性加载 魔术方法
    function __call($MethodName, $args)
    {
        //若调用未知方法，则 加载  自定义方法辞典
        require_once APP_PATH."\SuperBox\Controller\Callmethod.php";
        $callmethod=new \SuperBox\Controller\Callmethod();
        try{
            if(method_exists($callmethod,$MethodName)){
                $callmethod->$MethodName($args);
            }
            else{
                throw new AppException("Error:<br/> Call to Undefined method:".$MethodName." in ".__CLASS__);
            }
        }
        catch (AppException $e){
            echo $e->getMessage();
            exit;
        }

    }
}
?>