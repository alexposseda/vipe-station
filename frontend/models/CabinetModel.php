<?php

	namespace frontend\models;

	use common\models\forms\DeliveryAddressForm;
	use common\models\UserIdentity;
	use yii\base\Model;
	use yii\data\ActiveDataProvider;

	class CabinetModel extends Model{
		public $save_model;
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
				$success          = $this->passModel->load( $data ) && $this->passModel->validate();
				$this->save_model = 'pass';
			}
			if ( array_key_exists( $this->deliveryModel->formName(), $data ) ) {
				$this->save_model = 'client';
				$success          = true;
			}
			if ( array_key_exists( $this->model->formName(), $data ) ) {
				$success          = $this->model->load( $data ) && $this->model->validate();
				$this->save_model = 'client';
			}

			return $success;
		}

		public function save() {
			$success = false;
			switch ($this->save_model){
				case 'pass':
					$success = $this->passModel->changePass();
					break;
				case 'client':
					$success = $this->model->save();
					break;
			}

			return $success;
		}
	}