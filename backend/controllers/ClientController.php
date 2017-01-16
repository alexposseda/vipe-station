<?php

    namespace backend\controllers;

    use common\models\forms\PasswordResetRequestForm;
    use Yii;
    use common\models\ClientModel;
    use common\models\search\ClientSearchModel;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * ClientController implements the CRUD actions for ClientModel model.
     */
    class ClientController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'verbs'  => [
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
                            'roles' => [
                                'admin',
                                'manager'
                            ]
                        ]
                    ]
                ]
            ];
        }

        /**
         * Lists all ClientModel models.
         * @return mixed
         */
        public function actionIndex(){
            
            $searchModel = new ClientSearchModel();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single ClientModel model.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionView($id){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        /**
         * Creates a new ClientModel model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         *
         * @param null $redirect
         *
         * @return mixed
         */
        public function actionCreate($redirect = null){

            $model = new ClientModel();

            if($model->load(Yii::$app->request->post()) && $model->save()){
                if(!is_null($redirect)){
                    return $this->redirect([
                                               $redirect,
                                               'client_id' => $model->id
                                           ]);
                }

                return $this->redirect([
                                           'view',
                                           'id' => $model->id
                                       ]);
            }

            return $this->render('create', ['model' => $model,]);
        }

        /**
         * Updates an existing ClientModel model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate($id){
            $model = $this->findModel($id);

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->id
                                       ]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing ClientModel model.
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
         * Finds the ClientModel model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return ClientModel the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
            if(($model = ClientModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException(Yii::t('system/error', 'The requested page does not exist.'));
            }
        }

        public function actionGetClientData($client_id){
            $client = $this->findModel($client_id);

            return json_encode($client);
        }

        public function actionRequestPasswordReset($email, $goback){
            $model = new PasswordResetRequestForm(['email' => $email]);
            if($model->validate()){
                if($model->sendEmail()){
                    Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                    return $this->redirect($goback);
                }else{
                    Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            }

            return $this->redirect($goback);
        }
    }
