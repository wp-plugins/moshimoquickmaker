<?php


function UpImageCombine($original_file,$alpha_file,$save_path,$save_name){


	$original_image = imagecreatefromjpeg($original_file);
	$original_w = imagesx($original_image);
	$original_h = imagesy($original_image);

	$alpha_image = imagecreatefrompng($alpha_file);
    
	$blue = imagecolorclosest ($alpha_image, 0, 0, 255);
    imagecolortransparent($alpha_image, $blue);

	imagecopymerge($original_image, $alpha_image, 0, 0, 0, 0, $original_w, $original_h,100);

	imagejpeg($original_image, $save_path.$save_name,100);

	imagedestroy ( $original_image );

}


function UpImageChange($file_path,$file_name,$maxsize_w,$maxsize_h){



	list($rowimg_w,$rowimg_h) = getimagesize($file_path.$file_name);


	if($rowimg_w !== $maxsize_w && $rowimg_h !== $maxsize_h){

		
		$filetype_array = explode(".",$file_name);
		$format_kind = $filetype_array[1];

		$rate_w = $maxsize_w/$rowimg_w;
		if(($rowimg_h*$rate_w) < $maxsize_h){
			$rate = $rate_w;
		}else{
			$rate = $maxsize_h/$rowimg_h;
		}
	
		$img_w = ceil($rowimg_w*$rate);
		$img_h = ceil($rowimg_h*$rate);
		

		if($format_kind == "jpg"){
			$img_info = imagecreatefromjpeg($file_path.$file_name);
		}else if($format_kind == "png"){
			$img_info = imagecreatefrompng($file_path.$file_name);
		}else if($format_kind == "gif"){
			$img_info = imagecreatefromgif($file_path.$file_name);
		}

		if( $img_info ){
			
			$out_img = imagecreatetruecolor($maxsize_w,$maxsize_h);
			imagefill($out_img , 0 , 0 , 0xFFFFFF);
			
			$copyX = ($maxsize_w-$img_w)/2;
			$copyY = ($maxsize_h-$img_h)/2;

			imagecopyresampled($out_img,$img_info, $copyX, $copyY, 0, 0,$img_w,$img_h,$rowimg_w,$rowimg_h);

			if($format_kind == "jpg"){
				imagejpeg($out_img,$file_path.$file_name,100);
			}else if($format_kind == "png"){
				imagepng($out_img,$file_path.$file_name,100);
			}else if($format_kind == "gif"){
				imagegif($out_img,$file_path.$file_name,100);
			}else{
				return "画像の形式が正しくありません。";
				exit();
			}
			imagedestroy($out_img);
			imagedestroy($img_info);
			
			return  true;

		} else {

			return "画像が読み込めませんでした";
			exit();

		}

	}else{
		return  true;
	}
	
}

function UpImageChangeMin($file_path,$file_name,$maxsize_w,$maxsize_h){



	list($rowimg_w,$rowimg_h) = getimagesize($file_path.$file_name);


	if($rowimg_w > $maxsize_w || $rowimg_h > $maxsize_h){


		$filetype_array = explode(".",$file_name);
		$format_kind = $filetype_array[1];

		$rate_w = $maxsize_w/$rowimg_w;
		if(($rowimg_h*$rate_w) < $maxsize_h){
			$rate = $rate_w;
		}else{
			$rate = $maxsize_h/$rowimg_h;
		}
	
		$img_w = ceil($rowimg_w*$rate);
		$img_h = ceil($rowimg_h*$rate);

		if($format_kind == "jpg"){
			$img_info = imagecreatefromjpeg($file_path.$file_name);
		}else if($format_kind == "png"){
			$img_info = imagecreatefrompng($file_path.$file_name);
		}else if($format_kind == "gif"){
			$img_info = imagecreatefromgif($file_path.$file_name);
		}

		if( $img_info ){

			$out_img = imagecreatetruecolor($img_w,$img_h);

			imagecopyresampled($out_img,$img_info, 0, 0, 0, 0,$img_w,$img_h,$rowimg_w,$rowimg_h);

			if($format_kind == "jpg"){
				imagejpeg($out_img,$file_path.$file_name,100);
			}else if($format_kind == "png"){
				imagepng($out_img,$file_path.$file_name,100);
			}else if($format_kind == "gif"){
				imagegif($out_img,$file_path.$file_name,100);
			}else{
				return "画像の形式が正しくありません。";
				exit();
			}
			imagedestroy($out_img);
			imagedestroy($img_info);

			return  true;

		} else {

			return "画像が読み込めませんでした";
			exit();

		}

	}else{
		return  true;
	}
	
}


function UpLoadImg($files,$get_ID,$get_DIR,$get_wmax,$get_hmax,$fix_flag){


	$msg_type = valid_photo($files['type'],"画像");

	if($msg_type == 1){
	
		$filetype = explode("/",$files['type']);
		if($filetype[1] == "jpeg" || $filetype[1] == "pjpeg"){
			$extension = "jpg";
		}elseif($filetype[1] == "gif"){
			$extension = "gif";
		}else{
			$msg = "画像形式が正しくありません。";
			$upflag = false;
			return array($upflag,$msg);
			exit();
		}
	
		$filename = $get_ID.".".$extension;
	
		if (move_uploaded_file($files['tmp_name'], $get_DIR.$filename) == FALSE){
			$msg = "アップロードに失敗しました。<br>サイズが大きすぎる可能性があります。（1.5Mb未満推奨）";
			$upflag = false;
		}else{
			
			chmod($get_DIR.$filename, 0755);
			
			switch ($fix_flag){
				case 'fix':
					$msg_change = UpImageChange($get_DIR,$filename,$get_wmax,$get_hmax);
					break;
				case 'unfix':
					$msg_change = UpImageChangeMin($get_DIR,$filename,$get_wmax,$get_hmax);
					break;
			}
			
			if($msg_change == 1){
				$msg = $filename;
				$upflag = true;
			}else{
				$msg = $msg_change;
				$upflag = false;
			}
		
		}
	

	
	}else{
		$msg = $msg_type;
		$upflag = false;
	}
	
	return array('upflag' => $upflag,'msg' => $msg);
	exit();

}


function ImgCopyRemove($tmpfiles,$copydir){
	rename($tmpfiles,$copydir);
}


?>