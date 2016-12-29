<?php

    namespace backend\controllers;

    use common\models\BrandModel;
    use common\models\CategoryModel;
    use common\models\search\ProductSearchModel;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\web\UnauthorizedHttpException;

    class CatalogController extends Controller{
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
            ];
        }

        public function actionIndex(){
            $searchProduct = new ProductSearchModel();
            $productProvider = $searchProduct->search(Yii::$app->request->queryParams);
            $category_id = Yii::$app->request->get($searchProduct->formName())['category_id'];
            $brand_id = Yii::$app->request->get($searchProduct->formName())['brand_id'];

            if(!empty($category_id)){
                $cat = $this->findModel(CategoryModel::className(), $category_id);
            }

            if(!empty($brand_id)){
                $brand = $this->findModel(BrandModel::className(), $brand_id);
            }

            return $this->render('index', [
                'productProvider' => $productProvider,
                'categories'      => CategoryModel::find()
                                                  ->all(),
                'brands'          => BrandModel::find()
                                               ->all(),
                'currentCategory' => $cat,
                'currentBrand'    => $brand,
                'searchProduct'   => $searchProduct
            ]);
        }

        protected function findModel($modelName, $id){
            $model = $modelName::findOne($id);
            if(is_null($model)){
                throw new NotFoundHttpException('category not found!');
            }

            return $model;
        }

    }