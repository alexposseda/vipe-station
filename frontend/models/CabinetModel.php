<?php

	namespace frontend\models;

	use common\models\forms\DeliveryAddressForm;
	use common\models\UserIdentity;
	use yii\base\Model;
	use yii\data\ActiveDataProvider;

	class CabinetModel extends Model{
		public $model;
		public $passModel;
		public $ordersProvider;
		public $deliveryModel;

		public function __construct( $user_id, array $config = [] ) {
			if ( ! empty( $user_id ) ) {
				$user = UserIdentity::findOne( $user_id );
				if ( $user && $this->model = $user->client ) {
					$this->passModel      = new ChangeClientPasswordForm();
					$this->deliveryModel  = new DeliveryAddressForm();
					$this->ordersProvider = new ActiveDataProvider( [ 'query' => $this->model->getOrderClientDatas() ] );
				}
			} else {
				return null;
			}
			parent::__construct( $config );
		}

		public function load( $data, $formName = null ) {
			$success = false;
			if ( array_key_exists( $this->passModel->formName(), $data ) ) {
				$success = $this->passModel->load( $data ) && $this->passModel->validate();
			}
			if ( array_key_exists( $this->deliveryModel->formName(), $data ) ) {
				$success                    = true;
			}
			if ( array_key_exists( $this->model->formName(), $data ) ) {
				$success = $this->model->load( $data ) && $this->model->validate();
			}

			return $success;
		}

		public function save() {
			$success = false;
			if ( $this->model ) {
				$success = $this->model->save();
			}
			if ( $this->passModel ) {
				$success = $this->passModel->changePass();
			}

			return $success;
		}
	}