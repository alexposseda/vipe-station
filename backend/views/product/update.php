<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model \backend\models\forms\ProductForm */

    $this->title = Yii::t('system/view', 'Update').' '.Yii::t('models', 'Product').': '.$model->product->title;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Products'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->product->title, 'url' => ['view', 'id' => $model->product->id]];
    $this->params['breadcrumbs'][] = Yii::t('system/view', 'Update');
?>
<div class="product-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
