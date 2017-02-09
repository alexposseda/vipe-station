<?php
    /**
     * @var $this    \yii\web\View
     * @var $popular \yii\data\ActiveDataProvider
     * @var $brands  \yii\data\ActiveDataProvider
     */
    use common\models\BrandModel;
    use common\models\ProductCharacteristicItemModel;
    use common\models\ProductInCategoryModel;
    use common\models\ProductInStockModel;
    use common\models\ProductModel;
    use frontend\assets\CatalogAsset;
    use yii\caching\ChainedDependency;
    use yii\caching\DbDependency;
    use yii\widgets\ListView;
?>
<div class="col s12 page-main">
    <div class="sub-title">
        <span class="fs30 white-text title-catalog"><?=Yii::t('models/product','Popular goods')?></span>
    </div>
    <div class="content">
<!--        <div class="catalog-background">-->
            <?php $dependencyPopular = [
                'class'        => ChainedDependency::className(),
                'dependencies' => [
                    new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductModel::tableName()]),
                    new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductInCategoryModel::tableName()]),
                    new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductInStockModel::tableName()]),
                    new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductCharacteristicItemModel::tableName()]),
                ]
            ];
                if($this->beginCache('popularCache', ['duration' => 0, 'dependency' => $dependencyPopular])):
                    ?>
                    <?= ListView::widget([
                                             'dataProvider' => $popular,
                                             'itemView'     => '_catalog_item',
                                             'itemOptions'  => ['class' => 'wrap-overflow product'],
                                             'layout'       => "<div class='catalog-wrap-content product-carousel'>{items}</div>",
                                             'options' => ['class' => 'catalog-background']
                                         ]) ?>
                    <?php $this->endCache();
                endif; ?>
<!--        </div>-->
    </div>
    <div class="sub-title">
        <span class="fs30 white-text title-catalog"><?=Yii::t('models','Brands')?></span>
    </div>
    <div class="content">
        <div class="catalog-background">
            <?php $dependencyBrands = [
                'class'        => ChainedDependency::className(),
                'dependencies' => [
                    new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.BrandModel::tableName()]),
                ]
            ];
                if($this->beginCache('brandCatalogCache', ['duration' => 0, 'dependency' => $dependencyBrands])):
                    ?>
                    <?= ListView::widget([
                                             'dataProvider' => $brands,
                                             'itemView'     => '_brand_item',
                                             'itemOptions'  => ['class' => 'wrap-overflow brand'],
                                             'layout'       => "<div class='catalog-wrap-content brand-carousel'>{items}</div>",
                                         ]) ?>
                    <?php $this->endCache();
                endif; ?>
        </div>
    </div>
</div>