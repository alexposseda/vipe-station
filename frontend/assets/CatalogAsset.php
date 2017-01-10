<?php

    namespace frontend\assets;

    use yii\web\AssetBundle;

    class CatalogAsset extends AssetBundle{
        public $js       = [
            'js/catalog.js',
            'js/slick.js',
            'js/catalog_slick.js'
        ];
        public $depends  = [
            'frontend\assets\AppAsset'
        ];
    }