# CropResizer
CropResizer is a php class to resize and crop image.

##How to use
###Step 1 : Load CropResizer class file 
Including the CropResizer class file `CropResizer.php` before you use it:

```
include "CropResizer.php";
```


###Step 2 : Create a CropResizer Object
Then create a CropResizer Object with source image path as argument, for example, source image `3105589762.jpg` to be handled is located at `samples` folder in this sample project so the argument is `samples/3105589762.jpg`.

```
$cropResizer = new CropResizer("samples/3105589762.jpg");
```
*Beware the path is sys path but not img url

###Step 3 : Call resize or crop functions
There are 3 functions to do resize and cropping, they are `resizeKeepRatioByWidth()`, `resizeKeepRatioByHeight()` and `cropImg()`.

**Methods to resize image**
```
$cropResizer->resizeKeepRatioByWidth(250, "samples/3105589762_keepratio_by_w.jpg");
$cropResizer->resizeKeepRatioByHeight(250, "samples/3105589762_keepratio_by_h.jpg");
```

_resizeKeepRatioByWidth($dst_w, $resultDirPath)_

>`$dst_w` is target width of your resized output image.<br />
>`$resultDirPath` is directory path of your resized image.

_resizeKeepRatioByHeight($dst_h, $resultDirPath)_

>`$dst_h` is target height of your resized output image.<br />
>`$resultDirPath` is directory path of your resized image.

**Methods to crop image**
```
$cropResizer->cropImg(250,123,100,100,"samples/3105589762_crop.jpg");
```

_cropImg($dst_w, $dst_h, $src_x, $src_y, $resultDirPath)_

>`$dst_w` is target width of your cropped output image<br />
>`$dst_h` is target height of your cropped output image<br />
>`$dst_x` is X-coordinate of the starting point to be cropped (X-coordinate of top-left corner) in your original image.<br />
>`$dst_y` is Y-coordinate of the starting point to be cropped (Y-coordinate of top-left corner) in your original image.<br />
>`$resultDirPath` is the output path of your cropped image.<br />

##Samples
There are a `demo.php` and a folder named `samples` as the example and 2 sample images named `3105589762.jpg` and `butterfly-wallpaper.jpeg` was added inside. Resized or cropped images should be added in this directory after you run the demo.php :

- 3105589762_crop.jpg
- 3105589762_keepratio_by_h.jpg
- 3105589762_keepratio_by_w.jpg
- butterfly_crop.jpg
- butterfly_h150_keepratio_by_h.jpg
- butterfly_w600_keepratio_by_w.jpg
 
