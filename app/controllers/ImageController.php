<?php

 use Phalcon\Flash;
 use Phalcon\Mvc\Model\Query;
// use Phalcon\Mvc\Model\Criteria;
// use Phalcon\Paginator\Adapter\Model as Paginator;
 use Phalcon\Http\Request;


class ImageController extends ControllerBase{
  
    public function initialize(){
      parent::initialize();
    }

    public function indexAction(){
      try {

        
        if ($this->request->isPost()){
          //var_dump($photos); die;
          if ($_FILES['image_file']['name']!='') {
            include APP_PATH . 'app/library/Image.php';
            $image=new Image;
            $folder="public/uploads/images";
            $imgpath=$image->upload('image_file',$folder);
            $this->view->imgpath=$imgpath;
            // if(isset($imgpath)){
            //     del_rel_img($imgpath);
            // }
          }
        }

    }catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
      exit();
    }

    }
}

        
      

                 