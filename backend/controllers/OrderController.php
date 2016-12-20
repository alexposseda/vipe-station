<?php

    namespace backend\controllers;

    use backend\models\forms\OrderForm;
    use common\models\CartModel;
    use common\models\OrderModel;
    use Yii;
    use yii\web\Controller;

    class OrderController extends Controller{

        public function actionCreate(){
            $order = new OrderForm([
                                       'carts' => CartModel::getCart(),
                                       'order' => new OrderModel()
                                   ]);

            if($order->loadAll(Yii::$app->request->post()) && $order->save()){
                Yii::$app->session->addFlash('success', 'Заказа оформлен');
            }

            return $this->render('create', ['order' => $order]);
        }

        public function actionUpdate($id){
            $order = new OrderForm([
                                       'order' => OrderModel::findOne($id)
                                   ]);
            if($order->loadAll(Yii::$app->request->post()) && $order->save()){
                Yii::$app->session->addFlash('success', 'Заказа изменен');
            }
            return $this->render('create', ['order' => $order]);
        }
    }