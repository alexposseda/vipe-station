<?php

	namespace frontend\models;

	use common\models\ClientModel;
	use common\models\UserIdentity;
	use Yii;
	use yii\base\Model;

	class ChangeClientPasswordForm extends Model{
		public $user_id;
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
						'user_id',
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
			if ( ! empty( $this->old_password ) && ! empty( $this->user_id ) ) {
				$user = UserIdentity::findOne( $this->user_id );
				if ( ! $user && ! $user->validatePassword( $this->old_password ) ) {
					$this->addError( 'old_password', Yii::t( 'models/authorize', 'Old password not correctly' ) );
				}
			}
		}

		public function changePass() {
			$user = UserIdentity::findOne( $this->user_id );
			if ( $user ) {
				$user->setPassword( $this->password );

				return $user->save();
			}

			return false;
		}
	}