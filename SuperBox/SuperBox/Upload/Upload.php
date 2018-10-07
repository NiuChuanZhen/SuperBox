<?php
namespace SuperBox\Upload;
//文件上传处理类
class Upload{
    static private $instance;
    private $AllowedExts=array("gif", "jpeg", "jpg","pjpeg", "png","x-png");//文件 默认允许格式
    private $MaxSize=204800;//（默认文件大小 限制 200KB);
    private $FileName;//文件名(前端标签<input type='file'name="x" /> name 的值 x )
    private $UploadDir; //上传目录
    private $StorageName;// 保存的文件名
    private $SaveFilePath;//最后保存的文件位置（包含文件名）；
    private $UploadError=0;//默认值是0,没有错误
    //错误 解释辞典
    private $ErrorArr=array(
        0=>"文件上传成功",
        1=>"上传的文件超过了 php.ini 中 upload_max_filesize选项限制的值",
        2=>"上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值",
        3=>"文件只有部分被上传",
        4=>"没有文件被上传",
        6=>"找不到临时文件夹",
        7=>"文件写入失败",
        10=>"文件格式不允许 或 大小超过规定",
        11=>"文件已存在",
        12=>'创建 上传文件夹 失败',
        13=>'移动临时文件，写入到 文件夹内 失败'
    );
    private $File;//获取的$_FILES;
    private $Extension;//文件后缀名;
    private function __construct($filename){//构造方法，自动加载
        //转化 允许格式为 大写
        $AllowedExts=implode(",",$this->AllowedExts);
        $AllowedExts=strtoupper($AllowedExts);
        $this->AllowedExts=explode(",",$AllowedExts);
        $this->FileName=$filename;//前端 上传input file标签 name属性
        $this->File=$_FILES;//存储$_FILES数组
        $NameArr=explode(".",$_FILES[$this->FileName]["name"]);
        $this->Extension=strtoupper(end($NameArr));//文件后缀名
    }
    static function FileName($filename){ //获取 Upload 类实例
        if(!self::$instance){
            self::$instance=new self($filename);
        }
        return self::$instance;
    }
    //新增 允许文件类型  调用格式：FileType([type1,type2,type3]);
    public function FileType($type){
        foreach($type as $v){
            //新增的类型，若在$this->AllowedExts中不存在，则插入其末尾
            if(!in_array(strtoupper($v),$this->AllowedExts)){
                array_push($this->AllowedExts,strtoupper($v));
            }
        }
    }
    public function MaxSize($size){
        $this->MaxSize=$size;
    }
    //检查文件
    private function CheckUpload(){
        if (
                in_array(strtoupper(explode("/",$this->File[$this->FileName]["type"])[1]),$this->AllowedExts)
                && ($this->File[$this->FileName]["size"] < $this->MaxSize)
                && in_array($this->Extension, $this->AllowedExts)
            )
        {
            if ($this->File[$this->FileName]["error"] > 0)
            {
                $this->UploadError=$this->File[$this->FileName]["error"];
            }
        }
        else
        {
           $this->UploadError=10;
        }
    }
    //其他 安全检查;
    private function OtherSafeCheck(){

    }
    //保存文件
   public function Storage($UploadDir,$StorageName){
        $this->CheckUpload();//先 检查文件
        $this->OtherSafeCheck();//其他 安全检查
        $this->UploadDir=$UploadDir;
        $this->StorageName=$StorageName;
        // 如果无 目录则创建之
        if(!is_dir($this->UploadDir)){
            if(!mkdir($this->UploadDir)){
                $this->UploadError=12;
            };
        }
        if (file_exists($this->UploadDir.$this->StorageName.".".$this->Extension))
        {
            $this->UploadError=11;
        }
        else
        {
            if($this->UploadError==0){
                $move_result=move_uploaded_file($this->File[$this->FileName]["tmp_name"],$this->UploadDir.$this->StorageName.".".$this->Extension);
                if(!$move_result){
                    $this->UploadError=13;
                }
                else{
                    $this->SaveFilePath=$this->UploadDir.$this->StorageName.".".$this->Extension;
                    return true;
                }
            }
            else{
                return false;
            }
        }
    }
    //获取 最后保存的 文件位置（包含文件名）
    public function SaveFilePath(){
        return $this->SaveFilePath;
    }
    //从错误辞典中，得出具体错误
    public function GetError(){
        return $this->ErrorArr[$this->UploadError];
    }
    //获取文件的后缀名
    public function GetExtension(){
        return $this->Extension;
    }
}

