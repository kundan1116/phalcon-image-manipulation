<?php

	/*********************************
	function @return array 
	number of element in array generate no. of images in asign size
	if 1st argument is true then return size append name
	Eg: -large.jpg, -medium.jpg
	*********************************/
	function get_img_size($only_key=false){
		$img_size = array(
			//append_name => height, width, crop
			'large' 	=> [700, 700 , false], 
			'medium' 	=> [250, 250 , true], 
			'thumb' 	=> [90,  90 ,  true], 
		);

		return (array)($only_key ? array_keys($img_size) : $img_size);

	}


	/*********************************
	function @return string 
	default prepend_name of image
	if 1st argument is date_time / date / unique  then return pre-pend name of imagege
	*********************************/
	function img_name($type=false){
		$types_arr = array(
				'date_time' => date("Y-m-d-h-m-i",time()), 
				'date' => date("Y-m-d",time()), 
				'unique' => uniqid(), 
			);
		return (string)(isset($types_arr[$type]) ?  $types_arr[$type] : $types_arr['unique']);
	}

	function del_rel_img($path=false){
		// echo $path;die;
		$files=array();
		$sizes=get_img_size(true);
		$sizes=array_values($sizes);
		$sizes[]='';
		foreach ($sizes as $size) {
			$files[]=get_rel_img($path,$size,true);
		}
		//print_r($files);
		if(file_exists($files[0])){
			array_map('unlink', $files);
			return true;
		}else{
			return 'Given file not exists';
		}
	}

	function get_rel_img($path=false,$size='',$returnbasePath=false){
		try{
			$sizes=get_img_size();
			$sizes=array_keys($sizes);
			if($path){
				if($size==''|| in_array($size,$sizes)){
					$url=parse_ini_file(APP_PATH."app/config/config.ini");
					$size = $size!='' ? '-'.$size : '';
					$_pathInfo = pathinfo($path);


					$final_path=($_pathInfo['dirname'].'/'.$_pathInfo['filename'].$size.'.'.$_pathInfo['extension']);	
				  return ($returnbasePath) ? APP_PATH.$final_path : $url['baseUri'].$final_path;
				}else{
					 throw new InvalidArgumentException("Invalid file size $size in <b>".__FUNCTION__.'</b> function');
				}
			}else {
				return false;
				// throw new InvalidArgumentException("<b>".__FUNCTION__.'</b> function required at least 1 Argument');
			}
		}catch (Exception $e) {
		    echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

?>