<?php
//http://www.jb51.net 
class upLoad {

    public $length; //限定文件大小  
    public $fileName; //文件名 
    public $fileTemp; //上传临时文件 
    public $fileSize; //上传文件大小 
    public $error; //上传文件是否有错,php4没有 
    public $fileType; //上传文件类型 
    public $directory; // 
    public $maxLen;
    public $errormsg;

    function __construct($length,$directory,$thumb_path='',$font_path='') {
        $this->maxLen = $length;
        $this->length = $length * 1024 * 1024; //单位M
        $this->directory = $directory.'images/'.date('Ymd').'/';
    }

    public function upLoadFile($fileField,$thumb=false,$water=false) {
        $this->fileName = $fileField['name'];
        $this->fileTemp = $fileField['tmp_name'];
        $this->error = $fileField['error'];
        $this->fileType = $fileField['type'];
        $this->fileSize = $fileField['size'];
        
        if($this->_isBig($this->length,$this->fileSize))  return false;
            $path = $this->_isCreatedDir($this->directory); //取得路径 
            if ($path) {//http://www.jb51.net 
                $createFileType = $this->_getFileType($this->fileName); //设置文件类别 
                $createFileName = uniqid(rand()); //随机产生文件名 
                $thisDir = $this->directory  . $createFileName . "." . $createFileType;
                if($this->_isImg($createFileType) && ($thumb || $water)){
                    $_upload = new UPImages($this->directory);
                    return $_upload->upLoad($fileField,$thumb,$water);
                }else{
                    
                if (@move_uploaded_file($this->fileTemp, $thisDir))  //把临时文件移动到规定的路径下 
                    return $thisDir;
                else
                    return '';
                }
            }else{
                return '';
            }
    }

    public function _isBig($length, $fsize) { //返回文件是否超过规定大小 
        return $fsize > $length ? true : false;
    }

    public function _getFileType($fileName) { //获得文件的后缀 
        $ext_arr = explode(".", $fileName);
        return end($ext_arr); 
    }

    public function _isImg($fileType) { //上传图片类型是否允许 
        $type = array("jpeg", "gif", "jpg", "bmp",'png');
        $fileType = strtolower($fileType);
        $fileArray = explode("/", $fileType);
        $file_type = end($fileArray);
        return in_array($file_type, $type); //http://www.jb51.net 
    }

    public function _isCreatedDir($path) { //路径是否存在，不存在就创建 
        if (!file_exists($path)) {
            return @mkdir($path, 0755,true) ? true : false; //权限755// 
        } else {
            return true;
        }
    }

    public function showError() { //显示错误信息 //http://www.jb51.net 
        echo "<Script Language ='JavaScript'>\n history.back();\n alert(' $this->errormsg');\n </Script> \n";
        exit();
    }

}
class multiUpLoad extends upLoad {

    public $FILES;

    function __construct($arrayFiles, $length, $file = true, $directory) {
        $this->FILES = $arrayFiles;
        parent::__construct($length, $file, $directory);
    }

    function upLoadMultiFile() {
        $arr = array();
        if ($this->_judge() || $this->_judge() == "no") { //文件全部符合规格,就开始上传 
            foreach ($this->FILES as $key => $value) {
                $strDir = parent::upLoadFile($this->FILES[$key]);
                array_push($arr, $strDir);
            }
//http://www.jb51.net 
            return $arr;
        } else {
            return false;
        }
    }

    function _judge() {
        if ($this->file) {
            foreach ($this->FILES as $key => $value) {
                if ($this->_isBig($this->length, $value['size'])) {
                    $this->errormsg = "文件超过 $this->maxLen K";
                    parent::showError();
                }
                if ($value['error'] = UPLOAD_ERR_NO_FILE) {
//$this->errormsg="上传文件出现错误"; 
//parent::showError(); 
                    return "no";
                }
            }
            return true;
        } else {
//http://www.jb51.net 
            foreach ($this->FILES as $key => $value) {
                if ($this->_isBig($this->length, $value['size'])) {
                    $this->errormsg = "图片超过$this->maxLen";
                    parent::showError();
                }
                if ($value['error'] != 0) {
                    $this->errormsg = "上传图片出现错误";
                    parent::showError();
                }
                if (!$this->_isImg($value['type'])) {
                    $this->errormsg = "图片格式不对";
                    parent::showError();
                }
            }
            return true;
        }
    }

}
class UPImages {
    public $annexFolder = "../webroot/img/upload/images/"; //附件存放点，默认为：annex
    public $smallFolder = "../webroot/img/upload/thumb/"; //缩略图存放路径，注：必须是放在 $annexFolder下的子目录，默认为：smallimg 
    public $markFolder = "../webroot/img/upload/mark/"; //水印图片存放处 
    public  $upFileType = "jpg gif png jpeg bmp"; //上传的类型，默认为：jpg gif png rar zip 
    public  $upFileMax = 1024; //上传大小限制，单位是“KB”，默认为：1024KB 
    public $fontType = '../webroot/img/font/simhei.ttf'; //字体 
    public  $maxWidth = 500; //图片最大宽度 
    public  $maxHeight = 600; //图片最大高度 
    public $toFile = true; //是否返回生成图片路径 
    
    function UPImages($annexFolder='',$smallFolder='',$fontType=''){
        $this->annexFolder = $annexFolder ? $annexFolder : $this->annexFolder. date('Ymd');
        $this->smallFolder = $smallFolder ? $smallFolder : $this->smallFolder. date('Ymd');
        $this->markFolder = $this->markFolder. date('Ymd');
        $this->fontType = $fontType  ? $fontType : $this->fontType;
        $this->upFileMax = $this->upFileMax * 5;
        $this->_isCreatedDir($this->annexFolder);
        $this->_isCreatedDir($this->smallFolder);
        $this->_isCreatedDir($this->markFolder);
    }
       public function _isCreatedDir($path) { //路径是否存在，不存在就创建 
        if (!file_exists($path)) {
            return @mkdir($path, 0755,true) ? true : false; //权限755// 
        } else {
            return true;
        }
    }
/*
 * @param $_file    为$_FILES
 * @param $thumb    为是否生成缩略图，为数组，内包括宽高 ，例: array('width'=>120,'height'=>80)
 * @param $markImg  为是否给图片为水印文字  为数组，例   array('文字1','文字2')
 */
    function upLoad($_file,$thumb=false,$markImg=false) {
        $imageName = time(); //设定当前时间为图片名称 
        if (@empty($_file["name"]))
            die("没有上传图片信息，请确认");
        $name = explode(".", $_file["name"]); //将上传前的文件以“.”分开取得文件类型 
        $imgCount = count($name); //获得截取的数量 
        $imgType = $name[$imgCount - 1]; //取得文件的类型 
        if (strpos($this->upFileType, $imgType) === false)
            die("上传文件类型仅支持 " . $this->upFileType . " 不支持 " . $imgType);
        $photo = $imageName . "." . $imgType; //写入数据库的文件名 
        $uploadFile = $this->annexFolder . "/" . $photo; //上传后的文件名称 
        
        $upFileok = move_uploaded_file($_file["tmp_name"], $uploadFile);
        if ($upFileok) {
            $imgSize = $_file["size"];
            $kSize = round($imgSize / 1024);
            if ($kSize > ($this->upFileMax * 1024)) {
                @unlink($uploadFile);
                die("上传文件超过 " . $this->upFileMax . "KB");
            }
        } else {
            die("上传图片失败，请确认你的上传文件不超过 {$this->upFileMax} KB 或上传时间超时");
        }
        $_result = array();
        
        if($thumb){
            $width = $thumb['width'] ? $thumb['width'] : 128;
            $height = $thumb['height'] ? $thumb['height'] : 128;
            $_result['thumb'] = $this->smallImg($photo, $width, $height);
        }
        if($markImg){
            $_result['mark'] =  $this->MarkImg($photo, $markImg);
        }else{
            $_result['file'] = $uploadFile;
        }
        
        return $_result;
    }

    function getInfo($photo) {
        $photo = $this->annexFolder . "/" . $photo;
        $imageInfo = getimagesize($photo);
        $imgInfo["width"] = $imageInfo[0];
        $imgInfo["height"] = $imageInfo[1];
        $imgInfo["type"] = $imageInfo[2];
        $imgInfo["name"] = basename($photo);
        return $imgInfo;
    }

    function smallImg($photo, $width = 128, $height = 128) {
        $imgInfo = $this->getInfo($photo);
        $photo = $this->annexFolder . "/" . $photo; //获得图片源 
        $newName = substr($imgInfo["name"], 0, strrpos($imgInfo["name"], ".")) . "_thumb.jpg"; //新图片名称 
        if ($imgInfo["type"] == 1) {
            $img = imagecreatefromgif($photo);
        } elseif ($imgInfo["type"] == 2) {
            $img = imagecreatefromjpeg($photo);
        } elseif ($imgInfo["type"] == 3) {
            $img = imagecreatefrompng($photo);
        } else {
            $img = "";
        }
        if (empty($img))
            return False;
        $width = ($width > $imgInfo["width"]) ? $imgInfo["width"] : $width;
        $height = ($height > $imgInfo["height"]) ? $imgInfo["height"] : $height;
        $srcW = $imgInfo["width"];
        $srcH = $imgInfo["height"];
        if ($srcW * $width > $srcH * $height) {
            $height = round($srcH * $width / $srcW);
        } else {
            $width = round($srcW * $height / $srcH);
        }
        if (function_exists("imagecreatetruecolor")) {
            $newImg = imagecreatetruecolor($width, $height);
            ImageCopyResampled($newImg, $img, 0, 0, 0, 0, $width, $height, $imgInfo["width"], $imgInfo["height"]);
        } else {
            $newImg = imagecreate($width, $height);
            ImageCopyResized($newImg, $img, 0, 0, 0, 0, $width, $height, $imgInfo["width"], $imgInfo["height"]);
        }
        if ($this->toFile) {
            if (file_exists($this->smallFolder . "/" . $newName))
                @unlink($this->smallFolder . "/" . $newName);
            ImageJPEG($newImg,$this->smallFolder . "/" . $newName);
            return $this->smallFolder . "/" . $newName;
        } else {
            ImageJPEG($newImg);
        }
        ImageDestroy($newImg);
        ImageDestroy($img);
        return $newName;
    }

    function MarkImg($photo, $text) {
        $imgInfo = $this->getInfo($photo);
        $photo = $this->annexFolder . "/" . $photo;
        $newName = substr($imgInfo["name"], 0, strrpos($imgInfo["name"], ".")) . "_mark.jpg";
        switch ($imgInfo["type"]) {
            case 1:
                $img = imagecreatefromgif($photo);
                break;
            case 2:
                $img = imagecreatefromjpeg($photo);
                break;
            case 3:
                $img = imagecreatefrompng($photo);
                break;
            default:
                return False;
        }
        if (empty($img))
            return False;
        $width = ($this->maxWidth > $imgInfo["width"]) ? $imgInfo["width"] : $this->maxWidth;
        $height = ($this->maxHeight > $imgInfo["height"]) ? $imgInfo["height"] : $this->maxHeight;
        $srcW = $imgInfo["width"];
        $srcH = $imgInfo["height"];
        if ($srcW * $width > $srcH * $height) {
            $height = round($srcH * $width / $srcW);
        } else {
            $width = round($srcW * $height / $srcH);
        }
        if (function_exists("imagecreatetruecolor")) {
            $newImg = imagecreatetruecolor($width, $height);
            ImageCopyResampled($newImg, $img, 0, 0, 0, 0, $width, $height, $imgInfo["width"], $imgInfo["height"]);
        } else {
            $newImg = imagecreate($width, $height);
            ImageCopyResized($newImg, $img, 0, 0, 0, 0, $width, $height, $imgInfo["width"], $imgInfo["height"]);
        }
        $white = imageColorAllocate($newImg, 255, 255, 255);
        $black = imageColorAllocate($newImg, 0, 0, 0);
        $alpha = imageColorAllocateAlpha($newImg, 230, 230, 230, 40);
        ImageFilledRectangle($newImg, 0, $height - 26, $width, $height, $alpha);
        ImageFilledRectangle($newImg, 13, $height - 20, 15, $height - 7, $black);
        
        Imagettftext($newImg, 12, 0, 20, $height - 7, $black, $this->fontType, $text[0]);
        Imagettftext($newImg, 12, 0, 140, $height - 7, $black, $this->fontType, $text[1]);
        if ($this->toFile) {
            if (file_exists($this->markFolder . "/" . $newName))
                @unlink($this->markFolder . "/" . $newName);
            ImageJPEG($newImg, $this->markFolder . "/" . $newName);
            @unlink($this->annexFolder . "/" . $photo);
            return $this->markFolder . "/" . $newName;
        } else {
            ImageJPEG($newImg);
        }
        ImageDestroy($newImg);
        ImageDestroy($img);
        return $newName;
    }
}
?>