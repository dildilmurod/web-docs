<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class ImageUpload extends Model{

    public $image;

    public function rules(){
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions'=> 'jpg, png, gif, jpeg, pdf, doc, docx, txt, ppt, pps, pptx, xls, xlsx, zip, rar, xml']
        ];
    }


    public function uploadFile($file, $currentImage)
    {
        /* @var $file UploadedFile*/
        $this->image = $file;

        if($this->validate())
        {

            $this->deleteCurrentImage($currentImage);

            return $this->saveImage($file);
        }

    }

    private function getFolder(){

        return Yii::getAlias('@frontend').'/web/uploads/';
    }

    private function genFilename(){

        return strtolower(md5(uniqid($this->image->baseName)).'.'.$this->image->extension);
    }

    public function deleteCurrentImage($currentImage){

        if(!empty($currentImage) && $currentImage !=null){
            if(file_exists($this->getFolder(). $currentImage)){

                unlink($this->getFolder(). $currentImage);

            }}
    }

    public function fileExists($currentImage){
        if(!empty($currentImage) && $currentImage != null){
            return file_exists($this->getFolder().$currentImage);
        }
    }

    public function saveImage($file)
    {
        /* @var $file UploadedFile*/

        $filename = $this->genFilename();
        $file->saveAs($this->getFolder().$filename);


        //$this->image->saveAs($this->getFolder() . $this->image->baseName . '.' . $this->image->extension);

//        Image::thumbnail($this->getFolder() . $this->image, 500, 300)
//            ->resize(new Box(500,300))
//            ->save($this->getFolder().'/thumbnail-500x300/' . $filename,
//                ['quality' => 70]);
//        unlink($this->getFolder().$filename);

        return $filename;
    }


}


?>