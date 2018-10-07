<?php
namespace SuperBox\Controller;
require_once APP_PATH."\Library\Smarty\Smarty.class.php";//引入 Smarty模板引擎;
use \SuperBox\Route\Route;
use \SuperBox\Registry\ApplicationRegistry;
class MySmarty extends \Smarty{
    private $Resolver;//获取 路由访问的 模块目录
    private $config;  //从注册表中 获取 Smarty 相关设置;
    //构造方法(自动配置 Smarty模板引擎目录)
    public function __construct(){
        //调用 Smarty之前，设置下 timezone;
        date_default_timezone_set("PRC");
        parent::__construct();//继承Smarty构造方法;
        $this->Resolver=Route::instance()->getResolver();
        $this->config=ApplicationRegistry::instance()->getSmarty();
        $this->SmartyDir(); //设置定位Smarty目录
        $this->SmartyInit();//加载Smarty配置

        $this->SetResource();//动态设置{$Resource}资源目录
    }
    private function SmartyDir(){
        //自动配置 Smarty引擎目录
        $this->setTemplateDir(APP_PATH."\\".$this->Resolver['AppDir']."\\template\\");
        $this->setCompileDir(APP_PATH."\\".$this->Resolver['AppDir']."\\compile\\");
        $this->setConfigDir(APP_PATH."\\".$this->Resolver['AppDir']."\\config\\");
        $this->setCacheDir(APP_PATH."\\".$this->Resolver['AppDir']."\\cache\\");
    }
    private function SmartyInit(){
        $this->caching = $this->config['Cache'];//开启或关闭 缓存
        $this->compile_check = $this->config['Compile_check'];//开启后，修改模板，及时更新缓存；
        $this->left_delimiter = $this->config['left_delimiter'];//左定界符
        $this->right_delimiter = $this->config['right_delimiter'];//右定界符
    }
    //设置{Resource}模板变量
    private function SetResource(){
        $Resource_root=\SuperBox\Request\Request::instance()->getResource_root();
        $this->assign("Resource",$Resource_root."/Resource");
    }

}
?>