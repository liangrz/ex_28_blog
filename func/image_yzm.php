<?php
//create a image
function create_image($width,$height,$font_path){
	
	//imagecreatetruecolor(int width,int height);
	$img = imagecreatetruecolor($width,$height);
	
	//edit the image
	$blue = imagecolorallocate($img,0,0,255);
	$green = imagecolorallocate($img,0,255,0);
	$red = imagecolorallocate($img,255,0,0);
	$white = imagecolorallocate($img,255,255,255);
	$black = imagecolorallocate($img,0,0,0);
	
	$color = array($blue,$green,$red,$white,$black);
	
	imagefill($img , 0 ,0,$red);
	
	$value = ['a','b','c','d','1','2','3','4'];
	
	$max = 5;
	$str = '';
	$tmp = count($value)-1;
	for( $i=0; $i<$tmp;$i++){
		$j = rand(0,$tmp);
		$str .= $value[$j]; 	
	}
	
	imagettftext($img,60,10,0,130,$green,$font_path,$str);
	
	for($i = 0;$i<100;$i++){
		$x = rand(0,$width);
		$y = rand(0,$height);
		imagesetpixel($img,$x,$y,$blue);
	}
	
	for($i = 0;$i<10;$i++){
		$x1 = rand(0,$width);
		$y1 = rand(0,$height);
		$x2 = rand(0,$width);
		$y2 = rand(0,$height);
		imageline($img,$x1,$y1,$x2,$y2,$white);
	}
	
	//output the image
	header('Content-type:image/jpeg');
	imagejpeg($img);
	
	//destory the image	
	imagedestroy($img);
}
?>