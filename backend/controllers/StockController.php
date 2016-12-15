<?php

    namespace backend\controllers;

    use backend\models\forms\CategoryForm;
    use backend\models\forms\StockForm;
    use backend\models\UploadCover;
    use common\models\ProductCharacteristicModel;
    use common\models\ProductModel;
    use common\models\SeoModel;
    use common\models\StockModel;
    use Yii;
    use common\models\CategoryModel;
    use common\models\search\CategorySearchModel;
    use yii\alexposseda\fileManager\actions\RemoveAction;
    use yii\alexposseda\fileManager\actions\UploadAction;
    use yii\caching\DbDependency;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * CategoryController implements the CRUD actions for StockModel model.
     */
    class StockController extends Controller{
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
                            'roles' => [
                                'admin',
                                'manager'
                            ],
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

        public function actions(){
            return [
                'upload-logo' => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'stock',
                    'sessionEnable' => true,
                    'uploadModel'   => new UploadCover([
                                                           'validationRules' => [
                                                               'extensions' => 'jpg, png',
                                                               'maxSize'    => 1024 * 500
                                                           ]
                                                       ])
                ],
                'remove-logo' => [
                    'class' => RemoveAction::className()
                ]
            ];
        }


        /**
         * Lists all StockModel models.
         * @return mixed
         */
        public function actionIndex(){
            //            $searchModel = new CategorySearchModel();
            //            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider = new ActiveDataProvider([
                                                       'query' => StockModel::find()
                                                   ]);

            return $this->render('index', [
                //                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single StockModel model.
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
         * Creates a new StockModel model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         *
         * @return mixed
         */
        public function actionCreate(){
            $model = new StockForm([
                                       'stock' => new StockModel()
                                   ]);

            if($model->loadData(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['index']);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }

        public function actionRenderAjax($police_id, $stock_value = null){
            $model = new StockModel();

            switch($police_id){
                case '1':
                    $model->stock_value = $stock_value;
                    return $this->renderAjax('policy/discount', ['model' => $model]);
                    break;
                case '2':
                    $all_products = ProductModel::getDb()
                                                ->cache(function(){
                                                    return ProductModel::find()
                                                                       ->all();
                                                }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.ProductModel::tableName()]));

                    return $this->renderAjax('policy/gift',
                                             ['model' => $model, 'stock_value' => json_decode($stock_value), 'all_products' => $all_products]);
                    break;
            }
        }

        /**
         * Updates an existing StockModel model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate($id){
            $model = new StockForm([
                                       'stock' => $this->findModel($id)
                                   ]);

            if($model->loadData(Yii::$app->request->post()) && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->stock->id
                                       ]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }

        /**
         * Deletes an existing StockModel model.
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
         * Finds the StockModel model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return StockModel the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
            if(($model = StockModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException(Yii::t('system/error', 'The requested page does not exist.'));
            }
        }


    }
