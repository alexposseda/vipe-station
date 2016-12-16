<?php

    namespace backend\controllers;

    use backend\models\forms\BrandForm;
    use backend\models\UploadCover;
    use common\models\SeoModel;
    use Yii;
    use common\models\BrandModel;
    use common\models\search\BrandSearchModel;
    use yii\alexposseda\fileManager\actions\RemoveAction;
    use yii\alexposseda\fileManager\actions\UploadAction;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * BrandController implements the CRUD actions for BrandModel model.
     */
    class BrandController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete'      => ['POST'],
                        'upload-logo' => ['POST'],
                        'remove-logo' => ['POST'],
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
                            'roles' => ['admin']
                        ]
                    ]
                ]
            ];
        }

        public function actions(){
            return [
                'upload-logo' => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'brands',
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
         * Lists all BrandModel models.
         * @return mixed
         */
        public function actionIndex(){
            $searchModel = new BrandSearchModel();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single BrandModel model.
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
         * Creates a new BrandModel model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate(){
            $model = new BrandForm([
                                       'brand' => new BrandModel(),
                                       'seo'   => new SeoModel()
                                   ]);

            if(Yii::$app->request->isPost && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->brand->id
                                       ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing BrandModel model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate($id){
            $brand = $this->findModel($id);
            $seo = ($brand->seo) ? $brand->seo : new SeoModel();

            $model = new BrandForm([
                                       'brand' => $brand,
                                       'seo'   => $seo
                                   ]);

            if(Yii::$app->request->isPost && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->brand->id
                                       ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing BrandModel model.
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
         * Finds the BrandModel model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return BrandModel the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
                if(($model = BrandModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException(Yii::t('system/error', 'The requested page does not exist.'));
            }
        }
    }
