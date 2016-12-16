<?php

    namespace frontend\controllers;

    use common\models\CartModel;
    use Yii;
    use yii\web\Controller;

    class CartController extends Controller{

        public function actionIndex(){
            $carts = CartModel::find()->orderBy(['product_id' => SORT_DESC])->all();
            return $this->render('index');
        }

    }