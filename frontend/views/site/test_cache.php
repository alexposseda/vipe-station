<?php
    /**
     * @var $this         \yii\web\View
     * @var $dataProvider \yii\data\ActiveDataProvider
     */
    use common\models\BrandModel;
    use yii\grid\GridView;

?>
<?php
    $dependency = [
        'class' => 'yii\caching\DbDependency',
        'sql'   => 'SELECT MAX(updated_at) FROM '.BrandModel::tableName(),
    ];
    if($this->beginCache('brandCache', ['duration' => 3600, 'dependency' => $dependency])): ?>
        <?= GridView::widget(['dataProvider' => $dataProvider]) ?>
        <?php
        $this->endCache();
    endif;
?>
