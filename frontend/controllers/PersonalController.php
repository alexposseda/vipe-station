<?php

	namespace frontend\controllers;

	use yii\web\Controller;

	class PersonalController extends Controller{

		public function actionIndex() {
			return $this->render('index');
			return $this->redirect( \Yii::$app->request->referrer );
		}
	}