<?php
	/**
	 * @var $this    \yii\web\View
	 * @var $cabinet \frontend\models\CabinetModel
	 */

	use yii\widgets\ActiveForm;
	use yii\widgets\ListView;

?>

<div class="row cabinet">
    <img src="../images/close.png" alt="" class="img-close">
    <div class="col l12">
        <ul class="row center-align nav-cabinet tabs">
            <li class="tab col l3 m12 s12 push-s6 push-m6 black-text fs20 left-align"><a href="#contact-info">Контактная информация</a></li>
            <li class="tab col m12 s12 push-s6 push-m6 black-text hide-on-large-only left-align fs20"><a href="#change-password">Изменения пароля</a>
            </li>
            <li class="tab col l3 m10 s12 push-s6  push-m6 black-text left-align fs20"><a href="#history-orders">История заказов</a></li>
            <li class="tab col l3 m12 s12 black-text fs20"><a href="#delivery-address">Адрес доставки</a></li>
        </ul>
    </div>
    <div id="contact-info" class="col l12 ">
        <ul class="row">
            <li class="col l4 hide-on-med-and-down">
                <img src="../images/cabinet3.png" alt="" class="img-cabinet3">
            </li>
            <li class="col l4 cabinet-form">
                <a href="#" class="fs20 fc-orange">Редактирование личных данных</a>
				<?php $contactForm = ActiveForm::begin( [ 'id' => 'contact-form' ] ) ?>
                <div class="row">
					<?= $contactForm->field( $cabinet->model, 'f_name', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->label( 'Ваше имя' ) ?>
					<?= $contactForm->field( $cabinet->model, 'l_name', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->label( 'Ваша фамилия' ) ?>
					<?= $contactForm->field( $cabinet->model, 'phones_arr[0]', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->textInput( [ 'class' => 'input-phone' ] )
					                ->label( 'Телефон' ) ?>
					<?= $contactForm->field( $cabinet->model, 'birthday', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->input( 'date', [ 'value' => date( 'm/d/Y', $cabinet->model->birthday ) ] )
					                ->label( 'Дата рождения' ) ?>
                    <!-- У нас нет логина
                    <div class="input-field col s10">
						 <input placeholder="Placeholder" id="first_name" type="text" class="validate input-form">
						 <label for="first_name" class="label-form">Логин</label>
						 <div class="help-block">Message error</div>
					 </div>
					 -->
					<?= $contactForm->field( $cabinet->model, 'email', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->label( 'Email' ) ?>
                </div>
				<?php ActiveForm::end() ?>
            </li>
            <li class="col l4 hide-on-med-and-down cabinet-form">
                <a href="#" class="fs20 fc-orange">Изменение пароля</a>
				<?php $changePasswordForm = ActiveForm::begin( [ 'id' => 'change-pass-form' ] ) ?>
                <div class="row">
					<?= $changePasswordForm->field( $cabinet->passModel, 'old_password', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                       ->passwordInput( [ 'placeholder' => ' ' ] ) ?>
					<?= $changePasswordForm->field( $cabinet->passModel, 'password_repeat', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                       ->passwordInput( [ 'placeholder' => ' ' ] ) ?>
					<?= $changePasswordForm->field( $cabinet->passModel, 'password', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                       ->passwordInput( [ 'placeholder' => ' ' ] ) ?>
                </div>
				<?php ActiveForm::end() ?>
            </li>
        </ul>
    </div>
    <div id="history-orders">
        <div class="col l12"><span class="fs20 fc-orange">Ваши заказы</span>
            <hr>
        </div>
        <div class="col l12">
			<?= ListView::widget( [
				                      'dataProvider' => $cabinet->ordersProvider,
				                      'itemView'     => '_orderItem',
				                      'itemOptions'  => [ 'class' => 'row', 'tag' => 'ul' ]
			                      ] ) ?>
            <hr>
        </div>
    </div>
    <div id="delivery-address">
        <div class="col l5 m7 hide-on-small-only center-align">
            <img src="../images/cabinet1.png" alt="" class="img-cabinet">
        </div>
		<?php $deliveryForm = ActiveForm::begin( [ 'id' => 'delivery-form' ] ) ?>
        <div class="col l3 m5 s5 fs20">
			<?php if ( ! empty( $cabinet->model->deliveryData ) ): ?>
				<?php foreach ( $cabinet->model->deliveryData as $deliverIndex => $delivery ) : ?>
                    <div class="cabinet-client">
                        <span><?= $delivery->name ?></span><br>
                        <span class="fc-brown"><?= $delivery->phone ?></span><br>
                        <span class="fc-brown"><?= $delivery->city ?></span><br>
                        <span class="fc-brown"><?= $delivery->address ?></span><br>
                    </div>
                    <div class="hide">
						<?= $deliveryForm->field( $delivery, "[$deliverIndex]f_name", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
						                 ->textInput( [ 'placeholder' => Yii::t( 'models/client', 'First name' ), ] )
						                 ->label( 'Имя получателя' ) ?>
						<?= $deliveryForm->field( $delivery, "[$deliverIndex]l_name", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
						                 ->textInput( [ 'placeholder' => Yii::t( 'models/client', 'Last name' ), ] )
						                 ->label( 'Фамилия получателя' ) ?>
						<?= $deliveryForm->field( $delivery, "[$deliverIndex]city", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
						                 ->textInput( [ 'placeholder' => Yii::t( 'models/client', 'City' ), ] )
						                 ->label( 'Город' ) ?>
						<?= $deliveryForm->field( $delivery, "[$deliverIndex]address", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
						                 ->textInput( [ 'placeholder' => Yii::t( 'models/client', 'Address' ), ] )
						                 ->label( 'Адрес' ) ?>
						<?= $deliveryForm->field( $delivery, "[$deliverIndex]phone", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
						                 ->textInput( [
							                              'class'       => 'input-phone',
							                              'placeholder' => Yii::t( 'models/client', 'Phone' ),
						                              ] )
						                 ->label( 'Телефон' ) ?>

                    </div>
				<?php endforeach; ?>
			<?php endif; ?>
        </div>

        <div class="col l4 m5 cabinet-form">
            <a href="#" class="fs20 fc-orange">Добавления нового адреса</a>
            <div class="row">
				<?php $deliverIndex = isset( $deliverIndex ) ? $deliverIndex+1 : 0 ?>
				<?= $deliveryForm->field( $cabinet->deliveryModel, "[$deliverIndex]f_name", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
				                 ->textInput( [ 'placeholder' => Yii::t( 'models/client', 'First name' ), ] )
				                 ->label( 'Имя получателя' ) ?>
				<?= $deliveryForm->field( $cabinet->deliveryModel, "[$deliverIndex]l_name", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
				                 ->textInput( [ 'placeholder' => Yii::t( 'models/client', 'Last name' ), ] )
				                 ->label( 'Фамилия получателя' ) ?>
				<?= $deliveryForm->field( $cabinet->deliveryModel, "[$deliverIndex]city", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
				                 ->textInput( [ 'placeholder' => Yii::t( 'models/client', 'City' ), ] )
				                 ->label( 'Город' ) ?>
				<?= $deliveryForm->field( $cabinet->deliveryModel, "[$deliverIndex]address", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
				                 ->textInput( [ 'placeholder' => Yii::t( 'models/client', 'Address' ), ] )
				                 ->label( 'Адрес' ) ?>
				<?= $deliveryForm->field( $cabinet->deliveryModel, "[$deliverIndex]phone", [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
				                 ->textInput( [
					                              'class'       => 'input-phone',
					                              'placeholder' => Yii::t( 'models/client', 'Phone' ),
				                              ] )
				                 ->label( 'Телефон' ) ?>
            </div>
            <div class="col l12 pull-m2 center-align fs20"><input value="Сохранить" type="submit" class="btn-save"></div>
        </div>

		<?php ActiveForm::end() ?>
    </div>
</div>
