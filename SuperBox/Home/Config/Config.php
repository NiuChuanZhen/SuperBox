<?php
return array(
    //数据库配置
    'DB'=>array(
        'DB_TYPE'=>'mysql',		    //数据库类型
        'DB_HOST'=>'localhost',	    //主机名称
        'DB_NAME'=>'DB_NAME',		    //数据库名称
        'DB_USER'=>'username',			//数据库 用户名
        'DB_PASS'=>'password',	        //数据库 密码
    ),
    //该模块下 Smarty引擎配置
    'Smarty'=>array(
        'Cache'=>false,         //开/关 缓存(调试时，建议关闭缓存)
        'Compile_check'=>true,   //检查编译(开启后，若修改模板，则及时更新缓存)
        'left_delimiter'=>'{{',    //自定义 左定界符
        'right_delimiter'=>'}}'    //自定义 右定界符
    ),
    //session是否默认开启
    'Session'=>true,//开启
    //设置默认 时区
    'Default_timezone_set'=>"PRC"
);
?>