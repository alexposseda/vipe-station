<?php use common\models\ProductCharacteristicItemModel;
    use common\models\ProductInCategoryModel;
    use common\models\ProductInStockModel;
    use common\models\ProductModel;
    use yii\caching\ChainedDependency;
    use yii\caching\DbDependency;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;

    $dependency = [
    'class'        => ChainedDependency::className(),
    'dependencies' => [
        new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductModel::tableName()]),
        new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductInCategoryModel::tableName()]),
        new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductInStockModel::tableName()]),
        new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.ProductCharacteristicItemModel::tableName()]),
    ]

];
    Pjax::begin();
    if($this->beginCache('brandCache',
                         ['variations' => [Yii::$app->language, Yii::$app->request->queryParams], 'duration' => 0, 'dependency' => $dependency])
    ):
        ?>


        <?= ListView::widget([
                                 'dataProvider' => $catalog,
                                 'itemView'     => '_catalog_item',
                                 'itemOptions'  => ['class' => 'wrap-overflow product'],
                                 'layout'       => "<div class='sort-wraper sub-title white-text'><span class='sorted-by border-r'>".Yii::t('models/product',
                                                                                                                                            'Sort by')."</span>{sorter}</div>\n<div class='content products-wrapper-isotope valign'>{items}</div>\n<div class='pager'>{summary}{pager}</div>",
                                 'pager'        => ['maxButtonCount' => 0],
                                 'sorter'       => ['options' => ['class' => 'sort ']],
                                 'summary'      => '<div class="count-page fs25">{page} / {pageCount}</div>',
                             ]) ?>

        <?php $this->endCache();
    endif; ?>

<?php Pjax::end(); ?>
