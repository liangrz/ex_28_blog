<?php
//~~~~~~~~~~~~~~!ÿ���иò�����ʱ��һ��Ҫ���ݣ�~~~~~~~~~~
function abso_rela(){//absolute path change to relative path
	$dir = __DIR__;
	$tmp = explode('\\',$dir);
	$pop = array_pop($tmp);
	$dir = "./{$pop}";
	return $dir;
}
//$dir = abso_rela();
function filepath_list($filepath){//���filepathĿ¼�µ�ȫĿ¼���ļ�����ά
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
function foreach_arr($arr){//�Ѷ༶������һ������
	foreach($arr as $v){
		if(is_array($v)){//�����飬�ݹ��������Ԫ���Ƿ������飬ֱ��������
			$arr3 = foreach_arr($v);
			foreach($arr3 as $v3){//��ɢ�����飬�����ӵ����飬��ά
				$arr2[] = $v3;
			}
		}else{
			$arr2[] = $v;
		}
	}
	return $arr2;
}
function filename_list($full_dir_arr){//û���ϼ�Ŀ¼���ļ��б�
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
function matches_all_file($pattern,$filepath_list){//����ƥ����ļ�=>ƥ������
	$preg = 0;
	foreach($filepath_list as $k=>$v){
		if(is_dir($v)){
			//$matches_list[]=$v;
			continue;
		}
		$content = read_file($v);//��ȡ·���ļ�����Ȼ�����
		$preg += preg_match_all($pattern,$content,$matches,PREG_PATTERN_ORDER);
		//$matches[0][times],timesΪ�ڼ���
		if($matches[0]){//�γ�һ��·��=>������������
			$tmp[$v] = $matches[0];
			$matches_list[$v]=$tmp[$v];
		}
	}
	$matches_list['matches_times']=$preg;
	return $matches_list;
}
function get_deepth($path){//��õ�ǰ�ļ����
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
$matches_list = matches_all_file($pattern,$filepath_list);//Ӧ�ñܿ�ͼƬ����
$matches_time = array_pop( $matches_list );
//֪����ǰ�ļ���·�����$deepth�������ļ���Ŀ¼�µ�·����������$deepth��Ŀ¼��������,����
foreach( $matches_list as $filepath=>$include_list ){
	foreach( $include_list as $include ){
		$include_content = substr( $include , 9 ,-2);//�д�����
		$filename = get_filename($include_content);//����ļ���
		if(!in_array($filename,$filename_list)){
			continue;
		}
		$deepth = get_deepth($filepath);//���
		$key = find_key($filename,$filename_list);//ƥ���ļ���·��
		$relative_path = get_relative_path($deepth,$filepath_list[$key]);
		$content = replace( $include_content , $relative_path ,$filepath );
		write_file($filepath,$content);
	}
}

/*����

*/
//filepath_list������ڸ�Ŀ¼
//ֻ��Ҫ����$v����ڸ�Ŀ¼λ�þ�ok
//�������ļ����������ļ���λ���Ƿ���ȷ
?>