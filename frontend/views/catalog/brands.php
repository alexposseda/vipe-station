<?php
    /**
     * @var $this    \yii\web\View
     * @var $brands  \yii\data\ActiveDataProvider
     */
    use common\models\BrandModel;
    use yii\caching\DbDependency;
    use yii\widgets\ListView;

?>
<div class="col s12 page-main ">
    <div class="sub-title">
        <span class="fs30 white-text title-catalog"><?=Yii::t('models','Brands')?></span>
    </div>
    <?php $dependency = new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM '.BrandModel::tableName()]);
        if($this->beginCache('all_brandCache', ['duration' => 0, 'dependency' => $dependency])):
            ?>
            <?= ListView::widget([
                                     'dataProvider' => $brands,
                                     'itemView'     => '_brand_item',
                                     'itemOptions'  => ['class' => 'wrap-overflow product'],
                                     'layout'       => "<div class='content products-wrapper-isotope valign'>{items}</div>\n{summary}",
                                     'summary'      => '<div class="count-page fs25">{page} / {pageCount}</div>',
                                 ]) ?>

            <?php $this->endCache();
        endif; ?>
</div>