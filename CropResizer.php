<?php
/*!
* ================================================
* CropResizer - php class to crop and resize image
* ================================================
* Copyright 2013-2016 Soyo Solution Company. and other contributors
* http://www.soyosolution.com/
* http://tool.soyosolution.com/php_crop_resizer/
* Released under the MIT license
*
* Reference:
* http://php.net/manual/en/function.imagecopyresampled.php
*
* Release date     : 2016-07-08
* Last updated date: 2016-07-11
*/

class CropResizer{
    
    private $imgSrcPath;
    private $src_w; //Source width.
    private $src_h; //Source height.
    
    function __construct($imgSrcPath) {
        $this->imgSrcPath = $imgSrcPath;
        $size = self::getImgSize();
        $this->src_w = $size['w'];
        $this->src_h = $size['h'];
    }    
    
    /**
     * This is a function to resize and save image but keep ratio.
     *
     * @param  int   $dst_w            Width of your output.
     * @param String $resultDirPath   Directory path of your resized image.
     * @return void
     */
    public function resizeKeepRatioByWidth($dst_w, $resultDirPath){
        $changePersent = $dst_w / $this->src_w;
        $dst_h = $this->src_h * $changePersent;
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
        $changePersent = $dst_h / $this->src_h;
        $dst_w = $this->src_w * $changePersent;
        self::resizeImg($dst_w, $dst_h, $resultDirPath);
    }

    /**
     * This is a function to crop, resize and save image.
     *
     * @param  int    $dst_w          Thumb width
     * @param  int    $dst_h          Thumb height
     * @param  int    $dst_x          X-coordinate of the destination point to be cropped
     * @param  int    $dst_y          Y-coordinate of the destination point to be cropped
     * @param  Stting $resultDirPath  Result image output path.
     * @reture void
     */
    public function cropImg($dst_w, $dst_h, $src_x, $src_y, $resultDirPath){
        if($dst_w > $this->src_w || $dst_h > $this->src_h) {//strange case
            return "Warming: your requested crop-area bigger then source image or some area is over the source. Image haven't been cropped.";
        }else{
            self::cropResize($this->imgSrcPath, $resultDirPath, $src_x, $src_y, $dst_w, $dst_h, $dst_w, $dst_h);
        }
        
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
        self::cropResize($this->imgSrcPath, $resultDirPath, 0, 0, $dst_w, $dst_h, $this->src_w, $this->src_h);
    }

    /**
     * This is a function to crop, resize and save image, 
     *
     * @named as sth like 1455181621_725588_250x100.jpg
     * @param String $imgSrcPath    ImageSource
     * @param int    $src_x          x-coordinate of source point.
     * @param int    $src_y          y-coordinate of source point.   
     * @param int    $dst_w          Thumb width
     * @param int    $dst_h          Thumb height
     * @param int    $dst_x          X-coordinate of the destination point to be cropped
     * @param int    $dst_y          Y-coordinate of the destination point to be cropped
     * @param String $resultDirPath  Result image output path.
     */
     private function cropResize($imgSrcPath, $resultDirPath, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $save=true){
        $text = explode('.', $resultDirPath);
        $imgsrc_name_temp = explode('.', $resultDirPath);//e.g. [0]=>2645635356, [1]=>jpg
        $target_filename = $imgsrc_name_temp[0].'.'.$imgsrc_name_temp[1];
        
        //Resize and save for another size
        $fileType = strtolower ($imgsrc_name_temp[1]);
        try{
            $dst_temp_image = imagecreatetruecolor($dst_w, $dst_h);
            if($fileType == 'jpeg') $fileType = 'jpg';
              switch($fileType){
                switch($fileType){
-                case 'bmp': 
-                    $temp_image = imagecreatefromwbmp($this->imgSrcPath); 
-                    imagecopyresampled( $dst_temp_image, $temp_image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
-                    if($save)imagejpeg($dst_temp_image, $target_filename);
-                    break;                  
                case 'gif': 
                    $temp_image = imagecreatefromgif($imgSrcPath); 
                    imagecopyresampled( $dst_temp_image, $temp_image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
                    if($save)imagegif($dst_temp_image, $target_filename);
                    break;
                case 'jpg': 
                    $temp_image = imagecreatefromjpeg($imgSrcPath); 
                    imagecopyresampled( $dst_temp_image, $temp_image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
                    if($save)imagejpeg($dst_temp_image, $target_filename);
                    break;
                case 'png': 
                    $temp_image = imagecreatefrompng($imgSrcPath); 
                    imagecopyresampled( $dst_temp_image, $temp_image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
                    if($save)imagepng($dst_temp_image, $target_filename);
                    break;
                default : return "Unsupported picture type, we support jpg, jpeg, png, gif";
              }
        }catch(Exception $e){
            print_r($e);
        }
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

}
?>
