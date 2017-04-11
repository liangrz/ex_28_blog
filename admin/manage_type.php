<?php
include('./func/mysql.php');
$show = './manage_type.html';
$show_table = '';

$database = 'ex28blog';
sql_connect($database);
$add = '';
$modify = '';
if(!empty($_GET['action'])){//action中添加，修改，删除，三选一
	switch($_GET['action']){
		case 'add'://添加
			$add = '<input type = "text" name="addtype">';
			$add .= '<input type = "submit" >';
			break;
		case 'modify'://修改
			$modify = $_GET['id'];
			break;
		case 'delete'://删除
			$table = 'type';
			$where = "id={$_GET['id']}";
			sql_delete($table,$where);
			break;
	}
}
if(!empty($_POST['addtype'])){
	$arr = array('type' => $_POST['addtype']);
	$table = 'type';
	sql_insert($table,$arr);
}
if(!empty($_POST['modifytype'])){
	$arr = array('type' => $_POST['modifytype']);
	$table = 'type';
	$where = "id={$_GET['modify']}";
	sql_update($table,$arr,$where);
}

$table = 'type';//拿类型表出来
$select = 'id,type';
$rs = sql_select($table,$select,'','','');
foreach( $rs as $v ){//列类型表
	$show_table .= '<tr>';
		$show_table .='<td>';
			$show_table .= $v['id'];
		$show_table .='</td>';
		$show_table .='<td>';
			$show_table .= $v['type'];
		$show_table .='</td>';
		$show_table .= '<td>';
			$show_table .= "<a href='?action=delete&id={$v['id']}'>";
				$show_table .= '<img src="./img/cross.png">';
			$show_table .= '</a>';
			$show_table .= "<a href='?action=modify&id={$v['id']}'>";
				$show_table .= '<img src="./img/pencil.png">';
			$show_table .= '</a>';
		$show_table .= '</td>';
		if($v['id']==$modify){
			$show_table .= '<td>';
				$show_table .= '修改类型<input type = "text" name="modifytype">';
				$show_table .= '<input type = "submit" >';
			$show_table .= '</td>';
		}
		$show_table .= '</tr>';
}

include('./module.html');
?>