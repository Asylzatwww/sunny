<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $imageFiles;
    public $imageRoot = '';

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }
    
    public function upload($image, $oldImage = null)
    {
        
        if ($this->imageFile == null) {
            $this->addError('imageFile', 'Image required.');
            return false;
        }
        if ($this->validate()) {
            if ($oldImage != null) $this->deleteImage($oldImage);
            $this->imageFile->saveAs('upload/' . $this->imageRoot . $image . '.jpg');
            $imageRes = new SimpleImage();
            $imageRes->load($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $this->imageRoot . $image . '.jpg');
            $imageRes->resizeToWidth(120);
            $imageRes->save($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $this->imageRoot . $image . '.jpg');
            return true;
        } else {
            return false;
        }
    }

    public function uploadMultiple($image, $imageList, $directory, $deleteImage = null, $oldAlias = null)
    {
        $imageCount = explode(';', $imageList);

            if ($deleteImage != null && $oldAlias != null) {
                foreach ($deleteImage as $current) {
                    $this->imageRoot = $directory . '/medium/';
                    $this->deleteImage($oldAlias . $current);

                    $this->imageRoot = $directory . '/small/';
                    $this->deleteImage($oldAlias . $current);

                    $this->imageRoot = $directory . '/big/';
                    $this->deleteImage($oldAlias . $current);

                    if (array_search($current, $imageCount) != false) unset($imageCount[array_search($current, $imageCount)]);
                }
            }

            if ($oldAlias != null) {
                $this->imageRoot = $directory . '/medium/';
                $this->aliasRenameMultiple($oldAlias, $image, $imageCount);

                $this->imageRoot = $directory . '/small/';
                $this->aliasRenameMultiple($oldAlias, $image, $imageCount);

                $this->imageRoot = $directory . '/big/';
                $this->aliasRenameMultiple($oldAlias, $image, $imageCount);
            }
            
            if ($this->imageFiles != null) { 

                    foreach ($this->imageFiles as $file) {
                        if (!empty($imageCount)){ 
                            if (count($imageCount) >= 10) { $this->addError('imageFiles', 'You can\'t load more than 10 images'); break; }//echo '(' . count($imageCount) . ')';
                            $imageMax = 1 + max($imageCount);
                        } else {
                            $imageCount = array();
                            $imageMax = 1;
                            $this->imageRoot = $directory . '/big/';
                        }
                        array_push($imageCount, $imageMax);

                        $file->saveAs('upload/' . $this->imageRoot . $image . $imageMax . '.jpg');
                        $imageRes = new SimpleImage();

                        $imageRes->load($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $this->imageRoot . $image . $imageMax . '.jpg');

                        $imageRes->resizeToWidth(500);
                        $this->imageRoot = $directory . '/big/';
                        $imageRes->save($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $this->imageRoot . $image . $imageMax . '.jpg');

                        $imageRes->resizeToWidth(300);
                        $this->imageRoot = $directory . '/medium/';
                        $imageRes->save($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $this->imageRoot . $image . $imageMax . '.jpg');

                        $imageRes->resizeToWidth(150);
                        $this->imageRoot = $directory . '/small/';
                        $imageRes->save($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $this->imageRoot . $image . $imageMax . '.jpg');


                    }
            }

            return implode(';', $imageCount);
    }

   public function aliasRenameMultiple($oldAlias, $newAlias, $imageCount){
        if ($oldAlias != $newAlias){
            $image = new SimpleImage();
            foreach ($imageCount as $current) {
                if ($current != null) {
                    $image->load($_SERVER['DOCUMENT_ROOT'] . "/upload/" . $this->imageRoot . $oldAlias . $current . '.jpg');
                    $this->deleteImage($oldAlias . $current);
                    $image->save($_SERVER['DOCUMENT_ROOT'] . "/upload/" . $this->imageRoot . $newAlias . $current . '.jpg');                    
                }
            }
        }
    }

    public function aliasRename($oldAlias, $newAlias){
        if ($oldAlias != $newAlias){
            $image = new SimpleImage();
            $image->load($_SERVER['DOCUMENT_ROOT'] . "/upload/" . $this->imageRoot . $oldAlias . '.jpg');
            $this->deleteImage($oldAlias);
            $image->save($_SERVER['DOCUMENT_ROOT'] . "/upload/" . $this->imageRoot . $newAlias . '.jpg');
        }
    }

    public function deleteImage($image){
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $this->imageRoot . $image . '.jpg')) 
            unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $this->imageRoot . $image . '.jpg');
    }
}