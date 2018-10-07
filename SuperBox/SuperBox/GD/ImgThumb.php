<?php
namespace SuperBox\GD;
//生成缩略图类
class ImgThumb{
private $error=0;
private $ThumbPath;
private $ThumbName;
public function GetError(){
    return $this->error;
}
public function ThumbPath(){
    return $this->ThumbPath;
}
public function ThumbName(){
    return $this->ThumbName;
}
/**
*
* 制作缩略图
* @param $thumb_dir string 缩略图的 保存的文件夹 路径;
* @param $src_path string 原图路径
* @param $max_w int 画布的宽度
* @param $max_h int 画布的高度
* @param $flag bool 是否是等比缩略图  默认为 是 true,
* @param $prefix string 缩略图的前缀  默认为'thumb_'
*
*/
public function thumb($thumb_dir,$src_path,$max_w,$max_h,$flag = true,$prefix = 'thumb_'){
    $this->prefix=$prefix;

    //获取文件的后缀
    $ext=  strtolower(strrchr($src_path,'.'));

    //判断文件格式
    switch($ext){
        case '.jpg':
            $type='jpeg';
            break;
        case '.gif':
            $type='gif';
            break;
        case '.png':
            $type='png';
            break;
        default:
            $this->error='文件格式不正确';
            return false;
    }
    //拼接打开图片的函数
    $open_fn = 'imagecreatefrom'.$type;
    //打开源图
    $src = $open_fn($src_path);
    //源图的宽
    $src_w = imagesx($src);
    //源图的高
    $src_h = imagesy($src);
    //若高度参数 设置为"default",则 自动根据 参数宽度设置 和 源图的宽高比例  生成 对应的高度;
    if($max_h=="default"){
        $max_h=ceil($max_w*($src_h/$src_w));//向上取整;
    }
    //创建目标图（真彩画布）
    $dst = imagecreatetruecolor($max_w,$max_h);
    //是否等比缩放
    if ($flag) { //等比

        //求目标图片的宽高
        if ($max_w/$max_h < $src_w/$src_h) {

        //横屏图片以宽为标准
        $dst_w = $max_w;
        $dst_h = $max_w * $src_h/$src_w;
        }else{

        //竖屏图片以高为标准
        $dst_h = $max_h;
        $dst_w = $max_h * $src_w/$src_h;
        }
        //在目标图上显示的位置
        $dst_x=(int)(($max_w-$dst_w)/2);
        $dst_y=(int)(($max_h-$dst_h)/2);
    }
    else{   //不等比
        $dst_x=0;
        $dst_y=0;
        $dst_w=$max_w;
        $dst_h=$max_h;
    }

    //生成缩略图(将 图片资源，放入画布中)
    imagecopyresampled($dst,$src,$dst_x,$dst_y,0,0,$dst_w,$dst_h,$src_w,$src_h);

    //原图文件名（带后缀）
    $filename = basename($src_path);
    $this->ThumbName=$prefix.$filename;
    //缩略图存放路径（带 缩略图文件名）
    $thumb_path = $thumb_dir.$prefix.$filename;
    if(!is_dir($thumb_dir)){
        if(!mkdir($thumb_dir)){
            $this->error="创建 缩略图文件夹失败";
        }
    }
    //把缩略图上传到指定的文件夹
    imagepng($dst,$thumb_path);
    //销毁图片资源
    imagedestroy($dst);
    imagedestroy($src);

    //返回新的缩略图的文件名
    $this->ThumbPath=$thumb_path;
    if($this->error==0){
        return true;
    }
    else{
        return false;
    }
}

}

?>