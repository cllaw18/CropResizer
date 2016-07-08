<?php
/*!
* ================================================
* CropResizer - php class to crop and resize image
* ================================================
* https://github.com/soyosolution/validation-with-lightbox
* http://tool.soyosolution.com/validation-with-lightbox/
*
* Copyright 2013-2016 Soyo Solution Company. and other contributors
* Released under the MIT license
*
* Reference:
* http://php.net/manual/en/function.imagecopyresampled.php
*
* Last updated date: 2016-07-08
*/

class CropResizer{
    
    private $imgSrcPath;
    private $src_w; //Crop end X position in original image
    private $src_h; //Crop end Y position in original image
    private $ratio; //Ratio of original image
    
    function __construct($imgSrcPath) {
        $this->imgSrcPath = $imgSrcPath;
        $size = self::getImgSize();
        $this->src_w = $size['w'];
        $this->src_h = $size['h'];
        $this->ratio = self::getImgRatio();
    }    
    
    /**
     * This is a function to resize and save image but keep ratio.
     *
     * @param  int   $dst_w            Width of your output.
     * @param String $resultDirPath   Directory path of your resized image.
     * @return void
     */
    public function resizeKeepRatioByWidth($dst_w, $resultDirPath){
        $dst_h = $dst_w * $this->ratio;
        self::resizeImg($dst_w, $dst_h, $resultDirPath);
    }

    /**
     * This is a function to resize and save image but keep ratio.
     *
     * @param  int   $dst_h            Height of your output.
     * @param String $resultDirPath   Directory path of your resized image.
     * @return void
     */
    public function resizeKeepRatioByHeight($dst_h, $resultDirPath){
        $dst_w = $dst_h * (1 + $this->ratio);
        //echo 'Result is w:'.$dst_w.' x '.$dst_h.".<br /><br />";
        self::resizeImg($dst_w, $dst_h, $resultDirPath);
    }

    /**
     * This is a function to crop, resize and save image.
     *
     * @param  int    $dst_w          Thumb width
     * @param  int    $dst_h          Thumb height
     * @param  int    $dst_x          X-coordinate of destination point, value 0
     * @param  int    $dst_y          Y-coordinate of destination point, fix by front-end, value 0
     * @param  Stting $resultDirPath  Result image output path.
     * @reture void
     */
    public function cropImg($dst_w, $dst_h, $src_x, $src_y, $resultDirPath){
        self::cropResize($dst_w, $dst_h, $src_x, $src_y, $resultDirPath);
    }    
    
    //################################################################################################
    
    /**
     * This is a function to crop, resize and save image, 
     *
     * @param int    $dst_w          Thumb width
     * @param int    $dst_h          Thumb height
     * @param String $resultDirPath  Result image output path.    
     * @return void
     */
    private function resizeImg($dst_w, $dst_h, $resultDirPath){
        self::cropResize($dst_w, $dst_h, 0, 0, $resultDirPath);
    }

    /**
     * This is a function to crop, resize and save image, 
     *
     * @named as sth like 1455181621_725588_250x100.jpg
     * @param int    $dst_w          Thumb width
     * @param int    $dst_h          Thumb height
     * @param int    $dst_x          X-coordinate of destination point, value 0
     * @param int    $dst_y          Y-coordinate of destination point, fix by front-end, value 0
     * @param Stting $resultDirPath  Result image output path.
     */
    private function cropResize($dst_w, $dst_h, $src_x, $src_y, $resultDirPath){
        $text = explode('.', $resultDirPath);
        $imgsrc_name_temp = explode('.', $resultDirPath);//e.g. [0]=>2645635356, [1]=>jpg
        $target_filename = $imgsrc_name_temp[0].'.'.$imgsrc_name_temp[1];
        
        //Resize and save for another size
        try{
            $dst_temp_image = imagecreatetruecolor($dst_w, $dst_h);
            $temp_image = imagecreatefromjpeg($this->imgSrcPath);
            imagecopyresampled( $dst_temp_image, $temp_image, 0, 0, $src_x, $src_y, $src_x+$dst_w, $src_y+$dst_h, $this->src_w, $this->src_h);//gem content
            imagejpeg($dst_temp_image, $target_filename);
        }catch(Exception $e){
            print_r($e);
        }
    }
    
    /**
     * Get ratio of original image, the image source
     * @return int radio     Ratio of original image
     */    
    private function getImgRatio(){
        $ratio = 1;
        $size = self::getImgSize();
        $ratio = $size['h']/$size['w'];
        return $ratio;
    }
    
    /**
     * Get width and height of your image source
     * @return array  $size    An array storing width and height
     */        
    private function getImgSize(){
        $size = [];
        list($size['w'], $size['h']) = getimagesize($this->imgSrcPath); 
        $this->src_w = $size['w'];
        $this->src_h = $size['h'];
        return $size;
    }    
    
    private function getChangedTimes($dst_w, $src_w){
        $times = $dst_w /$src_w;
        return $times;
    }
}
?>
