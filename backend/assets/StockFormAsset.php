<?php

    namespace backend\assets;

    use yii\web\AssetBundle;

    class StockFormAsset extends AssetBundle{

        public $js=[
          'js/stock-form.js'
        ];
        public $depends = [
            'backend\assets\AppAsset',
        ];
    }