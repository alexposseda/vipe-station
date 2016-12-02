<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SeoModel */

$this->title = Yii::t('system/view', 'Create').' '.Yii::t('models', 'Seo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Seo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
