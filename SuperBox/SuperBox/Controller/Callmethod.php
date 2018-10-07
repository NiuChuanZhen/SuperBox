<?php
namespace SuperBox\Controller;
//BaseController内,__Call()方法辞典;
class Callmethod{
    //发送邮件
    //参数分别是：(发送目的地址邮箱，标题，内容，附件);
    public function SendMail($args){
        require_once APP_PATH."\\Library\\Mail\\Mymailer.php";
        $mailer=new \Library\Mail\Mymailer();
        if($args[3]){
            $mailer->addFile($args[3]);
        }
        $bool=$mailer->send($args[0],$args[1],$args[2]);
        return $bool;
    }
//调用 对应控制器方法
//    public function Route($agrs)
//    {
//        $route = $agrs[0];
//        $arr = isset($agrs[1]) ? $agrs[1] : NULL;
//        $route_config = \SuperBox\Route\Route::instance()->getRoute();
//        //遍历，路由配置 缓存的数组
//        foreach ($route_config as $v) {
//            //若存在这个路由
//            if (array_key_exists($route, $v)) {
//                //处理字符串，导向相应 控制器方法
//                $controller_str = $v[$route];
//                if ($controller_str instanceof \Closure) {
//                    require_once APP_PATH . "\SuperBox\Route\ClosureMethod.php";
//                    $controller_str();
//                    exit;
//                }
//                $controller_arr = explode("/", $controller_str);
//                $app_dir = $controller_arr[0];
//                $classname = explode("@", $controller_arr[1])[0];
//                $method = explode("@", $controller_arr[1])[1];
//                $controller_path = APP_PATH . "\\" . $app_dir . "\\Controller\\" . $classname . ".php";
//                require_once $controller_path;
//                $namespace_class = "\\" . $app_dir . "\\Controller\\" . $classname;
//                $controller_object = new $namespace_class();
//                if ($arr) {
//                    $controller_object->$method($arr);
//                } else {
//                    $controller_object->$method();
//                }
//            }
//        }
//
//    }

//利用PHP Header()方法
    public function Route($agrs){
        $route = $agrs[0];
        $arr = isset($agrs[1]) ? $agrs[1] : NULL;
        $RouteRoot=\SuperBox\Request\Request::instance()->getRouteRoot();
        $RouteUrl=$route."/";
        if(is_array($arr)){
	        foreach($arr as $key=>$value){
	        $RouteUrl.=$key."/".$value."/";
	        }
        }
        $RouteUrl=substr($RouteUrl,0,-1);
        header("Location:".$RouteRoot.$RouteUrl);
        exit;
    }
}
?>