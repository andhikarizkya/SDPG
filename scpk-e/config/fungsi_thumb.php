<?php
//resize and crop image by center
function image_set($max_width, $max_height, $source_file, $folder_save, $folder_from, $tipe, $quality = 80){
  	$vdir_upload2 = $folder_from;
	$dst_dir = $folder_save;
	$imgsize = getimagesize($vdir_upload2 . $source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];
    
	switch($mime){
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;
 
        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;
 
        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 80;
            break;
 
        default:
            return false;
            break;
    }
	
	$src_img = $image_create($vdir_upload2 . $source_file);
	if($tipe=='crop') {
		$dst_img = imagecreatetruecolor($max_width, $max_height);
		 
		$width_new = $height * $max_width / $max_height;
		$height_new = $width * $max_height / $max_width;
		//if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
		
		if($width_new > $width){
			//cut point by height
			$h_point = (($height - $height_new) / 2);
			//copy image
			if($image=="imagepng") {
				imagealphablending($dst_img, false);
				imagesavealpha($dst_img, true);
				$transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
				imagefilledrectangle($dst_img, 0, 0, $width, $height_new, $transparent);
				imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
			} else {
				imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
			}
		}else{
			//cut point by width
			$w_point = (($width - $width_new) / 2);
			if($image=="imagepng") {
				imagealphablending($dst_img, false);
				imagesavealpha($dst_img, true);
				$transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
				imagefilledrectangle($dst_img, 0, 0, $width_new, $height, $transparent);
				imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
			} else {
				imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
			}
		}
		 
		$image($dst_img, $dst_dir . $source_file, $quality);
	} elseif($tipe=='thum') {
		$dst_width = $max_width;
		$dst_height = ($dst_width/$width)*$height;
		$dst_img = imagecreatetruecolor($dst_width,$dst_height);
		if($image=="imagepng") {
			imagealphablending($dst_img, false);
			imagesavealpha($dst_img, true);
			$transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
			imagefilledrectangle($dst_img, 0, 0, $width, $height, $transparent);
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);
		} else {
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);
		}
		$image($dst_img, $dst_dir . $source_file, $quality);
	}
 
    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);
}
?>