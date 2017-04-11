<?php
$show = './manage_article.html';

include('./func/mysql.php');
//日常连接库
$database = 'ex28blog';
sql_connect($database);

//判断删除，改
if(!empty($_GET['delete'])){
	$table = 'article';
	$where = "id={$_GET['delete']}";
	$a = sql_delete($table,$where);
}
if(!empty($_GET['editor'])){
	header("location:./modify_article.php?id={$_GET['editor']}");
	exit();
}

//联表数据
$table = 'article';
$select = 'id,title,tid,create_time,hits';
$rs = sql_select($table,$select,'','','');
$show_table = '';

$table = 'article';
$select = 'article.id,title,type,create_time,hits';
$table2 = 'type';
$where = 'article.tid=type.id';
$rs = sql_left($table,$select,$table2,$where);
$show_table ='';
foreach( $rs as $k=>$arr ){
	$arr['create_time'] = date('Y-m-d H:i:s',$arr['create_time']);
	$show_table .= '<tr>';
	foreach( $arr as $v){
		$show_table .= '<td>';
			$show_table .= $v;
		$show_table .= '</td>';
	}
	$show_table .= '<td>';
	$show_table .= "<a href='?delete={$arr['id']}'>";
		$show_table .= '<img src="./img/cross.png">';
	$show_table .= '</a>';
	$show_table .= "<a href='?editor={$arr['id']}'>";
		$show_table .= '<img src="./img/pencil.png">';
	$show_table .= '</a>';
	$show_table .= '</td>';
	$show_table .= '</tr>';
}
/*{//拆表做法
	//拿主表数据出来
$table = 'article';
$select = 'id,title,tid,create_time,hits';
$rs = sql_select($table,$select,'','','');
$show_table = '';

$table = 'article';
$select = 'id,title,tid,create_time,hits';
$table2 = 'type';

$rs = sql_select($table,$select,'','','');
$show_table ='';
foreach( $rs as $k=>$arr ){
	$arr['create_time'] = date('Y-m-d H:i:s',$arr['create_time']);
	$arr['tid'] = $type_list[$arr['tid']];
	$show_table .= '<tr>';
	foreach( $arr as $v){
		$show_table .= '<td>';
			$show_table .= $v;
		$show_table .= '</td>';
	}
	$show_table .= '<td>';
	$show_table .= "<a href='?delete={$arr['id']}'>";
		$show_table .= '<img src="./img/cross.png">';
	$show_table .= '</a>';
	$show_table .= "<a href='?editor={$arr['id']}'>";
		$show_table .= '<img src="./img/pencil.png">';
	$show_table .= '</a>';
	$show_table .= '</td>';
	$show_table .= '</tr>';
}
}*/
include('./module.html');
?>