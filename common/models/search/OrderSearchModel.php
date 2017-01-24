<?php

	namespace common\models\search;

	use common\models\OrderModel;
	use yii\data\ActiveDataProvider;
	use yii\data\Sort;

	class OrderSearchModel extends OrderModel{
		public $clientName;
		public $startDate;
		public $endDate;

		/**
		 * @inheritdoc
		 */
		public function rules() {
			return [
				[ [ 'id', 'startDate', 'endDate', 'clientName' ], 'safe' ],
			];
		}

		/**
		 * Creates data provider instance with search query applied
		 *
		 * @param array $params
		 *
		 * @return ActiveDataProvider
		 */
		public function search( $params ) {
			$query = OrderModel::find()
			                   ->alias( 'od' );

			$dataProvider = new ActiveDataProvider( [
				                                        'query' => $query,
				                                        'sort'  => new Sort( [
					                                                             'attributes' => [
						                                                             'id',
						                                                             'name',
						                                                             'created_at'
					                                                             ]
				                                                             ] )
			                                        ] );

			$this->load( $params );

			if ( ! $this->validate() ) {
				return $dataProvider;
			}

			if ( ! empty( $this->startDate ) || ! empty( $this->endDate ) ) {
				if ( empty( $this->startDate ) && ! empty( $this->endDate ) ) {
					$this->startDate = $this->endDate;
				}
				if ( empty( $this->endDate ) && ! empty( $this->startDate ) ) {
					$this->endDate = date('d.m.Y');
				}
				$query->andFilterWhere( [
					                        'and',
					                        'od.created_at<=' . (strtotime( $this->endDate )+86400),
					                        'od.created_at>=' . (strtotime( $this->startDate )+86400)
				                        ] );
			}

			if ( ! empty( $this->clientName ) ) {
				$query->joinWith( 'orderClientData ocd' )
				      ->andFilterWhere( [ 'like', 'ocd.name', $this->clientName ] );
			}

			$query->andFilterWhere( [ 'od.id' => $this->id ] );

			return $dataProvider;
		}

	}