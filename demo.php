<?php
include "CropResizer.php";

try{
    $cropResizer = new CropResizer("samples/3105589762.jpg");
    $cropResizer->resizeKeepRatioByWidth(250, "samples/3105589762_keepratio_by_w.jpg");
    $cropResizer->resizeKeepRatioByHeight(250, "samples/3105589762_keepratio_by_h.jpg");
    $cropResizer->cropImg(250,123,100,100,"samples/3105589762_crop.jpg");

    $cropResizer2 = new CropResizer("samples\butterfly-wallpaper.jpeg");
    $cropResizer2->resizeKeepRatioByWidth(600, "samples\butterfly_w600_keepratio_by_w.jpg");
    $cropResizer2->resizeKeepRatioByHeight(150, "samples\butterfly_h150_keepratio_by_h.jpg");
    $cropResizer2->cropImg(256,160,500,500,"samples\butterfly_crop.jpg");
    //$dst_w, $dst_h, $src_x, $src_y, $resultDirPath
    $cropResizer2->cropImg(500,500,2500,1500,"samples\butterfly_crop_right.jpg");
    
    echo 'Crop and resize finsihed, please check photos in "samples" files.';
}catch (Exception $e){
    echo "Error:".$e;
}
?>
