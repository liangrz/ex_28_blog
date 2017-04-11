<?php
function resize_image($image_path,$proportion){
	$big = imagecreatefromjpeg($image_path);
	
	$big_x = imagesx($big);
	$big_y = imagesy($big);
	
	$small_x = $big_x/$proportion;
	$small_y = $big_y/$proportion;
	//1、缩略图的画布
	$small = imagecreatetruecolor($small_x,$small_y);
	//2、将大图压缩进小图
	imagecopyresized($small,$big,0,0,0,0,$small_x,$small_y,$big_x,$big_y);
	//3、输出
	header('Content-type:image/jpeg');
	imagejpeg($small);
	//4、销毁
	imagedestroy($big);
	imagedestroy($small);
}

	
?>