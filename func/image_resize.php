<?php
function resize_image($image_path,$proportion){
	$big = imagecreatefromjpeg($image_path);
	
	$big_x = imagesx($big);
	$big_y = imagesy($big);
	
	$small_x = $big_x/$proportion;
	$small_y = $big_y/$proportion;
	//1������ͼ�Ļ���
	$small = imagecreatetruecolor($small_x,$small_y);
	//2������ͼѹ����Сͼ
	imagecopyresized($small,$big,0,0,0,0,$small_x,$small_y,$big_x,$big_y);
	//3�����
	header('Content-type:image/jpeg');
	imagejpeg($small);
	//4������
	imagedestroy($big);
	imagedestroy($small);
}

	
?>