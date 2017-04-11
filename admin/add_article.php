<?php
$show ='./add_article.html';
include('./func/mysql.php');

//连接数据库
$database = 'ex28blog';
sql_connect($database);

//提取数据库中类型，赋给$option
$option = '';
$table = 'type';
$select = 'id,type';
$rs = sql_select($table,$select,'','','');
foreach($rs  as $k =>$v){
	$option .="<option value='{$v['id']}' >{$v['type']}</option>";
}

//有post就导入文章到数据库
if($_POST){
	$arr = array(
		'title' => $_POST['title'],
		'tid' => $_POST['tid'],
		'recommend' => $_POST['recommend'],
		'content' => $_POST['content'],
		'create_time' => time()
	);
	$table = 'article';
	$a = sql_insert($table,$arr);
}

include('./module.html');
?>