<?php

    namespace backend\controllers;

    use common\models\search\ProductSearchModel;
    use Yii;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\web\Controller;
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
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }

        public function actionIndex(){
            $searchProduct = new ProductSearchModel();
            $productProvider = $searchProduct->search(Yii::$app->request->queryParams);

            return $this->render('index', ['productProvider' => $productProvider]);
        }

    }