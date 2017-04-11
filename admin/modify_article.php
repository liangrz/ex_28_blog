<?php
$show = './modify_article.html';


include('.././func/mysql.php');
$database = 'ex28blog';
sql_connect($database);

if($_POST){//插入数据
	$arr = array(
		'title' => $_POST['title'],
		'tid' => $_POST['type'],
		'recommend' => $_POST['recommend'],
		'content' => $_POST['content'],
		'create_time' => time()
	);
	$table = 'article';
	$where = "id={$_GET['id']}";
	$a = sql_update($table,$arr,$where);
}

$table = 'article';//拿该id的文章数据
$select = 'title,tid,recommend,content';
$where = "id={$_GET['id']}";
$rs = sql_select($table,$select,$where,'','');
$v = $rs[0];

$option = '';
$table = 'type';//拿类别表
$select = 'id,type';
$rs = sql_select($table,$select,'','','');
foreach($rs  as $k =>$v_type){
	$selected = '';
	if($v_type['id'] == $v['tid']){
		$selected = 'selected = "selected" ';
	}
	$option .="<option value='{$v_type['id']}' {$selected}>{$v_type['type']}</option>";
}

if($v['recommend']){//提供参数
	$checked1 = 'checked = "checked"';
	$checked0 = '';
}else{
	$checked0 = 'checked = "checked"';
	$checked1 = '';
}

include('.././admin/module.html');
?>