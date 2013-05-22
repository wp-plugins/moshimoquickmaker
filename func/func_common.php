<?php

function DefineArray($defines_name){
	
	$defines = constant($defines_name);
	
	if(ereg("_ARRAY",$defines_name)){
		
		$defines_array = explode(",",$defines);
		$return_num = $defines_array;
		
	}elseif(ereg("_RARRAY",$defines_name)){
		
		$defines_array = explode(",",$defines);
		$defines_newarray = array();
		for($i=0; $i<count($defines_array); $i++){
			$push_array = explode("=>",$defines_array[$i]);
			$defines_newarray[$push_array[0]] = $push_array[1];
		}
		$return_num = $defines_newarray;
		
	}elseif(ereg("_MARRAY",$defines_name)){
		
		$defines_array = explode(",",$defines);
		$defines_newarray = array();
		for($i=0; $i<count($defines_array); $i++){
			$temp1array = explode(":",$defines_array[$i]);
			$temp2array = explode("*",$temp1array[1]);
			for($j=0; $j<count($temp2array); $j++){
				$temp3array = explode("=>",$temp2array[$j]);
				$defines_newarray[$temp1array[0]][$temp3array[0]] = $temp3array[1];
			}
		}
		$return_num = $defines_newarray;
		
	}else{
		$return_num = $defines;
	}
	
	return $return_num;
	
}

function DefineArrayCngArray($defines_array){
	$return_array = array();
	foreach($defines_array as $key=>$value){
		$return_array[] = $key;
	}
	return $return_array;
}

function MultiSort($sortKey,$data,$sort_flag){
	
	switch($sort_flag){
		case 'desc':
			$sort = SORT_DESC;
			break;
		case 'asc':
			$sort = SORT_ASC;
			break;
		default:
			$sort = SORT_DESC;
			break;
	}
	
	foreach($data as $key => $row){
		$foo[$key] = $row[$sortKey];
	}
	array_multisort($foo,$sort,$data);
	
	return $data;

}

function XmlReturnArray($mxlpath){
	if($content = file_get_contents($mxlpath)){
		$smp_content = simplexml_load_string($content);
		$return_data = json_decode(json_encode($smp_content), true);
	}else{
		$return_data = false;
	}
	
	return $return_data;
}


function GET_HTMLencode($value){
	$newvalue = htmlspecialchars( urldecode($value),ENT_QUOTES);
	return $newvalue;
}
function HTML_encode($set_value){
	$set_value = htmlspecialchars($set_value, ENT_QUOTES);
	return $set_value;
}
function HTML_decode($set_value){
	$set_value = htmlspecialchars_decode($set_value, ENT_QUOTES);
	return $set_value;
}
function GET_URLencode($value){
	$newvalue = urlencode($value);
	return $newvalue;
}
function GET_URLdecode($value){
	$newvalue = urldecode($value);
	return $newvalue;
}

function DayDiffTwoDate($pDate,$today){
	$TimeStamp1 = strtotime($pDate);
	$TimeStamp2 = strtotime($today);
	$SecondDiff = abs($TimeStamp2 - $TimeStamp1);
	$DayDiff = $SecondDiff / (60 * 60 * 24);
	return $DayDiff;
}

function GDInstall(){
	$gd_array = gd_info();
	
	$gif_flag = $gd_array['GIF Create Support'];
	$jpeg_flag = $gd_array['JPEG Support'];
	$jpg_flag = $gd_array['JPG Support'];
	$png_flag = $gd_array['PNG Support'];
	
	if($gif_flag = true && ($jpeg_flag == true || $jpg_flag == true) && $png_flag == true){
		$return_flag = true;
	}else{
		$return_flag = false;
	}
	
	return $return_flag;
}

function SpaceArray($searchlang){
	
	$word = trim($searchlang);
	if(preg_match("/[ |　]+/", $word,$num)){
		$word = mb_convert_kana($word, "s");
		$keywords = preg_replace("/[\s]+/"," ",$word);
		$keywords_array = explode(" ",$keywords);
	}else{
		$keywords_array[0] = $word;
	}
	
	return $keywords_array;
	
	
}


function addsl($comment) {
    $comment = mysql_real_escape_string($comment);
	$comment = preg_replace("/%/","\%",$comment);
	$comment = preg_replace("/_/","\_",$comment);
    $comment = htmlspecialchars($comment, ENT_QUOTES);
	
	return $comment;
}

function DirCopy($source,$dest,$options = array('folderPermission'=>0755,'filePermission'=>0755)){
	
	$result=false;
	
	if(is_file($source)){
		if($dest[strlen($dest)-1] == '/'){
			if(!file_exists($dest)){
				cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
			}
			$__dest = $dest."/".basename($source);
		}else{
			$__dest = $dest;
		}
		$result = copy($source,$__dest);
		chmod($__dest,$options['filePermission']);
		
	}elseif(is_dir($source)){
		if($dest[strlen($dest)-1] == '/'){
			if($source[strlen($source)-1] == '/'){
			}else{
				$dest = $dest.basename($source);
				@mkdir($dest);
				chmod($dest,$options['filePermission']);
			}
		}else{
			if($source[strlen($source)-1] == '/'){
				@mkdir($dest,$options['folderPermission']);
				chmod($dest,$options['filePermission']);
			}else{
				@mkdir($dest,$options['folderPermission']);
				chmod($dest,$options['filePermission']);
			}
		}

		$dirHandle = opendir($source);
		while($file = readdir($dirHandle))
		{
			if($file != "." && $file != "..")
			{
				if(!is_dir($source."/".$file)){
					$__dest = $dest."/".$file;
				}else{
					$__dest = $dest."/".$file;
				}
				$result = DirCopy($source."/".$file,$__dest,$options);
			}
		}
		closedir($dirHandle);
		
	}else{
		$result = false;
	}
	return $result;
}
?>