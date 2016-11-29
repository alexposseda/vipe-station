<?php

    namespace backend\models;

    use yii\alexposseda\fileManager\FileManager;
    use yii\alexposseda\fileManager\models\FileManagerModel;
    use yii\imagine\Image;

    class UploadCover extends FileManagerModel{
        public function uploadFile($directory){
            $fileName = uniqid(time(), true);
            $this->savePath = $directory.DIRECTORY_SEPARATOR.$fileName.'.'.$this->file->extension;

            Image::thumbnail($this->file->tempName, 168, 208)
                 ->save(FileManager::getInstance()->getStoragePath().$this->savePath, ['quality' => 80]);

            return $this;
        }

    }