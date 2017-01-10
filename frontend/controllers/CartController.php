<?php

    namespace frontend\controllers;

    use common\models\forms\CartForm;
    use common\models\forms\OrderForm;
    use common\models\OrderModel;
    use Yii;
    use common\models\CartModel;
    use yii\data\ActiveDataProvider;
    use yii\web\ConflictHttpException;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * CartController implements the CRUD actions for CartModel model.
     */
    class CartController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'verbs' => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }


        public function actionIndex(){
            $cartDataProvider = new ActiveDataProvider(['query' => CartModel::find()]);

            return $this->render('index', ['dataProvider' => $cartDataProvider]);
        }

        public function actionAddToCart(){
            $cartForm = new CartForm();
            if($cartForm->load(Yii::$app->request->post()) && $cartForm->add()){
                Yii::$app->session->setFlash('success', 'Добавлено в корзину');

                return count(CartModel::getCart());
            }
            Yii::$app->session->setFlash('error', 'Error save cart');

            return false;
        }

        public function actionLogin(){
            $guest_id = Yii::$app->session->get('guest_id');
            if(!$guest_id){
                $guest_id = Yii::$app->request->cookies->getValue('guest_id');
            }
            $cart = CartModel::findByGuestId($guest_id);

            if(!empty($cart)){
                $id = Yii::$app->user->id;
                foreach($cart as $obj){
                    $obj->user_id = $id;
                    $obj->guest_id = null;
                    if(!$obj->save()){
                        Yii::$app->session->setFlash('error', 'Not save cart');

                        return false;
                    }
                }
            }

            return true;
        }

        public function actionDelete($id){
            $this->findModel($id)
                 ->delete();

            return $this->redirect(['index']);
        }

        protected function findModel($id){
            if(($model = CartModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException(Yii::t('system/view', 'The requested page does not exist.'));
            }
        }

        public function actionCreateOrder(){
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

            return $this->render('order_form', ['order' => $order]);
        }

        public function changeQuantity($product_id){
            $quantity = Yii::$app->request->post('quantity');
            $item = CartModel::getCart($product_id);
            if(!$item){
                return false;
            }
            $model = $item[0];
            $model->quantity = $quantity;
            return $model->save();

        }
    }