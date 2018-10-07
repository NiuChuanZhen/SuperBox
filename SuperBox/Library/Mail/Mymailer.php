<?php
namespace Library\Mail;
// 引入PHPMailer的核心文件
require_once(APP_PATH."\\Library\\Mail\\PHPMailer.php");
require_once(APP_PATH."\\Library\\Mail\\SMTP.php");

class Mymailer
{
    /**
     * 
     * @param bool $debug [调试模式]
     */
    public function __construct()
    {
        $this->mailer = new PHPMailer();
    }

    /**
     * @return PHPMailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }
    //加载 邮箱配置Config
    private function loadConfig()
    {
    	//引入 配置文件
    	$config=require_once APP_PATH."\\Library\\Mail\\Config.php";

    	$this->mailer->SMTPDebug = $config['DEBUG'] ? 1 : 0;
        $this->mailer->isSMTP(); // 使用 SMTP 方式发送邮件
        //服务器 设置 
        $this->mailer->SMTPAuth = $config['SMTPAuth']; // 开启 SMTP 认证
        $this->mailer->Host = $config['HOST']; // SMTP 服务器地址
        $this->mailer->Port = $config['PORT']; // 远程服务器端口号
        $this->mailer->SMTPSecure = $config['SMTP']; // 登录认证方式
        //邮箱 设置
        $this->mailer->Username = $config['USERNAME']; // SMTP 登录账号
        $this->mailer->Password = $config['PASSWORD']; // SMTP 登录密码
        $this->mailer->From = $config['USERNAME']; // 发件人邮箱地址
        $this->mailer->FromName = $config['NICKNAME']; // 发件人昵称（任意内容）
        //邮箱内容 设置
        $this->mailer->isHTML(true); // 邮件正文是否为 HTML
        $this->mailer->CharSet = $config['CHARSET']; // 发送的邮件的编码
    }

    /**
     * Add attachment
     * @param $path [附件路径]
     */
    public function addFile($path)
    {
        $this->mailer->addAttachment($path);
    }


    /**
     * Send Email
     * @param $email [收件人]
     * @param $title [主题]
     * @param $content [正文]
     * @return bool [发送状态]
     */
    public function send($email, $title, $content)
    {
        $this->loadConfig();
        $this->mailer->addAddress($email); // 收件人邮箱
        $this->mailer->Subject = $title; // 邮件主题
        $this->mailer->Body = $content; // 邮件信息
        return (bool)$this->mailer->send(); // 发送邮件
    }
}