<?php
require_once APP_PATH."\SuperBox\Registry\Registry.php";//引入 注册表类
require_once APP_PATH."\SuperBox\Request\Request.php";	//引入请求类
require_once APP_PATH."\SuperBox\Route\Route.php";//引入路由类
require_once APP_PATH."\SuperBox\Controller\HandleController.php";//引入操作控制器类
require_once APP_PATH."\SuperBox\Controller\BaseController.php";//引入 BaseController类
require_once APP_PATH."\SuperBox\DataBase\DB.php";//数据库操作
require_once APP_PATH."\SuperBox\Exception\RouteException.php";//引入RouteExcetion类
require_once APP_PATH."\SuperBox\Exception\AppException.php";//引入AppException类
require_once APP_PATH."\SuperBox\Controller\MySmarty.php";//引入MySmarty类
require_once APP_PATH."\SuperBox\Upload\Upload.php";//引入上传类
require_once APP_PATH."\SuperBox\Common\Function.php";//引入 公共函数方法
