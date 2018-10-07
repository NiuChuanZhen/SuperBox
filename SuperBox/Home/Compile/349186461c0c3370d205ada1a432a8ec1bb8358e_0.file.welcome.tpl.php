<?php
/* Smarty version 3.1.32, created on 2018-10-07 20:06:02
  from 'D:\PhpStudy\PHPTutorial\WWW\SuperBox\Home\template\Default\welcome.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5bb9f6aa0a3996_47392175',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '349186461c0c3370d205ada1a432a8ec1bb8358e' => 
    array (
      0 => 'D:\\PhpStudy\\PHPTutorial\\WWW\\SuperBox\\Home\\template\\Default\\welcome.tpl',
      1 => 1533653425,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bb9f6aa0a3996_47392175 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
    <head>
        <title>SuperBox框架</title>

        
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
            }
            .title {
                font-size: 96px;
                width:100%;
                text-align:center;
                position:fixed;
                top:40%;
            }
            .foot{
                position: fixed;
                bottom:10%;
                text-align:center;
                width:100%;
                font-size:30px;
            }
            .foot a:link{
                color:black !important;
            }
            .foot a:visited{
                color:black !important;
            }
            .foot a:hover{
                color:red !important;
                font-size:31px;
            }
        </style>
    </head>
    <body>
        <div class="title">SuperBox</div>
        <div class="foot">
            <a href="http://www.lovephp.club/index.php/list/type/kuangjia.html" style="text-decoration:none;color:black" target="_blank" title="访问框架作者网站 查看使用文档">[框架使用文档]</a>
        </div>
    </body>
</html>
<?php }
}
