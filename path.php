<?php
//~~~~~~~~~~~~~~!每进行该操作的时候一定要备份！~~~~~~~~~~
function abso_rela(){//absolute path change to relative path
	$dir = __DIR__;
	$tmp = explode('\\',$dir);
	$pop = array_pop($tmp);
	$dir = "./{$pop}";
	return $dir;
}
//$dir = abso_rela();
function filepath_list($filepath){//获得filepath目录下的全目录和文件，多维
	$rs = opendir($filepath);
	readdir($rs);
	readdir($rs);
	while($tmp = readdir($rs)){
		if(is_dir($tmp)){
			$filepath = trim($filepath,'/');
			$new_filepath = "{$filepath}/{$tmp}";
			$arr[] = "{$filepath}/{$tmp}";
			$arr[] = filepath_list($new_filepath);
		}else{
			$arr[] = "{$filepath}/{$tmp}";	
		}
	}
	return $arr;
}
function foreach_arr($arr){//把多级数组变成一级数组
	foreach($arr as $v){
		if(is_array($v)){//是数组，递归检查该数组元素是否有数组，直至非数组
			$arr3 = foreach_arr($v);
			foreach($arr3 as $v3){//拆散该数组，逐个添加到数组，降维
				$arr2[] = $v3;
			}
		}else{
			$arr2[] = $v;
		}
	}
	return $arr2;
}
function filename_list($full_dir_arr){//没有上级目录的文件列表
	foreach($full_dir_arr as $v){
		$tmp_arr = explode('/',$v);
		$tmp = array_pop($tmp_arr);
		$nofull_dir_arr[] = $tmp;
	}
	return $nofull_dir_arr;
}
function read_file($path){
	$rs = fopen($path,'r');//
	$content = '';
	while(!feof($rs)){
		$content .= fread($rs,1);
	}
	fclose($rs);
	return $content;
}
function matches_all_file($pattern,$filepath_list){//返回匹配的文件=>匹配内容
	$preg = 0;
	foreach($filepath_list as $k=>$v){
		if(is_dir($v)){
			//$matches_list[]=$v;
			continue;
		}
		$content = read_file($v);//读取路径文件内容然后配对
		$preg += preg_match_all($pattern,$content,$matches,PREG_PATTERN_ORDER);
		//$matches[0][times],times为第几次
		if($matches[0]){//形成一个路径=>包含内容数组
			$tmp[$v] = $matches[0];
			$matches_list[$v]=$tmp[$v];
		}
	}
	$matches_list['matches_times']=$preg;
	return $matches_list;
}
function get_deepth($path){//获得当前文件深度
	$tmp_arr = explode('/',$path);
	$deepth = count($tmp_arr)-2;
	return $deepth;
}
function get_filename($filepath){
	$tmp_arr = explode('/',$filepath);
	$tmp = array_pop($tmp_arr);
	return $tmp;
}
function get_relative_path($deepth,$root_filepath){
	$relative_path = '';
		while( $deepth-- ){
			$relative_path .= '../';
		}
	$relative_path .= $root_filepath;
	return $relative_path;
}
function find_key($match,$arr){
	foreach($arr as $key=>$val){
		if($match!=$val){
			continue;
		}
		return $key;
	}
}
function replace( $before , $replacement , $filepath){
	$before = str_replace('.','\.',$before);
	$before = str_replace('/','\/',$before);
	$pattern = "/include\(\'{$before}\'\)/";
	$replacement = "include('{$replacement}')";
	$content = read_file($filepath);
	return preg_replace( $pattern , $replacement , $content);
}
function replace2($find,$replacement,$filepath){
	
}


function write_file($filepath,$content){
	$rs = fopen($filepath,'w');
	$a = fwrite( $rs , $content);
	fclose($rs);
	return $a;
}

$tmp_arr = filepath_list('./');
$filepath_list = foreach_arr($tmp_arr);
$filename_list = filename_list($filepath_list);

$pattern = '/include\((\'|\").*(\'|\")\)/';
$matches_list = matches_all_file($pattern,$filepath_list);//应该避开图片类型
$matches_time = array_pop( $matches_list );
//知道当前文件的路径深度$deepth，引用文件根目录下的路径，往上提$deepth个目录，再引用,完美
foreach( $matches_list as $filepath=>$include_list ){
	foreach( $include_list as $include ){
		$include_content = substr( $include , 9 ,-2);//有待解耦
		$filename = get_filename($include_content);//获得文件名
		if(!in_array($filename,$filename_list)){
			continue;
		}
		$deepth = get_deepth($filepath);//深度
		$key = find_key($filename,$filename_list);//匹配文件根路径
		$relative_path = get_relative_path($deepth,$filepath_list[$key]);
		$content = replace( $include_content , $relative_path ,$filepath );
		write_file($filepath,$content);
	}
}

/*备份

*/
//filepath_list是相对于根目录
//只需要分析$v相对于根目录位置就ok
//被引用文件对于引用文件的位置是否正确
?>