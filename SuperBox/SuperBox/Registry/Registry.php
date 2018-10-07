<?php
namespace SuperBox\Registry;
use \SuperBox\Route\Route;
use \SuperBox\Exception\AppException;
//注册表基类
class Registry{
	private static $instance;
	private $values=array();
	private function __construct(){	}
	static function instance(){
		if(!isset(self::$instance)){
			self::$instance=new self();
		}
		return self::$instance;
	}
 	protected function set($key,$value){
		$this->values[$key]=$value;
	}
	protected function get($key){
		if(isset($this->values[$key])){
			return $this->values[$key];
		}
		return null;
	}
}
//会话级别 注册表类
class SessionRegistry extends Registry{
	private static $instance;
	//自动加载 开启session会话
	private function __construct(){	
		session_start();
	}
	static function instance(){
		if(!isset(self::$instance)){
			self::$instance=new self();
		}
		return self::$instance;
	}
	//设置键/值，放入$_SESSION[__CLASS__]数组内
	protected function set($key,$value){
		$_SESSION[__CLASS__][$key]=$value;
	}
	//若$_SESSION[__CLASS__][$key]已被设值，则取出，否则返回null
	protected function get($key){
		if(isset($_SESSION[__CLASS__][$key])){
			return $_SESSION[__CLASS__][$key];
		}
		return null;
	}

}
//应用程序级别 注册表类
class ApplicationRegistry extends Registry{
    private $config;
	private static $instance;
	private $values=array();
	private function __construct(){
	    //根据路由 解析结果，加载对应的 模块Config.php
	    $resolver=Route::instance()->getResolver();
	    $this->config=APP_PATH."\\".$resolver['AppDir']."\\Config\\Config.php";
    }
	static function instance(){
		if(!isset(self::$instance)){
			self::$instance=new self();
		}
		return self::$instance;
	}
    public function ConfigRegistry(){
	    try{
            $this->ensure(file_exists($this->config),"Can not find Config file in SuperBox\Registry\Registry.php");
            $config=require_once $this->config;
            //注册 DB 配置
            $host=$config['DB']['DB_HOST'];
            $type=$config['DB']['DB_TYPE'];
            $dbname=$config['DB']['DB_NAME'];
            $user=$config['DB']['DB_USER'];
            $pass=$config['DB']['DB_PASS'];
            $dsn="{$type}:host={$host};dbname={$dbname}";
            $this->ensure($dsn,"No DSN found");
            $this->setDSN($dsn);
            $this->setUSER($user);
            $this->setPASS($pass);
            //注册 Smarty配置
            $smarty=$config['Smarty'];
            $this->setSmarty($smarty);
            //注册 session开启状态
            $session_status=$config['Session'];
            $this->setSession($session_status);
            //注册 default_timezone_set 默认时区
            $timezone=$config['Default_timezone_set'];
            $this->setTimezone($timezone);
        }
        catch (AppException $appException){
	        echo $appException->getMessage();
	        exit;
        }
    }
    public function ensure($expr,$message){
        if(!$expr){
            throw new AppException($message);
        }
    }
	//向该类数组属性中，存放键/值：$values[$key]=$value;
	protected function set($key,$value){
		$this->values[$key]=$value;
	}
	//读取指定的$key的值
	protected function get($key){
		if(isset($this->values[$key])){
			return $this->values[$key];
		}
		else{
			return null;
		}
	}
	static function getDSN(){
		return self::instance()->get('dsn');
	}
	private function setDSN($dsn){
		self::instance()->set('dsn',$dsn);
	}
	static function getUSER(){
		return self::instance()->get('user');
	}
	private function setUSER($user){
		self::instance()->set('user',$user);
	}
	static function getPASS(){
		return self::instance()->get('pass');
	}
	private function setPASS($pass){
		self::instance()->set('pass',$pass);
	}
	static function getSmarty(){
	    return self:: instance()->get('Smarty');
    }
    private function setSmarty($smarty){
	    self::instance()->set('Smarty',$smarty);
    }
    static function getSession(){
	    return self::instance()->get("Session");
    }
    private function setSession($session_status){
	    self::instance()->set("Session",$session_status);
    }
    static function getTimezone(){
    	return self::instance()->get("Default_timezone_set");
    }
    private function setTimezone($timezone){
    	self::instance()->set("Default_timezone_set",$timezone);
    }
}


?>