<?php
require_once APP_PATH."\SuperBox\Controller\Callmethod.php";//共享 一些 Controller的__Call()方法；
//根目录，路由设置(Route.php)中的 匿名函数 辞典
function Route($route,$arr){
    $Callmethod=new \SuperBox\Controller\Callmethod();
    $agrs=array($route,$arr);
    $Callmethod->Route($agrs);
}
?>