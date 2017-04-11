<?php
function pick_show_menu($table,$select,$where,$order,$limit){
	$menu_rs = sql_select($table,$select,$where,$order,$limit);//参数1表名，参数2字段名
	$menu = '';
	foreach($menu_rs as $k => $v){
		$menu .= "<li class = 'fl'><a href = '?tid={$v['id']}'>{$v['type']}</a></li>";
	}
	return $menu;
}
function pick_show_post($table,$select,$where,$order,$limit){
	$post_rs = sql_select($table,$select,$where,$order,$limit);
	$post = '';
	foreach($post_rs as $v){
		$v['create_time'] =	date('Y-m-d H:i:s',$v['create_time']);
		$post .= "<div class = 'post' >";
			$post .= "<div class = 'title'>";
				$post .="<h2><a href = '?id={$v['id']}'>{$v['title']}</a></h2>";
			$post .= "</div>";
			$post .= "<div class = 'content'>";
				$post .= "<div class = 'create_time fl'>create time:{$v['create_time']}</div>";
				$post .= "<div class = 'date_click fl'>hits:{$v['hits']}</div>";
				$post .= "<div class = 'clearfix'></div>";
				$post .= "<div class = 'article'>{$v['content']}</div>";
			$post .= "</div>";
		$post .= "</div>";
	}
	return $post;
}
function pick_show_hot($table,$select,$where,$order,$limit){
	$hot_rs = sql_select($table,$select,$where,$order,$limit);
	$hot = '';
	foreach($hot_rs as $v){
		$hot .="<li>";
			$hot .="<a href ='?id={$v['id']}'>";	
				$hot .= $v['title'];
			$hot .="</a>";
		$hot .="</li>";
	}
	return $hot;
}
function pick_show_recom($table,$select,$where,$order,$limit){
	$recom_rs = sql_select($table,$select,$where,$order,$limit);
	$recom = '';
	foreach($recom_rs as $v){
		$recom .="<li>";
			$recom .="<a href ='?id={$v['id']}'>";	
				$recom .= $v['title'];
			$recom .="</a>";
		$recom .="</li>";
	}
	return $recom;
}
function pick_show_article($table,$select,$where,$order,$limit){
	$set = 'hits=hits+1';
	$a = sql_update($table,$set,$where);
	$post_rs = sql_select($table,$select,$where,$order,$limit);
	$post = '';
	foreach($post_rs as $v){
		$v['create_time'] =	date('Y-m-d H:i:s',$v['create_time']);
		$post .= "<div class = 'post' >";
			$post .= "<div class = 'title'>";
				$post .="<h2><a href = '?id={$v['id']}'>{$v['title']}</a></h2>";
			$post .= "</div>";
			$post .= "<div class = 'content_with_comment'>";
				$post .= "<div class = 'create_time fl'>create time:{$v['create_time']}</div>";
				$post .= "<div class = 'date_click fl'>hits:{$v['hits']}</div>";
				$post .= "<div class = 'clearfix'></div>";
				$post .= "<div class = 'article_with_comment'>{$v['content']}</div>";
				$post .= include('./comment_form.html');//评论表
				$post .= "<div class = 'comment_list'>";
					$post .=pick_show_comment();
				$post .= "</div>";
			$post .= "</div>";
		$post .= "</div>";
	}
	return $post;
}
function pick_show_comment(){
	$table = 'comment';
	$select = "create_time,content";
	$where = "aid={$_GET['id']}";
	$order = '';
	$limit = '';
	$comment = '';
	$rs = sql_select($table,$select,$where,$order,$limit);
	foreach($rs as $k=>$v){
		$v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
		$comment .= "<div class = 'comment'>";
			$comment .= "<div class = 'create_time'>{$v['create_time']}</div>";
			$comment .=	"{$v['content']}";
		$comment .= "</div>";
	}
	return $comment;
}
?>