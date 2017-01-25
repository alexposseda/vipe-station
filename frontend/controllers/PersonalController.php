<?php

	namespace frontend\controllers;

	use frontend\models\CabinetModel;
	use Yii;
	use yii\web\Controller;

	class PersonalController extends Controller{

		public function actionIndex() {
			$cabinet = new CabinetModel( Yii::$app->user->id );
			if ( is_null( $cabinet ) ) {
				return $this->redirect( Yii::$app->request->referrer );
			}
			if ( $cabinet->load( Yii::$app->request->post() ) && $cabinet->save() ) {

			}

			return $this->render( 'index', compact( 'cabinet' ) );
		}
	}