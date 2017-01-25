<?php
	/**
	 * @var $this \yii\web\View
	 */

	use yii\widgets\ActiveForm;
	use yii\widgets\ListView;

	$model     = \common\models\ClientModel::findOne( 5 );
	$passModel = new \frontend\models\ChangeClientPasswordForm();
	$ordersProvider = new \yii\data\ActiveDataProvider( [ 'query' => $model->getOrderClientDatas() ] )
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
					<?= $contactForm->field( $model, 'f_name', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->label( 'Ваше имя' ) ?>
					<?= $contactForm->field( $model, 'l_name', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->label( 'Ваша фамилия' ) ?>
					<?= $contactForm->field( $model, 'phones_arr[0]', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->textInput( [ 'class' => 'input-phone' ] )
					                ->label( 'Телефон' ) ?>
					<?= $contactForm->field( $model, 'birthday', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->input( 'date', [ 'value' => date( 'm/d/Y', $model->birthday ) ] )
					                ->label( 'Дата рождения' ) ?>
                    <!-- У нас нет логина
                    <div class="input-field col s10">
						 <input placeholder="Placeholder" id="first_name" type="text" class="validate input-form">
						 <label for="first_name" class="label-form">Логин</label>
						 <div class="help-block">Message error</div>
					 </div>
					 -->
					<?= $contactForm->field( $model, 'email', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                ->label( 'Email' ) ?>
                </div>
				<?php ActiveForm::end() ?>
            </li>
            <li class="col l4 hide-on-med-and-down cabinet-form">
                <a href="#" class="fs20 fc-orange">Изменение пароля</a>
				<?php $changePasswordForm = ActiveForm::begin( [ 'id' => 'change-pass-form' ] ) ?>
                <div class="row">
					<?= $changePasswordForm->field( $passModel, 'old_password', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                       ->passwordInput( [ 'placeholder' => ' ' ] ) ?>
					<?= $changePasswordForm->field( $passModel, 'password_repeat', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
					                       ->passwordInput( [ 'placeholder' => ' ' ] ) ?>
					<?= $changePasswordForm->field( $passModel, 'password', [ 'options' => [ 'class' => 'col s10 input-field' ] ] )
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
				                      'dataProvider' => $ordersProvider,
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
        <div class="col l3 m5 s5 cabinet-client fs20">
            <span>Иван Иванов</span><br>
            <span class="fc-brown">+3066666666</span><br>
            <span class="fc-brown">Киев</span><br>
            <span class="fc-brown">улю Горького 177</span><br>
        </div>

        <div class="col l4 m5 cabinet-form">
            <a href="#" class="fs20 fc-orange">Добавления нового адреса</a>

            <form class="row">
                <div class="input-field col s10">
                    <input placeholder="Placeholder" id="first_name" type="text" class="validate input-form error">
                    <label for="first_name" class="label-form">Имя получателя</label>
                    <div class="help-block help-block-error">Message error</div>
                </div>
                <div class="input-field col s10">
                    <input placeholder="Placeholder" id="first_name" type="text" class="validate input-form">
                    <label for="first_name" class="label-form">Фамилия получателя</label>
                    <div class="help-block">Message error</div>
                </div>
                <div class="input-field col s10">
                    <input placeholder="Placeholder" id="first_name" type="text" class="validate input-form">
                    <label for="first_name" class="label-form">Город</label>
                    <div class="help-block">Message error</div>
                </div>
                <div class="input-field col s10">
                    <input placeholder="Placeholder" id="first_name" type="text" class="validate input-form">
                    <label for="first_name" class="label-form">Адрес</label>
                    <div class="help-block">Message error</div>
                </div>
                <div class="input-field col s10">
                    <input placeholder="Placeholder" id="first_name" type="text" class="validate input-form">
                    <label for="first_name" class="label-form">Телефон</label>
                    <div class="help-block">Message error</div>
                </div>
            </form>
        </div>
        <div class="col l12 pull-m2 center-align fs20"><input value="Сохранить" type="submit" class="btn-save"></div>
    </div>
</div>
