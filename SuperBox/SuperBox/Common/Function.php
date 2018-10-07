<?php
//公共函数
/**
 * Created by PhpStorm.
 * User: 阿振
 * Date: 2018/10/5
 * Time: 20:36
 */
// 表单 input内容 安全过滤
function SafeInput($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}