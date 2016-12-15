<?php

    namespace frontend\assets;

    use yii\web\AssetBundle;

    /**
     * Main frontend application asset bundle.
     */
    class AppAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl  = '@web';
        public $css      = [
            //        'css/site.css',
            'css/ghpages-materialize.css',
            'css/materialize.css',
            'css/grs.css',
            'http://fonts.googleapis.com/icon?family=Material+Icons'
        ];
        public $js       = [
            'js/materialize.js',
            'js/fullHeight.js',
            'js/ion.rangeSlider.min.js',
            'js/isotoper.min.js',
            'js/main.js',
        ];
        public $depends  = [
            'yii\web\YiiAsset',
            //            'yii\bootstrap\BootstrapAsset',
        ];
    }
