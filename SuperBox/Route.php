<?php
//路由设置
return array(
    //GET请求
    'GET'=>array(
        "default"=>"Home/IndexController@index",//默认网站首页
    ),
    //POST请求
    'POST'=>array(

    )
    //其他请求，可以 拓展 添加
    //......
);
?>