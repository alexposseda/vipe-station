<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model \backend\models\BrandForm */

    $this->title = Yii::t('system/view', 'Create').' '.Yii::t('models', 'Brand');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Brands'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
