<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SeoModel */

$this->title = Yii::t('system/view', 'Update').' '.Yii::t('models', 'Seo').': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Seo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system/view', 'Update');
?>
<div class="seo-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
