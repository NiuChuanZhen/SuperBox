<?php
//如果未定义，则定义该 全局变量 一个 值；
defined("APP_PATH") OR define("APP_PATH",dirname(__FILE__),true);
defined("Resource") OR define("Resource",dirname(__FILE__)."\\Resource\\",true);
?>