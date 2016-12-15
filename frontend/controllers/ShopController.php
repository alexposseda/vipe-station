<?php

    namespace frontend\controllers;

    use common\models\ProductModel;
    use common\models\search\ProductSearchModel;
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

            $popular = ProductModel::find()
                                   ->orderBy(['sales' => SORT_DESC])
                                   ->limit(10);

            $newest = ProductModel::find()
                                  ->orderBy(['created_at' => SORT_DESC])
                                  ->limit(10);

            return $this->render('catalog', ['popular' => $popular, 'newest' => $newest]);
        }

    }