<?php

    namespace backend\controllers;

    use backend\models\forms\OrderForm;
    use common\models\CartModel;
    use common\models\OrderModel;
    use Yii;
    use yii\data\ActiveDataProvider;
    use yii\web\ConflictHttpException;
    use yii\web\Controller;

    class OrderController extends Controller{

        public function actionIndex(){
            $orders = new ActiveDataProvider(['query' => OrderModel::find()]);

            return $this->render('index', ['orders' => $orders]);
        }

        public function actionCreate(){
            $carts = CartModel::getCart();
            if(empty($carts)){
                throw new ConflictHttpException(Yii::t('models/order', 'Cart is empty'));
            }
            $order = new OrderForm([
                                       'carts' => CartModel::getCart(),
                                       'order' => new OrderModel()
                                   ]);

            if($order->loadAll(Yii::$app->request->post()) && $order->save()){
                Yii::$app->session->addFlash('success', 'Заказ №'.$order->order->id.' оформлен');

                return $this->redirect(['index']);
            }

            return $this->render('create', ['order' => $order]);
        }

        public function actionUpdate($id){
            $order = new OrderForm([
                                       'order' => OrderModel::findOne($id)
                                   ]);
            if($order->loadAll(Yii::$app->request->post()) && $order->save()){
                Yii::$app->session->addFlash('success', 'Заказ №'.$order->order->id.' изменен');

                return $this->redirect(['index']);
            }

            return $this->render('update', ['order' => $order]);
        }
    }