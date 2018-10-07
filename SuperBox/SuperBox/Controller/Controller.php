<?php
namespace SuperBox\Controller;
use \SuperBox\Registry\ApplicationRegistry;
use \SuperBox\Request\Request;
use \SuperBox\Route\Route;
//核心控制器
class Controller{
	private function __construct(){	}
	//入口方法
	static function run(){
		//构造方法是私有的，但仍可在类内 new Controller()的;
		$instance=new Controller();
        $instance->handleRequest(); //获取请求
            //var_dump(\SuperBox\Request\Request::instance());
		$instance->handleRoute();   //路由解析
            //var_dump(\SuperBox\Route\Route::instance());
        $instance->HandleRegistry();//注册 相应模块配置
            //var_dump(\SuperBox\Registry\ApplicationRegistry::instance());
        $instance->HandleController();//导向 对应控制器
		//测试 单例类数据



		//测试数据库
//		$DB=\SuperBox\DataBase\DB::table("blog");
//        $res=$DB->fields("id,autor,price")->where(array('id'=>1,'>'))->order("id asc")->count();
//        var_dump($res);
	}
	//检查/加载 配置文件
	function handleRegistry(){
		ApplicationRegistry::instance()->ConfigRegistry();
	}
	function handleRequest(){
		Request::instance();
	}
	function handleRoute(){
        Route::instance();
    }
    function HandleController(){
        new \SuperBox\Controller\HandleController();
    }
}
?>