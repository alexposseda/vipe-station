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
            $catalogSearch = new ProductSearchModel();

            $popular = $catalogSearch->search(Yii::$app->request->queryParams);
            $popular->sort->defaultOrder = ['sales' => SORT_DESC];

            $newest = $catalogSearch->search(Yii::$app->request->queryParams);
            $newest->sort->defaultOrder = ['created_at' => SORT_DESC];

            return $this->render('catalog', ['popular' => $popular, 'newest' => $newest]);
        }

    }