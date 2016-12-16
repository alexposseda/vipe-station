<?php

    namespace frontend\controllers;

    use common\models\ProductModel;
    use common\models\search\BrandSearchModel;
    use common\models\search\ProductSearchModel;
    use frontend\models\SendMailForm;
    use Yii;
    use yii\web\Controller;

    class ShopController extends Controller{

        public function actionCatalogAll(){
            $catalogSearch = new ProductSearchModel();
            $catalog = $catalogSearch->search(Yii::$app->request->queryParams);
            $catalog->pagination->pageSize = 8;

            return $this->render('catalogAll', ['catalog' => $catalog]);
        }

        public function actionCatalog(){
            $catalogSearch = new ProductSearchModel();

            $popular = $catalogSearch->search(Yii::$app->request->queryParams);
            $popular->sort->defaultOrder = ['sales' => SORT_DESC];

            $brands = (new BrandSearchModel())->search(Yii::$app->request->queryParams);
            $brands->sort->defaultOrder = ['title' => SORT_DESC];

            return $this->render('catalog', ['popular' => $popular, 'brands' => $brands]);
        }

        public function actionSendMail(){
            $model = new SendMailForm();
            if($model->load(Yii::$app->request->post())&&$model->send()){
                //todo сделать оповещение пользователя об успешном заказе
            }
            return $this->goBack(Yii::$app->request->post('submit'));
        }
    }