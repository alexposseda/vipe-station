<?php
	/**
	 * @var $this        \yii\web\View
	 * @var $model       \common\models\search\OrderSearchModel
	 */
	use yii\bootstrap\ActiveForm;
	use yii\bootstrap\Html;

?>

<div class="client-model-search">
	<?php $form = ActiveForm::begin( [
		                                 'action' => [ 'index' ],
		                                 'method' => 'get',
	                                 ] ) ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t( 'system/view', 'Filter' ) ?></div>
        <div class="panel-body">
			<?= $form->field( $model, 'id' ) ?>

			<?= $form->field( $model, 'clientName' ) ?>

			<?= $form->field( $model, 'startDate' ) ?>
			<?= $form->field( $model, 'endDate' ) ?>

        </div>
        <div class="panel-footer">
            <div class="form-group">
				<?= Html::submitButton( Yii::t( 'system/view', 'Search' ), [ 'class' => 'btn btn-primary' ] ) ?>
				<?= Html::a( Yii::t( 'system/view', 'Reset' ), $form->action, [ 'class' => 'btn btn-default' ] ) ?>
            </div>
        </div>
    </div>
	<?php ActiveForm::end() ?>
</div>
