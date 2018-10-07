<?php
namespace SuperBox\Route;
use \SuperBox\Request\Request;
use \SuperBox\Exception\RouteException;
class Route{
    private static $instance;
    private $route; //加载 路由配置
    private $Method;//从Request类中获取请求方法
    private $Url;   //从Request类中获取完整URL
    private $PathInfo;//index.php(执行脚本)之后，?参数之前 的URL字串；
    private $resolver=NULL;//路由解析结果
    private function __construct(){
        $this->route=require_once APP_PATH."\Route.php";
        $this->Method=Request::instance()->getMethod();
        $this->Url=Request::instance()->getUrl();
        $this->PathInfo=Request::instance()->getPathInfo();
        try{
            $this->resolver();//解析URL
        }
        catch(RouteException $e){
            echo $e->getMessage();
            exit;
        }
    }
    static function instance(){
        if(!isset(self::$instance)){
            self::$instance=new self();
        }
        return self::$instance;
    }
    //解析URL
    private function resolver(){
        if(isset($this->PathInfo)){
            $path=$this->PathInfo;
            $path=ltrim($path,"/");
            $path_arr=explode("/",$path);
            if(isset($path_arr[0])){
                $key=$path_arr[0];  //匹配 路由配置 数组的 键名；
                unset($path_arr[0]);//清除第一个元素，不会重建索引；
            }
            //若URL后面有参数
            if(isset($path_arr[1])){
                //取出值，重置索引。
                $parameters=array_values($path_arr);
                $parameters_new=array();
                //处理URL参数数组
                while(current($parameters)){
                    $key_1=current($parameters);
                    next($parameters);
                    if(current($parameters)){
                        //若键值中含有.html，则处理去掉（实现解析伪静态URL）；
                        $parameters_clear=current($parameters);
                        if(strpos($parameters_clear,".html")!==false){
                            $parameters_clear=substr($parameters_clear,0,-5);
                        }
                        $parameters_new[$key_1]=$parameters_clear;
                        next($parameters);
                    }
                    else{
                        throw new RouteException("Error:<br/>Your URL Parameters are wrong,Please check agin,and make sure it should be like \$a/int/\$b/int");
                    }
                }
            }
            else{
                $parameters_new=NULL;
            }
            //若匹配路由
            if(isset($this->route[$this->Method][$key])){
                //若路由配置指向 匿名方法 则调用之
                if($this->route[$this->Method][$key] instanceof \Closure){
                    //加载 匿名函数 方法辞典;
                    require_once APP_PATH."\SuperBox\Route\ClosureMethod.php";
                    //若URL 存在参数
                    if(isset($parameters_new)){
                        $this->route[$this->Method][$key]($parameters_new);
                        exit;
                    }
                    else{
                        $this->route[$this->Method][$key]();
                        exit;
                    }
                }
                //设置匹配信息 到$this->resolver属性；
                $arr=explode("@",$this->route[$this->Method][$key]);
                $this->resolver['AppDir']=explode("/",$arr[0])[0];
                $this->resolver['ClassName']=explode("/",$arr[0])[1];
                $this->resolver['method']=$arr[1];
                $this->resolver['parameters']=$parameters_new;
            }
            //若不匹配路由
            else{
                throw new RouteException("ERROR:<br/>The requested URL  was not match the route config,Please Check it agin");
            }
        }
        else{
            $this->default_Route();
        }
    }
    public function getResolver(){
        return $this->resolver;
    }
    public function  getRoute(){
        return $this->route;
    }
    //默认首页(Route.config中 寻找 以"default"为键名的 元素);
    public function default_Route(){
        if(isset($this->route[$this->Method]["default"])){
            if($this->route[$this->Method]["default"] instanceof \Closure){
                //加载 匿名函数 方法辞典;
                require_once APP_PATH."\SuperBox\Route\ClosureMethod.php";
                //若URL 存在参数
                    $this->route[$this->Method]["default"]();
                    exit;
            }
            //设置匹配信息 到$this->resolver属性；
            $arr=explode("@",$this->route[$this->Method]["default"]);
            $this->resolver['AppDir']=explode("/",$arr[0])[0];
            $this->resolver['ClassName']=explode("/",$arr[0])[1];
            $this->resolver['method']=$arr[1];
            $this->resolver['parameters']=NULL;
        }
        else{
            exit("ERROR:<br/>The Route config are not set the default key");
        }
    }
}
?>