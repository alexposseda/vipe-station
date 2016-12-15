<?php
/**
 * @var $this \yii\web\View
 */
    use common\models\ProductCharacteristicItemModel;
    use common\models\ProductInCategoryModel;
    use common\models\ProductInStockModel;
    use common\models\ProductModel;
    use frontend\assets\CatalogAsset;
    use yii\caching\ChainedDependency;
    use yii\widgets\ListView;

    CatalogAsset::register($this);
?>

<div class="col s12 page-main">
    <div class="sub-title">
        <a href="#" class="fs30 white-text title-catalog"><?=Yii::t('models/product','Popular goods')?></a>
    </div>
    <div class="content">
        <div class="catalog-background">
            <div class="catalog-wrap-content product-carousel">
                <?php $dependency = [
                    'class'        => ChainedDependency::className(),
                    'dependencies' => [
                        new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductModel::tableName()]),
                        new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductInCategoryModel::tableName()]),
                        new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductInStockModel::tableName()]),
                        new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductCharacteristicItemModel::tableName()]),
                    ]
                ];
                    if($this->beginCache('popularCache', ['duration' => 0, 'dependency' => $dependency])):
                        ?>
                        <?= ListView::widget([
                                                 'dataProvider' => $popular,
                                                 'itemView'     => '_catalog_item',
                                                 'itemOptions'  => ['class' => 'wrap-overflow product'],
                                                 'layout'       => "<div class='catalog-wrap-content product-carousel'>{items}</div>",
                                             ]) ?>
                        <?php $this->endCache();
                    endif; ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="sub-title">
        <a href="#" class="fs30 white-text title-catalog"><?=Yii::t('models/product','New goods')?></a>
    </div>
    <div class="content">
        <div class="catalog-background">
            <div class="catalog-wrap-content brand-carousel">
                <?php $dependency = [
                    'class'        => ChainedDependency::className(),
                    'dependencies' => [
                        new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductModel::tableName()]),
                        new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductInCategoryModel::tableName()]),
                        new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductInStockModel::tableName()]),
                        new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductCharacteristicItemModel::tableName()]),
                    ]
                ];
                    if($this->beginCache('newestCache', ['duration' => 0, 'dependency' => $dependency])):
                        ?>
                        <?= ListView::widget([
                                                 'dataProvider' => $newest,
                                                 'itemView'     => '_catalog_item',
                                                 'itemOptions'  => ['class' => 'wrap-overflow product'],
                                                 'layout'       => "<div class='catalog-wrap-content product-carousel'>{items}<div class='clear'></div></div>",
                                             ]) ?>
                        <?php $this->endCache();
                    endif; ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
