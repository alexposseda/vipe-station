<?php
/**
 * @var $this \yii\web\View
 */
use common\models\ClientModel;
use common\models\OrderClientDataModel;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$model = new OrderClientDataModel();

?>
<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div class="col-lg-6">
        <div class=" panel panel-danger">
            <div class="panel-heading">
                <p class="page-title">Выберете клиента</p>
                <div class="clearfix"></div>
            </div>
            <?= $form->field($model, 'client_id', ['options' => ['class' => 'panel-body']])->label(false)->dropDownList(ArrayHelper::map(ClientModel::find()->all(), 'id', 'name')) ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <p class="page-title">Создать нового клиента</p>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <?= Html::a(Yii::t('system/view', 'Create') . ' ' . Yii::t('models/client', 'Client'), ['client/create', 'redirect' => Url::to('', 1)], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

</div>
<?php ActiveForm::end() ?>
