<?php

    namespace backend\assets;

    use yii\web\AssetBundle;

    class CategoryFormAsset extends AssetBundle{
        public $css = [
        ];
        public $js = [
            'js/category_form.js'
        ];
        public $depends = [
            'backend\assets\AppAsset'
        ];
    }