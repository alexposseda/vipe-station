<?php

    namespace backend\controllers;

    use common\models\forms\CartForm;
    use Yii;
    use common\models\CartModel;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

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
                'access' => [
                    'class'        => AccessControl::className(),
                    'denyCallback' => function($rule, $action){
                        throw new UnauthorizedHttpException(Yii::t('system/error', 'You do not have access to this page'));
                    },
                    'rules'        => [
                        [
                            'allow' => true,
                            'roles' => ['admin','manager']
                        ]
                    ]
                ]
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

        public function actionAddToCart(){
            $cartForm = new CartForm();
            if($cartForm->load(Yii::$app->request->post()) && $cartForm->add()){
                Yii::$app->session->setFlash('success', 'Добавлено в корзину');

                return $this->redirect(Yii::$app->request->referrer);
            }
            Yii::$app->session->setFlash('error', 'Error save cart');

            return false;
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
            Yii::$app->cache->flush();
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
