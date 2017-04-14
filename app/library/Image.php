<?php

class Image extends ControllerBase
{


  public function upload($file_name,$folder,$name=false){
    //print_r($_FILES);die;
    //echo $file_name;
    if($_FILES[$file_name]['error'] == 0){
      $img_path=$_FILES[$file_name]['tmp_name'];
      return  $this->images($img_path,$folder,$name);
    }else{
      return false;
    }
  }


  public function images($image_path,$folder,$default_name=false){
        //print_r($size);
      $folder=APP_PATH.$folder;
      if (!file_exists($folder)) {
          mkdir($folder, 0777 , true);
      }
      
      $crop_size=get_img_size();
      foreach ($crop_size as $img_name => $size) {

          list($height, $width, $crop) = $size;
          $name_string= $default_name ? $default_name : img_name('date_time');

          $image = new \Phalcon\Image\Adapter\Gd($image_path);
          $info = getimagesize($image_path);
          $ext = image_type_to_extension($info[2]);
          //$ext = pathinfo($image_path, PATHINFO_EXTENSION);
          

          if($image->getHeight() < $image->getWidth()){
            $image->resize(
                $height,
                $width,
                      \Phalcon\Image::HEIGHT
            ); 
          }else{
            $image->resize(
                $height,
                $width,
                      \Phalcon\Image::WIDTH
            ); 
          }
    			$resize_path=$folder.'/'.$name_string.'-'.$img_name.$ext;
    			 $image->save($resize_path);
    			
          if($crop){               
            $image = new \Phalcon\Image\Adapter\Gd($resize_path);

            $width= $width;
            $height= $height;
            $offsetX = (($image->getWidth() - $width) / 2);
            $offsetY = (($image->getHeight() - $height) / 2);

            $image->crop($width, $height, $offsetX, $offsetY);

            $image->save($resize_path);
          }
       }

      $image = new \Phalcon\Image\Adapter\Gd($image_path);
      $remove_other=array(APP_PATH,"-$img_name");
      $image->save(str_replace("-$img_name",'',$resize_path));
      return str_replace($remove_other,'',$resize_path);
    }
}