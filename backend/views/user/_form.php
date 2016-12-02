    <?php
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

/* @var $this yii\web\View
* @var $model common\models\User
 * @var $form yii\widgets\ActiveForm
 */

$auth = Yii::$app->authManager;
$roles = ArrayHelper::map($auth->getRoles(),'name','name');

$params = [
    'prompt' => ''
];
?>

<div class="user-form">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::dropDownList('role', $rol_user, $roles, ['prompt' =>'Select Role']) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('system/view', 'Create') : Yii::t('system/view', 'Update'), ['class' =>                               $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
