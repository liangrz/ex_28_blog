<?php
include('./func/mysql.php');
include('./func/page_index_func.php');
include('./func/pick_show.php');
{//initial the sql database
	$database = 'ex28blog';
	sql_connect($database);
}
//what need to do
//protect get tid ,page_index(p)
//check the comment email
//the type shell be show on the menu of the index page?
//delete the article in the admin zone

if($_POST){//评论处理
	$email = $_POST['email'];
	$content = $_POST['content'];
	$table = 'comment';
	$arr = array(
		'create_time' =>time(),
		'aid' => $_GET['id'],
		'email' => $email,
		'content' => $content
	);
	sql_insert($table,$arr);
}
if(!empty($_GET['tid'])){//当前类别
	$tid = "tid={$_GET['tid']}";
}else{
	$tid ='';
}
$global_tid = $tid;//并且全局变量化
global $global_tid;
if(!empty($_GET['p'])&&$_GET['p']>0){//当前页码
	$now_page = $_GET['p'];
}else{
	$now_page = 1;
}
$now_row =3*($now_page-1);//本页第一条文章下标
{//从数据库提取menu部分
	$table = 'type';
	$select = 'type,id';
	$menu = pick_show_menu($table,$select,'','','');
}
if(!empty($_GET['id'])){//提取数据库提取张文章列表或者提取一篇文章
	$table = 'article';
	$select = 'id,create_time,hits,title,content';
	$where = "id={$_GET['id']}";
	$order = '';
	$limit = '';
	$article = pick_show_article($table,$select,$where,$order,$limit);
	$post = '';
}else{//从数据库提取文章部分
	$table = 'article';
	$select = 'id,create_time,hits,title,content';
	$where = $global_tid;
	$order = 'id';
	$limit = "{$now_row},3";
	$post = pick_show_post($table,$select,$where,$order,$limit);
	$article = '';
}
{//从数据库提取热门文章
	$table = 'article';
	$select = 'title,id';
	$where = '';
	$order = 'hits';
	$limit = '0,5';
	$hot = pick_show_hot($table,$select,$where,$order,$limit);
}
{//从数据库提取推荐文章
	$table = 'article';
	$select = 'title,id';
	$where = 'recommend=1';
	$order = 'hits';
	$limit = '0,5';
	$recom = pick_show_recom($table,$select,$where,$order,$limit);
}
{//下标处理
	$row = 3;//每页展示数量
	$table = 'article';
	$select = 'id';
	$count = 'count(id)';
	$where = $tid;
	$max_row_rs = sql_select($table,$count,$where,'','');
	$max_row = $max_row_rs[0][$count];
	$max_page = ceil($max_row/3);
	//if有5页，需要展现5页
	$page_index = show($now_page,$max_page);
}
include('./blog.html');
?>