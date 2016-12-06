<?php

    namespace backend\widgets\ProductCharacteristicWidget;

    use yii\web\AssetBundle;

    /**
     * Class ProductCharacteristicWidgetAsset
     * @package backend\widgets\ProductCharacteristicWidget
     */
    class ProductCharacteristicWidgetAsset extends AssetBundle{
        public $sourcePath = '@backend/widgets/ProductCharacteristicWidget/assets';

        public $js = ['productCharacteristic.js'];

        public $depends = [
            'backend\assets\AppAsset'
        ];
    }