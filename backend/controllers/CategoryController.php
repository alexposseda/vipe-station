<?php

    namespace backend\controllers;

    use backend\models\forms\CategoryForm;
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
                        'delete' => ['POST'],
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
            $category_parent = null;
            $model = new CategoryForm([
                                          'category' => new CategoryModel(),
                                          'seo'      => new SeoModel()
                                      ]);

            $category_array = ArrayHelper::map(CategoryModel::find()
                                                            ->all(), 'id', 'title');

            if($model->loadData(Yii::$app->request->post()) && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->category->id
                                       ]);
            }else{
                return $this->render('create', [
                    'category_parent' => $category_parent,
                    'category_array'  => $category_array,
                    'model'           => $model,
                ]);
            }
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
            $category_array = ArrayHelper::map(CategoryModel::find()
                                                            ->all(), 'id', 'title');
            $seo = ($category->seo) ? $category->seo : new SeoModel();

            $model = new CategoryForm(['category' => $category, 'seo' => $seo]);

            if($model->loadData(Yii::$app->request->post()) && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->category->id
                                       ]);
            }else{
                return $this->render('update', [
                    'category_parent' => !$category->parent ? null : $category->parent0->title,
                    'category_array'  => $category_array,
                    'model'           => $model,
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
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        public function actionGetCharacteristic($id){
            $category = $this->findModel($id);

            $characteristic = ArrayHelper::map($category->productCharacteristics, 'id', 'title');

            return json_encode($characteristic);
        }
    }