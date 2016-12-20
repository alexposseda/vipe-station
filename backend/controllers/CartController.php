<?php

    namespace backend\controllers;

    use Behat\Gherkin\Exception\Exception;
    use Yii;
    use common\models\CartModel;
    use yii\data\ActiveDataProvider;
    use yii\web\Controller;
    use yii\web\Cookie;
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

        /**
         * Lists all CartModel models.
         * @return mixed
         */
        public function actionIndex(){
            $cartDataProvider = new ActiveDataProvider(['query' => CartModel::find()]);

            return $this->render('index', ['dataProvider' => $cartDataProvider]);
        }

        public function actionAddToCart($product_id, $options, $quantity){
            $cart = new CartModel();
            $cart->setID();

            $cart->product_id = $product_id;
            $cart->options = $options;
            $cart->quantity = $quantity;
            if($cart->save()){
                return true;
            }
            Yii::$app->session->setFlash('error', 'Error save cart');

            return false;
        }

        public function actionLogin(){
            /** @var CartModel[] $cart */
            $guest_id = Yii::$app->session->get('guest_id');
            if(!$guest_id){
                $guest_id = Yii::$app->request->cookies->getValue('guest_id');
            }
            $cart = CartModel::find()
                             ->Where(['guest_id' => $guest_id])
                             ->all();

            if(!empty($cart)){
                $id = Yii::$app->user->id;
                foreach($cart as $obj){
                    $obj->user_id = $id;
                    $obj->guest_id = null;
                    if($obj->save()){
                        return true;
                    }
                    Yii::$app->session->setFlash('error', 'Not save cart');
                }
            }
        }


        /**
         * Deletes an existing CartModel model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionDelete($id){
            $this->findModel($id)
                 ->delete();

            return $this->redirect(['index']);
        }

        /**
         * Finds the CartModel model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return CartModel the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
            if(($model = CartModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }
