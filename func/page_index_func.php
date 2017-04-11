<?php
function now_check($max_page){//检查当前页面是否为负或者大于最大页面
	if(empty($_GET['p']) ||
		$_GET['p']<=0){
		return 1;
	}else if($_GET['p']>$max_page){
		return $max_page;
	}else{
		return $_GET['p'];
	}
}
function show_all($max_page,$tid){//全部展示
	$str = '';
	for($i=1;$i<$max_page+1;$i++){
		$str .="<a href = '?{$tid}p={$i}' ><li class = 'fl'>{$i}</li></a>";
	}
	return $str;
}
function show_five($now,$max_page,$tid){//五页
	$str = '';
	global $global_tid;
	for($i=$now-2;$i<$now+3;$i++){
		if($now+2>$max_page){//判断是否在最后1、 2页
			$now--;
			$i=$now-2-1;
		}else if($i < 1 ){//判断是否在第1、第2页
			$now++;
		//}else if($i+4 > $max_page){
		}else{
			$str .="<a href = '?{$global_tid}p={$i}' ><li class = 'fl'>{$i}</li></a>";
		}
	}
	return $str;
}
function show_pre_page($flag,$pre){
	if($flag != 1){
		$str = "<a href = '?p={$pre}'>pre</a>";
	}
	return $str;
}
function show_next_page($flag,$next){
	if($flag != 2){
		$str = "<a href = '?p={$next}'>next</a>";
	}
	return $str;
}
function show($now,$max_page){//总合所有show
	global $global_tid;
	$tid = '';
	if($global_tid){
		$tid .="{$global_tid}&";
	}
	$str = '';
	if( $now > 1){//判断是不是首页
		$str = "<a href='?{$tid}p=1'><li class = 'shouye fl'>首页</li></a>";
	}
	if( $max_page<=5 ){
		$str .= show_all($max_page,$tid);
	}else{
		$str .= show_five($now,$max_page,$tid);
	}
	if( $now < $max_page){//判断是不是尾页
		$str .= " <a href=?{$tid}p={$max_page}><li class = 'shouye fl'>尾页</li></a> ";
	
	}
	return $str;
}
	//if有5页，需要展现5页
	//$page_index = show($now_page,$max_page);
?>