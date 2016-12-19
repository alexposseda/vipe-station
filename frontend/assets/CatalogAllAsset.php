<?php

    namespace frontend\assets;

    use yii\web\AssetBundle;

    class CatalogAllAsset extends AssetBundle{
        public $js       = [
            'js/catalog_all.js'
        ];
        public $depends  = [
            'frontend\assets\AppAsset'
        ];
    }