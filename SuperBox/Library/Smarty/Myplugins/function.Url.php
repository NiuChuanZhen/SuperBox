<?php
// 模板引擎，跳转Url变量
require_once APP_PATH."\SuperBox\Request\Request.php";
function smarty_function_Url($params,$smarty){
    $RouteRoot=\SuperBox\Request\Request::instance()->getRouteRoot();//获取Route URL根路径
    $Route=$params['Route'];//路由名称
    $Data=isset($params['Data'])?$params['Data']:NULL;//参数数组
    $params_str="";//参数字串
    //若设置参数了，则转成伪静态URL
    if($Data){
        while(current($Data)){
            $params_str.="/".key($Data);
            $params_str.="/".current($Data);
            next($Data);
        }
        return $RouteRoot.$Route.$params_str.".html";
    }
    //若未设置参数，则 没必要转成伪静态URL
    else{
        return $RouteRoot.$Route;
    }
}
?>