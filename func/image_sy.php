<?php
function sy_image($big_path,$logo_path){
	
	//��ȡͼ��
	$big = imagecreatefromjpeg($big_path);
	$logo = imagecreatefromjpeg($logo_path);
	//�༭ͼ��
	$logo_x = imagesx($logo);
	$logo_y = imagesy($logo);
	
	//ls_x = logo_start-x
	$ls_x = 0;
	$ls_y = 0;
	
	imagecopy($big,$logo,0,0,$x1,$y1,$logo_x,$logo_y);
	//���ͼ��
	header('Content-type:image/jpeg');
	imagejpeg($big);
	
	//����
	imagedestroy($big);
	imagedestroy($small);
}	
?>