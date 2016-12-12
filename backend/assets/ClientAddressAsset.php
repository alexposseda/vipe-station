<?php

    namespace backend\assets;

    use yii\web\AssetBundle;


    class ClientAddressAsset extends AssetBundle{

        public $js = [
            'js/client.js',
        ];

        public $depends = [
            'backend\assets\AppAsset',
        ];

    }