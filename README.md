# phalcon image manipulation [(INVO)](https://github.com/phalcon/invo)
Image manipulation in phalcon which create thumbnail and multiple sizes of image during upload time.
like every freamwork phalcon also provide image manipulation but during the time crop image it will crop perticular defined resolution. but using this image lib. first image **resized** to required (given) reolution then **crop** image.

## Code Example
use this function to get relation image
```yaml
<?php echo get_rel_img('uploaded/path/of/file.jpeg','thumb'); ?>
```

## Installation

And Copy this files

```yaml
app/config/image_config.php
app/library/Image.php


app/controllers/ImageController.php (optional)
```
## Tests Example

```yaml
//Check post set or not
if ($this->request->isPost()){
  //Check file uploaded or not
  if ($_FILES['image_file']['name']!='') {
    //include image lib
    include APP_PATH . 'app/library/Image.php';
    $image=new Image;
    //give location where you want to upload image
    $folder="public/uploads/images";
    //here 'image_file' is <input type="file" name="image_file">
    $imgpath=$image->upload('image_file',$folder); 
    $this->view->imgpath=$imgpath;
    //following function for delete uploaded file
    // if(isset($imgpath)){
    //     del_rel_img($imgpath);
    // }
  }
}
```
