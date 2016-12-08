<?php

    namespace backend\widgets\ProductWidget;

    use yii\web\AssetBundle;

    /**
     * Class ProductCharacteristicWidgetAsset
     * @package backend\widgets\ProductWidget
     */
    class ProductCharacteristicWidgetAsset extends AssetBundle{
        public $sourcePath = '@backend/widgets/ProductWidget/assets';

        public $js = ['productCharacteristic.js'];

        public $depends = [
            'backend\assets\AppAsset'
        ];
    }