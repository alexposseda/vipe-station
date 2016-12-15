<?php

    namespace backend\controllers;

    use common\models\search\DeliverySearchModel;
    use Yii;
    use common\models\DeliveryModel;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * DeliveryController implements the CRUD actions for DeliveryModel model.
     */
    class DeliveryController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'access' => [
                    'class'        => AccessControl::className(),
                    'denyCallback' => function($rule, $action){
                        throw new UnauthorizedHttpException(Yii::t('system/error', 'You do not have access to this page'));
                    },
                    'rules'        => [
                        [
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                ],
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }

        /**
         * Lists all DeliveryModel models.
         * @return mixed
         */
        public function actionIndex(){
            $searchModel = new DeliverySearchModel();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single DeliveryModel model.
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
         * Creates a new DeliveryModel model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate(){
            $model = new DeliveryModel();

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing DeliveryModel model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate($id){
            $model = $this->findModel($id);

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing DeliveryModel model.
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
         * Finds the DeliveryModel model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return DeliveryModel the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
            if(($model = DeliveryModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException(Yii::t('system/error', 'The requested page does not exist.'));
            }
        }
    }
