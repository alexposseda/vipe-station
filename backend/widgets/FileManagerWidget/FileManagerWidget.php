<?php
    namespace backend\widgets\FileManagerWidget;

    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\base\Widget;
    use yii\web\View;

    /**
     * Class FileManagerWidget
     * @package backend\widgets\FileManagerWidget
     */
    class FileManagerWidget extends Widget{
        public $uploadUrl;
        public $removeUrl;
        public $files;
        public $targetInputId;
        public $maxFiles;
        public $title;
        public $id;

        public function init(){
            parent::init();
            $this->registerTranslations();
            if($this->files){
                $this->files = json_decode($this->files);
            }
            if(empty($this->title)){
                $this->title = Yii::t('app', 'File Upload');
            }

            if(empty($this->id)){
                $this->id = 'fmw-'.$this->getId();
            }

        }

        public function run(){

            $notSaveFiles = FileManager::getFilesFromSession();

            $script = <<<JS
fmwInit("{$this->id}", {
    uploadUrl: "{$this->uploadUrl}",
    removeUrl: "{$this->removeUrl}",
    targetInputId: "{$this->targetInputId}",
    maxFiles: "{$this->maxFiles}"
})

JS;
            Yii::$app->getView()
                     ->registerJs($script, View::POS_END);
            FileManagerWidgetAsset::register(Yii::$app->getView());

            return $this->render('baseWidget', [
                'notSavedFiles' => $notSaveFiles,
                'savedFiles' => $this->files,
                'title' => $this->title,
                'widgetId' => $this->id
            ]);
        }

        public function registerTranslations(){
            $i18n = Yii::$app->i18n;
            $i18n->translations['FileManagerWidget'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@common/translations',
            ];
        }
    }