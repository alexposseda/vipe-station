<?php
    /**
     * @var $this            yii\web\View
     * @var $model           common\models\ProductModel
     *
     * @var $relatedProducts \common\models\RelatedProductModel[]
     */
    use yii\helpers\ArrayHelper;

    if($model->isBaseProduct()){
        echo 'base product';
    }else if($model->isSingleProduct()){
        echo 'single product';
    }else if($model->isRelatedProduct()){
        echo 'related product';
    }else{
        echo 'oops';
    }
    echo '<br>';
    /**
     * @var $rp \common\models\ProductModel
     */
    $options = [];
    foreach($model->productCharacteristicItems as $prodCharItem){
        if($prodCharItem->characteristic->isOption){
            $options[] = $prodCharItem->characteristic;
        }
    }
?>