<?php

function resizeImage($filename, $newfilename, $newwidth) {
    if (!extension_loaded('gd')) { return false; }
   
    $image_type = strstr($filename,  '.');

    switch($image_type) {
            case '.jpg':
                $source = imagecreatefromjpeg($filename);
                break;
            case '.png':
                $source = imagecreatefrompng($filename);
                break;
            case '.gif':
                $source = imagecreatefromgif($filename);
                break;
            default:
                $GLOBALS['log']->error("oqc_ProductController::resizeImage() Not supported file extension!");
                return false;
            }

    list($width, $height) = getimagesize($filename);
    if ($width < 700) { return false; }
    $newheight = round ($height * ($newwidth/$width));
    $thumb = imagecreatetruecolor($newwidth,  $newheight);
    imagecopyresized($thumb,  $source,  0,  0,  0,  0,  $newwidth,  $newheight,  $width,  $height);
    imagejpeg($thumb, $newfilename, 100);

  return $newfilename;

}

?> 
