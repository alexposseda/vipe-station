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
        }

        public function actionAddToCart($product_id, $options, $quantity){
            $cart = new CartModel();
            if(Yii::$app->user->isGuest){

                $guest_id = Yii::$app->request->getCookies()
                                              ->getValue('guest_id');
                $session_guestId = Yii::$app->session->get('guest_id');
                $cart->guest_id = Yii::$app->security->generateRandomString();
                if(empty($guest_id && $session_guestId)){
                    Yii::$app->response->cookies->add(new Cookie([
                                                                     'name'  => 'guest_id',
                                                                     'value' => $cart->guest_id
                                                                 ]));
                    Yii::$app->session->set('guest_id', $cart->guest_id);
                }

                empty($guest_id) ? $cart->guest_id = $session_guestId : $cart->guest_id = $guest_id;
            }else{
                $cart->user_id = Yii::$app->user->id;
            }
            $cart->product_id = $product_id;
            $cart->options = $options;
            $cart->quantity = $quantity;
            if($cart->save()){
                return true;
            }
            Yii::$app->session->setFlash('error', 'Error save cart');
        }

        public function actionLogin(){
            /** @var CartModel[] $cart */
            $cart = CartModel::find()
                             ->Where(['guest_id' => Yii::$app->session->get('guest_id')])
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
         * Displays a single CartModel model.
         *
         * @param integer $id
         *
         * @return mixed
         */
        //    public function actionView($id)
        //    {
        //        return $this->render('view', [
        //            'model' => $this->findModel($id),
        //        ]);
        //    }

        /**
         * Creates a new CartModel model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        //    public function actionCreate()
        //    {
        //        $model = new CartModel();
        //
        //        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //            return $this->redirect(['view', 'id' => $model->id]);
        //        } else {
        //            return $this->render('create', [
        //                'model' => $model,
        //            ]);
        //        }
        //    }

        /**
         * Updates an existing CartModel model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        //    public function actionUpdate($id)
        //    {
        //        $model = $this->findModel($id);
        //
        //        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //            return $this->redirect(['view', 'id' => $model->id]);
        //        } else {
        //            return $this->render('update', [
        //                'model' => $model,
        //            ]);
        //        }
        //    }

        /**
         * Deletes an existing CartModel model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        //    public function actionDelete($id)
        //    {
        //        $this->findModel($id)->delete();
        //
        //        return $this->redirect(['index']);
        //    }

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
