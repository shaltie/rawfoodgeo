<?php 
function  mycity_imageReplaceColor(&$src, array $mycity_rgb)
{
    imagealphablending($src, false);
    imagesavealpha($src, true);
   
    $srcW = imagesx($src);
    $srcH = imagesy($src);
 
    for($x = 0; $x < $srcW; $x++)
    {
        for($y = 0; $y < $srcH; $y++)
        {
            $srcColor = imagecolorsforindex($src, imagecolorat($src, $x, $y));
 
            $srcColor = imagecolorallocatealpha(
                $src, $mycity_rgb[0], $mycity_rgb[1], $mycity_rgb[2], $srcColor['alpha']
            );
 
            imagesetpixel($src, $x, $y, $srcColor);
        }
    }
}

function  mycity_imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){  
    // creating a cut resource  
    $cut = imagecreatetruecolor($src_w, $src_h);  
    imagecolortransparent ($cut, imagecolorallocate($cut, 255, 0, 0)); 
    imagefill($cut, 0, 0, imagecolorallocate($cut, 255, 0, 0)); 
    // copying relevant section from background to the cut resource  
    #imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);  
     
    // copying relevant section from watermark to the cut resource  
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);  
     
    // insert cut resource to destination image  
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
} 

$image = imagecreatefrompng('marker_blank.png');
$icon = imagecreatefrompng('../font/16/futbol-o.png');

imagesavealpha($image, 1);  
imagealphablending($image, 1); 
imagesavealpha($icon, 1);  
imagealphablending($icon, 1); 

 mycity_imageReplaceColor($image, array(255, 0, 0));
 
 mycity_imagecopymerge_alpha($image, $icon,6,6,0,0,16,16,99);

header('Content-type: image/png');
imagepng($image);
?>