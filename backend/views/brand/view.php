<?php

    use common\models\LanguageModel;
    use yii\bootstrap\Html;
    use yii\bootstrap\Tabs;
    use yii\helpers\ArrayHelper;

    /* @var $this yii\web\View */
    /* @var $model common\models\BrandModel */

    $this->title = $model->title;
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('models', 'Brand'),
        'url'   => ['index']
    ];
    $this->params['breadcrumbs'][] = $this->title;

?>
<div class="brand-model-view">


    <div class="row">
        <div class="col-lg-9 col-md-8 col-sm-12">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="small">
                <strong><?= Yii::t($model->getTcategory(), $model->getAttributeLabel('updated_at')) ?>:</strong>
                <?= date("d/m/Y H:i", $model->updated_at) ?>
            </p>
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-2">
                    <?php
                        $logo = $model->getLogo();
                        if(is_null($logo)){
                            $logo = '/img/noPicture.png';
                        }
                    ?>
                    <div class="brand-logo-container">
                        <?= Html::img($logo, ['class' => 'img-thumbnail']) ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= Yii::t($model->getTcategory(), $model->getattributeLabel('description')) ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php if(empty($model->description)): ?>
                                <div class="alert alert-info">
                                    <p><?= Yii::t('system/view', 'Not set') ?></p>
                                </div>
                            <?php else: ?>
                                <p><?= $model->description ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12">
            <p>
                <?= Html::a(Yii::t('system/view', 'Update').' '.Yii::t('models', 'Brand'), [
                    'update',
                    'id' => $model->id
                ], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('system/view', 'Delete').' '.Yii::t('models', 'Brand'), [
                    'delete',
                    'id' => $model->id
                ], [
                                'class' => 'btn btn-danger',
                                'data'  => [
                                    'confirm' => Yii::t('system/view', 'Are you sure you want to delete this item?'),
                                    'method'  => 'post',
                                ],
                            ]) ?>
            </p>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="panel-title">SEO</p>
                </div>
                <div class="panel-body">
                    <?php if($model->seo): ?>
                        <ul class="list-group">
                            <?php if(!empty($model->seo->title)): ?>
                                <li class="list-group-item">
                                    <h4 class="list-group-item-heading">Seo Title</h4>
                                    <p class="list-group-item-text"><?= $model->seo->title ?></p>
                                </li>
                            <?php endif; ?>
                            <?php if(!empty($model->seo->keywords)): ?>
                                <li class="list-group-item">
                                    <h4 class="list-group-item-heading">Seo keywords</h4>
                                    <p class="list-group-item-text"><?= $model->seo->keywords ?></p>
                                </li>
                            <?php endif; ?>
                            <?php if(!empty($model->seo->description)): ?>
                                <li class="list-group-item">
                                    <h4 class="list-group-item-heading">Seo description</h4>
                                    <p class="list-group-item-text"><?= $model->seo->description ?></p>
                                </li>
                            <?php endif; ?>
                            <?php if(!empty($model->seo->seo_block)): ?>
                                <li class="list-group-item">
                                    <h4 class="list-group-item-heading">Seo block</h4>
                                    <p class="list-group-item-text"><?= $model->seo->seo_block ?></p>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <p><?= Yii::t('system/view', 'Not set') ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>
