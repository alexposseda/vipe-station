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

            return $this->render('catalogAll', ['catalog' => $catalog]);
        }

        public function actionCatalog(){

            $popular = ProductModel::find()
                                   ->orderBy(['sales' => SORT_DESC])
                                   ->limit(4)
                                   ->all();

            $newest = ProductModel::find()
                                  ->orderBy(['created_at' => SORT_DESC])
                                  ->limit(4)
                                  ->all();

            return $this->render('catalog', ['popular' => $popular, 'newest' => $newest]);
        }

    }