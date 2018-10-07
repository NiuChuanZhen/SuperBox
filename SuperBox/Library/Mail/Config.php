<?php 
// 邮件功能的 配置文件
return array(
				"USERNAME"=>"448554902@qq.com", // 授权登陆的 邮箱账号

				"PASSWORD"=>"anrxcnqzvalbcaga", // 授权登陆的 邮箱密码

				"NICKNAME"=>"Happy牛爷",			//发件人 昵称

				"HOST"=>"smtp.qq.com",			//邮箱的服务器地址

				"PORT"=>465,					//SMTP服务器的 端口号

				"SMTP"=>"ssl",					//加密方式

				"CHARSET"=>"UTF-8",			    //邮件的编码格式

				"SMTPAuth"=>true, 				//默认开启 SMTP 验证
				
				"DEBUG"=>false 					//是否开启 调试 模式
		);
 ?>