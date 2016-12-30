<?php

    namespace backend\controllers;

    use backend\models\forms\CategoryForm;
    use common\models\ProductCharacteristicModel;
    use common\models\SeoModel;
    use Yii;
    use common\models\CategoryModel;
    use common\models\search\CategorySearchModel;
    use yii\filters\AccessControl;
    use yii\helpers\ArrayHelper;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * CategoryController implements the CRUD actions for CategoryModel model.
     */
    class CategoryController extends Controller{
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
                        'delete'                            => ['POST'],
                        'get-characteristics-from-category' => ['POST'],
                    ],
                ],
            ];
        }

        /**
         * Lists all CategoryModel models.
         * @return mixed
         */
        public function actionIndex(){
            $searchModel = new CategorySearchModel();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single CategoryModel model.
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
         * Creates a new CategoryModel model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate(){
            $model = new CategoryForm([
                                          'category' => new CategoryModel(),
                                          'seo'      => new SeoModel()
                                      ]);

            if(Yii::$app->request->isPost && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->category->id
                                       ]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }

        /**
         * Updates an existing CategoryModel model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate($id){
            $category = $this->findModel($id);

            $seo = ($category->seo) ? $category->seo : new SeoModel();
            $model = new CategoryForm([
                                          'category' => $category,
                                          'seo'      => $seo
                                      ]);

            if(Yii::$app->request->isPost && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->category->id
                                       ]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing CategoryModel model.
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
         * Finds the CategoryModel model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return CategoryModel the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
            if(($model = CategoryModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException(Yii::t('system/error', 'The requested page does not exist.'));
            }
        }

        public function getParentCharacteristic($id){
            $parentCategory = $this->findModel($id);
            $parentCharacteristics = $parentCategory->productCharacteristics ? $parentCategory->productCharacteristics : [];

            return $parentCharacteristics;
        }

        public function actionGetCharacteristicsFromCategory(){
            $id = Yii::$app->request->post('category_id');
            $characteristicModels = ProductCharacteristicModel::find()
                                                              ->where(['category_id' => $id])
                                                              ->asArray()
                                                              ->all();

            return json_encode($characteristicModels);
        }

        public function actionDelCharacteristic($id){
            $model = ProductCharacteristicModel::findOne($id);
            if(!is_null($model)){
                $model->delete();
                return true;
            }

            return false;
        }
        /*public function addCharacteristic($category_id){
            $characterisic = new ProductCharacteristicModel();
            if($characterisic->load(Yii::$app->request->post()) && $characterisic->save()){
                return $this->redirect([
                                           'update',
                                           'id' => $category_id,
                                       ]);
            }
            //            return $this->renderAjax();
        }*/
    }
