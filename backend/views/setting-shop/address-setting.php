<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \backend\models\AddressSettingModel
     */
    use backend\assets\AddressFormAsset;
    use common\widgets\MapWidget\FormMapWidget;
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

    AddressFormAsset::register($this);
?>
<?php $form = ActiveForm::begin() ?>

<?php if($model->_count): ?>
    <?php for($i = 0; $i < $model->_count; $i++): ?>
        <div class="panel panel-danger">
            <span class="page-header"> <?= Yii::t('shop/setting', 'Address').': '.$model->address[$i] ?></span>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8">
                        <?= $form->field($model, "address[$i]") ?>
                        <?= $form->field($model, "schedule[$i]") ?>
                        <?= $form->field($model, "phones[$i]") ?>
                        <?= $form->field($model, "baseAddress[$i]")
                                 ->radio() ?>
                        <?= Html::activeTextInput($model, 'centerMap[$i]') //todo спрятать     ?>
                    </div>
                    <div class="col-lg-4 map">
                        <p class="label center-align"><?= Yii::t('app', 'Map') ?></p>
                        <div id="map"> <!--todo сделать для каждго блока отдельную карту-->
                            <?= FormMapWidget::widget([
                                                          'mapSetting' => [
                                                              'id'           => "map-$i",
                                                              'center'       => $model->centerMap[$i],
                                                              'zoom'         => Yii::$app->params['mapConfig']['zoom'],
                                                              'draggable'    => true,
                                                              'addressInpId' => "addresssettingmodel-address-$i",
                                                              'coordInpId'   => "addresssettingmodel-centerMap-$i"
                                                          ]
                                                      ]) ?>
                        </div>
                    </div><!--Map-->
                </div>
            </div>
        </div>
    <?php endfor; ?>
<?php else: ?>
    <div class="panel panel-danger">
        <span class="page-header"> <?= Yii::t('shop/setting', 'Address') ?></span>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <?= $form->field($model, "address[0]") ?>
                    <?= $form->field($model, "schedule[0]") ?>
                    <?= $form->field($model, "phones[0]") ?>
                    <?= $form->field($model, "baseAddress[0]")
                             ->radio() ?>
                    <?= Html::activeTextInput($model, 'centerMap[0]') //todo спрятать     ?>
                </div>
                <div class="col-lg-4 map">
                    <p class="label center-align"><?= Yii::t('app', 'Map') ?></p>
                    <div class="" id="map">
                        <?= FormMapWidget::widget([
                                                      'mapSetting' => [
                                                          'center'       => $model->centerMap[0],
                                                          'zoom'         => Yii::$app->params['mapConfig']['zoom'],
                                                          'draggable'    => true,
                                                          'addressInpId' => 'addresssettingmodel-address-0',
                                                          'coordInpId'   => 'addresssettingmodel-centerMap-0'
                                                      ]
                                                  ]) ?>
                    </div>
                </div><!--Map-->
            </div>
        </div>
    </div>
    <div class="panel panel-danger">
        <span class="page-header"> <?= Yii::t('shop/setting', 'Address') ?></span>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <?= $form->field($model, "address[1]") ?>
                    <?= $form->field($model, "schedule[1]") ?>
                    <?= $form->field($model, "phones[1]") ?>
                    <?= $form->field($model, "baseAddress[1]")
                             ->radio() ?>
                    <?= Html::activeTextInput($model, 'centerMap[1]') //todo спрятать     ?>
                </div>
                <div class="col-lg-4 map">
                    <p class="label center-align"><?= Yii::t('app', 'Map') ?></p>
                    <div class="" id="map">
                        <?= FormMapWidget::widget([
                                                      'mapSetting' => [
                                                          'center'       => $model->centerMap[1],
                                                          'zoom'         => Yii::$app->params['mapConfig']['zoom'],
                                                          'draggable'    => true,
                                                          'addressInpId' => 'addresssettingmodel-address-1',
                                                          'coordInpId'   => 'addresssettingmodel-centerMap-1'
                                                      ]
                                                  ]) ?>
                    </div>
                </div><!--Map-->
            </div>
        </div>
    </div>
<?php endif; ?>


<?= Html::submitButton(Yii::t('system', 'Save')) ?>
<?php ActiveForm::end() ?>
