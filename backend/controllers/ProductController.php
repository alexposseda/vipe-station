<?php

    namespace backend\controllers;

    use backend\models\forms\ProductForm;
    use backend\models\UploadCover;
    use common\models\CategoryModel;
    use common\models\ProductInCategoryModel;
    use common\models\SeoModel;
    use Yii;
    use common\models\ProductModel;
    use common\models\search\ProductSearchModel;
    use yii\alexposseda\fileManager\actions\RemoveAction;
    use yii\alexposseda\fileManager\actions\UploadAction;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\Response;
    use yii\web\UnauthorizedHttpException;

    /**
     * ProductController implements the CRUD actions for ProductModel model.
     */
    class ProductController extends Controller{
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
                            'roles' => ['admin','manager']
                        ]
                    ]
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function actions(){
            return [
                'upload-gallery' => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'products',
                    'sessionEnable' => true,
                    'uploadModel'   => new UploadCover([
                                                           'validationRules' => [
                                                               'extensions' => 'jpg, png',
                                                               'maxSize'    => 1024 * 500
                                                           ]
                                                       ])
                ],
                'remove-gallery' => [
                    'class' => RemoveAction::className()
                ]
            ];
        }
        /**
         * Lists all ProductModel models.
         * @return mixed
         */
        public function actionIndex(){
            $searchModel = new ProductSearchModel();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single ProductModel model.
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
         * Creates a new ProductModel model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate(){
            $model = new ProductForm([
                                         'product' => new ProductModel(),
                                         'seo'     => new SeoModel()
                                     ]);

            if($model->loadData(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->product->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing ProductModel model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate($id){
            $product = $this->findModel($id);

            $model = new ProductForm([
                                         'product' => $product,
                                         'seo'     => $product->seo ? $product->seo : new SeoModel()
                                     ]);
            if($model->loadData(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->product->id]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing ProductModel model.
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
         * Finds the ProductModel model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return ProductModel the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
            if(($model = ProductModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException(Yii::t('system/error', 'The requested page does not exist.'));
            }
        }

        public function actionGetCharacteristics(){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $categories = Yii::$app->request->post('categories');
            $characteristicsModels = [];
            if(!empty($categories)){
                foreach($categories as $category_id){
                    $characteristicsModels[] = CategoryModel::allCharacteristics($category_id);
                }
            }
            $characteristics = [];
            $unique_els = [];
            foreach($characteristicsModels as $characteristicsFromCategoryModels){
                foreach($characteristicsFromCategoryModels as $ch_m){
                    if(in_array($ch_m->id, $unique_els)){
                        continue;
                    }else{
                        $unique_els[] = $ch_m->id;
                    }
                    $characteristics[] = [
                        'characteristic_id' => $ch_m->id,
                        'title' => $ch_m->title
                    ];
                }
            }

            return $characteristics;
        }

        public function actionGetRelatedProducts(){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $categories = Yii::$app->request->post('categories');
            $productModels = [];
            $products = [];
            if(!empty($categories)){
                foreach($categories as $category_id){
                    $productModels[] = ProductInCategoryModel::find()->where(['category_id' => $category_id])->all();
                }

                foreach($productModels as $productModelCollection){
                    if(!is_array($productModelCollection)){
                        continue;
                    }
                    foreach($productModelCollection as $productModel){
                        $products[] = [
                            'id' => $productModel->product->id,
                            'title' => $productModel->product->title
                        ];
                    }
                }
            }
            return $products;
        }

    }
