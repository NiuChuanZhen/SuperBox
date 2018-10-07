<?php
namespace SuperBox\Request;
class Request{
	private $properties; //url参数数组
	private static $instance;   //  Request对象
    private $Method;    //请求类型
    private $HttpHost;  //域名
	private $RequstUrl; //URL后缀(除去域名)
    private $QueryString;//?之后的参数字符串
    private $Url;        //完整URL
    private $PathInfo;  //动态执行脚本之后，?参数之前
    private $RouteRoot;//Route()备用 起始URL字符串;
    private $Resource_root;
	private function __construct(){
	    $this->Method=$_SERVER['REQUEST_METHOD'];
        $this->HttpHost=$_SERVER['HTTP_HOST'];//获取当前域名
        $this->RequstUrl=$_SERVER['REQUEST_URI'];//获取当前域名的后缀
		$this->QueryString=$_SERVER['QUERY_STRING'];
        $this->Url="http://".$this->getHttpHost().$this->getRequestUrl();
        //若Url动态脚本之后 有参数
        if(isset($_SERVER['PATH_INFO'])){
            $this->PathInfo=$_SERVER['PATH_INFO'];
            $this->RouteRoot=substr($this->RequstUrl,0,-(strlen($this->PathInfo)-1));
            $this->Resource_root=substr($this->RouteRoot,0,-11);
        }
        //若Url动态脚本之后，无参数(如 访问首页时:域名/ 或 域名/index.php)
        //在实例化后面的Route类时，则导向default所指的控制器/方法;
        //但是，为了同样能够获得 项目的根目录:Resource_root（模板引擎$Resource用到）和RouteRoot($this->Route()跳转方法用到);
        //则需要特殊处理下 Request注册类中的下面两个属性;
        else{
            $this->PathInfo=NULL;
            //若RequstUrl中含有index.php
            if(strpos($this->RequstUrl,"index.php")!==false){
                $this->RouteRoot=$this->RequstUrl."/";
                $this->Resource_root=substr($this->RouteRoot,0,-11);
            }
            //若不含有index.php
            else{
                $this->RouteRoot=$this->RequstUrl."index.php/";
                $this->Resource_root=substr($this->RouteRoot,0,-11);
            }
        }
        $this->init();
	}
	function init(){
		if(isset($_SERVER['REQUEST_METHOD'])){
			$this->properties=$_REQUEST;
			return;
		}
		foreach($_SERVER['argv'] as $arg){
			if(strpos($arg,'=')){
				list($key,$val)=explode("=",$arg);
				$this->setProperty($key,$val);
			}
		}
	}
	static function instance(){
		if(!isset(self::$instance)){
			self::$instance=new self();
		}
		return self::$instance;
	}
	function getProperty($key){
		if(isset($this->properties[$key])){
			return $this->properties[$key];
		}
		return NULL;
	}
	function setProperty($key,$val){
		$this->properties[$key]=$val;
	}
	function getMethod(){
	    if(isset($this->Method)){
	        return $this->Method;
        }
        return NULL;
    }
	function getHttpHost(){
	    if(isset($this->HttpHost)){
            return $this->HttpHost;
        }
        return NULL;
    }
    function getRequestUrl(){
	    if(isset($this->RequstUrl)){
            return $this->RequstUrl;
        }
        return NULL;
    }
    function getUrl(){
	    if(isset($this->Url)){
	        return $this->Url;
        }
        return NULL;
    }
    function getQueryString(){
	    if(isset($this->QueryString)){
	        return $this->QueryString;
        }
        return NULL;
    }
    function getPathInfo(){
	    if(isset($this->PathInfo)){
	        return $this->PathInfo;
        }
        return NULL;
    }
    function getRouteRoot(){
	    if(isset($this->RouteRoot)){
	        return $this->RouteRoot;
        }
        return NULL;
    }
    function getResource_root(){
	    if(isset($this->Resource_root)){
	        return $this->Resource_root;
        }
        return NULL;
    }
}
?>