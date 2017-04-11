<?php
include('./func/mysql.php');
/*
$database = 'ex28blog';
sql_connect($database);
$table = 'article';
$a = sql_drop_table($table);
var_dump($a);
$a = sql_create_table($table);
var_dump($a);
*/
$database = 'aaa';
$a = sql_connect($database);
{//测试插入数据到comment表
	$email = 'test';
	$content = '你好';
	$table = 'test';
	$arr = array(
		'create_time' =>time(),
		'aid' => 1,
		'email' => $email,
		'content' => $content
	);
	sql_connect($database);
	var_dump(sql_insert($table,$arr));
}

//initial the sql
/*$database = 'ex28blog';
{
	
	sql_connect($database);
	$table = 'article';
	$name = "recommend tinyint(1) not null comment '推荐'";
	$a = sql_alter_add($table,$name);
	var_dump($a);
}*/

/*{//测试插入数据到article表
$table = 'article';
$select = 'type';
$arr = array(
	'uid' => '2',
	'title' => 'test',
	'content' => 'test',
	'create_time' => time(),
	'hits' => 0,
	'tid' => 2,
);
sql_connect($database);
var_dump(sql_insert($table,$arr));
}*/
/*{//测试插入数据到type表 ,
	$arr2 = array(
	'id' => 2,
	'type' => 'Javascript'
);
sql_connect($database);
var_dump($insert($table,$arr));
}*/

//$a = mysql_query($sql);
//$a = sql_insert($table,$arr2);
//$a = sql_select('article','create_time,hits,title,content','create_time','0,3');
//var_dump($a);
//$a = sql_insert($table,$arr);

//

?>