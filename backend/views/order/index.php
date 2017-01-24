<?php
	/**
	 * @var $this        \yii\web\View
	 * @var $orders      \yii\data\ActiveDataProvider
	 * @var $searchOrder OrderSearchModel
	 */
	use common\models\search\OrderSearchModel;
	use yii\bootstrap\Html;
	use yii\grid\GridView;
	use yii\helpers\Url;
	use yii\widgets\Pjax;
?>

<?php Pjax::begin() ?>
<div class="row">
    <div class="col-md-12 col-lg-3">
        <p>
			<?= Html::a( Yii::t( 'system/view', 'Create' ) . ' ' . Yii::t( 'models/client', 'Client' ), [ 'create' ],
			             [ 'class' => 'btn btn-success' ] ) ?>
			<?= $this->render( '_search', [ 'model' => $searchOrder ] ); ?>
        </p>
    </div>
    <div class="col-md-12 col-lg-9">
		<?= GridView::widget( [
			                      'dataProvider' => $orders,
			                      'filterModel'  => null,
			                      'layout'       => "{summary}\n<div class='table-responsive'>\n{items}\n</div>\n{pager}",
			                      'columns'      => [
				                      [
					                      'attribute'      => 'id',
				                      ],
				                      [
					                      'attribute'      => 'status',
					                      'content'        => function( $data ) {
						                      return Yii::t( 'models/order', $data->status );
					                      }
				                      ],
				                      [
					                      'attribute'      => 'orderClientData.client.name',
					                      'content'        => function( $data ) {
						                      /** @var \common\models\OrderModel $data */
						                      return Html::a( $data->orderClientData->client->name,
						                                      [ '/client/view', 'id' => $data->orderClientData->client_id ] );
					                      }
				                      ],
				                      [
					                      'attribute'      => 'delivery.name',
				                      ],
				                      [
					                      'attribute'      => 'delivery.price',
					                      'content'        => function( $data ) {
						                      /** @var \common\models\OrderModel $data */
						                      return $data->delivery->price == 0 ? '<span class="text-success">' . Yii::t( 'models/order',
						                                                                                                   'Free delivery' ) . '</span>' : $data->delivery->price;
					                      }
				                      ],
				                      [
					                      'attribute'      => 'payment.name',
				                      ],
				                      [
					                      'attribute'      => 'total_cost',
				                      ],
				                      [
					                      'attribute'      => 'created_at',
					                      'format'         => [
						                      'date',
						                      'H:m:s dd.MM.Y'
					                      ],
				                      ],
				                      [
					                      'attribute'      => 'updated_at',
					                      'format'         => [
						                      'date',
						                      'H:m:s dd.MM.Y'
					                      ],
				                      ],

				                      [
					                      'class'          => 'yii\grid\ActionColumn',
				                      ],
			                      ]
		                      ] ); ?>
    </div>
	<?php Pjax::end() ?>
</div>
    <a href="<?= Url::to( [ 'cart/index' ] ) ?>" class="btn btn-sm btn-success pull-right">
        Перейти в корзину
    </a>
