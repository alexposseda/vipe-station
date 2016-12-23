<?php

    use yii\helpers\Html;
    use common\models\ProductCharacteristicModel;

    /* @var $this yii\web\View */
    /* @var $model common\models\CategoryModel
     * @var ProductCharacteristicModel [] $characteristics
     */

    $this->title = Yii::t('system/view', 'Create').' '.Yii::t('models/category', 'Category');
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('models/base', 'Categories'),
        'url'   => ['index']
    ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
