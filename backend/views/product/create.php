<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model common\models\ProductModel */

    $this->title = Yii::t('system/view', 'Create').' '.Yii::t('models', 'Product');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Products'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
