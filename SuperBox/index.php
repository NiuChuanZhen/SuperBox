<?php
if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');
//引入 全局变量 配置
require_once "Global.php";
//引入 include 配置;
require_once "Include.php";
//引入 核心控制器
require_once "SuperBox\Controller\Controller.php";
SuperBox\Controller\Controller::run();//运行起来吧 !.... ---阿振)
?>