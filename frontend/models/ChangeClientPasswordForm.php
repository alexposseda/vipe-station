<?php

	namespace frontend\models;

	use common\models\ClientModel;
	use Yii;
	use yii\base\Model;

	class ChangeClientPasswordForm extends Model{
		public $client_id;
		public $old_password;
		public $password;
		public $password_repeat;

		/**
		 * @inheritdoc
		 */
		public function rules() {
			return [
				[
					[
						'password',
						'password_repeat',
						'old_password'
					],
					'required'
				],
				[
					[ 'password', 'old_password' ],
					'string',
					'min' => 6
				],
				[ 'old_password', 'compareOldPass' ],
				[
					'password',
					'compare'
				]
			];
		}

		public function attributeLabels() {
			return [
				'old_password'    => Yii::t( 'models/authorize', 'Old password' ),
				'password_repeat' => Yii::t( 'models/authorize', 'New password' ),
				'password'        => Yii::t( 'models/authorize', 'Password repeat' ),
			];
		}

		public function compareOldPass() {
			if ( ! empty( $this->old_password ) && ! empty( $this->client_id ) ) {
				$client = ClientModel::findOne( $this->client_id );
				if ( ! $client && ! ( Yii::$app->security->generatePasswordHash( $this->old_password ) == $client->user->password_hash ) ) {
					$this->addError( 'old_password', Yii::t( 'models/authorize', 'Old password not correctly' ) );
				}
			}
		}
	}