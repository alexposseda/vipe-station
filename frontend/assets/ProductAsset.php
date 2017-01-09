<?php

    namespace frontend\assets;

    use yii\web\AssetBundle;

    class ProductAsset extends AssetBundle{
        public $js       = [
            'js/product.js',
        ];
        public $depends  = [
            'frontend\assets\AppAsset',
            'frontend\assets\CatalogAsset',
        ];
    }